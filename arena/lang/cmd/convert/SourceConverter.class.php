<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.collections.HashTable');

  /**
   * Converts sourcecode to XP Language
   *
   * @test     xp://tests.convert.**
   */
  class SourceConverter extends Object {
    public
      $nameMap       = NULL;

    // XP tokens
    const
      T_USES          = 0xF001,
      T_NEWINSTANCE   = 0xF002,
      T_IS            = 0xF003,
      T_CREATE        = 0xF004,
      T_RAISE         = 0xF005,
      T_FINALLY       = 0xF006,
      T_DELETE        = 0xF007,
      T_WITH          = 0xF008,
      T_REF           = 0xF009,
      T_DEREF         = 0xF00A,
      T_CAST          = 0xF00B,
      T_TRUE          = 0xF00C,
      T_FALSE         = 0xF00D,
      T_NULL          = 0xF00E;
    
    // States
    const
      ST_INITIAL      = 'init',
      ST_DECL         = 'decl',
      ST_FUNC         = 'func',
      ST_FUNC_ARGS    = 'farg',
      ST_INTF         = 'intf',
      ST_CLASS        = 'clss',
      ST_EXTENDS      = 'extn',
      ST_USES         = 'uses',
      ST_ANONYMOUS    = 'anon',
      ST_NAMESPACE    = 'nspc',
      ST_ARRAY        = 'aray',
      ST_PARAMS       = 'parm',
      ST_FUNC_BODY    = 'body',
      ST_WITH         = 'with',
      ST_FOREACH      = 'forx',
      ST_CREATE       = 'crea',
      ST_ANNOTATIONS  = 'anno',
      ST_FIELD_INIT   = 'init';
    
    const
      SEPARATOR       = '.';

    /**
     * Creates name map
     *
     */
    public function __construct() {
      $this->nameMap= create('new util.collections.HashTable<String, String>()');
    }

    /**
     * Returns a token array
     *
     * @param   mixed t
     * @return  array
     */
    protected function tokenOf($t, $last= NULL) {
      static $map= array(
        'uses'          => self::T_USES,
        'newinstance'   => self::T_NEWINSTANCE,
        'is'            => self::T_IS,
        'create'        => self::T_CREATE,
        'raise'         => self::T_RAISE,
        'cast'          => self::T_CAST,
        'finally'       => self::T_FINALLY,
        'delete'        => self::T_DELETE,
        'with'          => self::T_WITH,
        'ref'           => self::T_REF,
        'deref'         => self::T_DEREF,
        'true'          => self::T_TRUE,
        'false'         => self::T_FALSE,
        'null'          => self::T_NULL,
      );

      $normalized= is_array($t) ? $t : array($t, $t);
      $lookup= strtolower($normalized[1]);
      if (
        (!is_array($last) || $last[0] !== T_OBJECT_OPERATOR) &&
        T_STRING == $normalized[0] && isset($map[$lookup])
      ) {
        $normalized[0]= $map[$lookup];
      }
      return $normalized;
    }
    
    /**
     * Maps a name to its fully qualified name
     *
     * @param   string qname in dot-notation (package.Name)
     * @param   string namespace default NULL in colon-notation
     * @param   array<string, bool> imports
     * @param   string context
     * @return  string in colon-notation (package::Name)
     */
    protected function mapName($qname, $namespace= NULL, array $imports= array(), $context= '?') {
      $qname= ltrim($qname, '&');
      if (NULL === ($mapped= $this->nameMap[$qname])) {

        // If the searched class resides in the same namespace, it does not
        // need to be fully qualified or mapped, so check for this
        $search= ($namespace !== NULL ? str_replace(self::SEPARATOR, '.', $namespace).'.' : '').$qname;
        if (!ClassLoader::getDefault()->findClass($search) instanceof IClassLoader) {
          return $qname;
          // throw new IllegalStateException('*** No mapping for '.$qname.' (current namespace: '.$namespace.', class= '.$context.')');
        }
        return $qname;
      }

      // Return local name if mapped name is in imports or current namespace
      if (isset($imports[(string)$mapped])) {
        return $imports[(string)$mapped]; 
      } else if (FALSE !== ($p= strrpos($mapped, self::SEPARATOR)) && $namespace == substr($mapped, 0, $p)) {
        return substr($mapped, $p+ 2);
      } else {
        return $mapped;
      }
    }

    /**
     * Convert sourcecode and return the computed version
     *
     * @param   string qname fully qualified name of class
     * @param   array t tokens as returned by token_get_call
     * @param   string initial default ST_INITIAL
     * @return  string converted sourcecode
     */
    public function convert($qname, array $t, $initial= self::ST_INITIAL) {
      $brackets= array(0);

      // Calculate class and package name from qualified name
      $p= strrpos($qname, '.');
      $package= substr($qname, 0, $p);
      $namespace= str_replace('.', self::SEPARATOR, $package);
      $class= substr($qname, $p+ 1);
      $imported= NULL;
      $modifiers= array();

      // Tokenize file
      $state= array($initial);
      $imports= array();
      $out= '';
      for ($i= 0, $s= sizeof($t); $i < $s; $i++) {
        $token= $this->tokenOf($t[$i], ($i > 0 ? $t[$i- 1] : NULL));
        if (!isset($state[0])) {
          throw new IllegalStateException('State machine underrun');
        }
        switch ($state[0].$token[0]) {
          case self::ST_INITIAL.T_OPEN_TAG: {
            continue 2;
          }

          case self::ST_DECL.T_CLOSE_TAG: {
            $i= $s;
            continue 2;
          }
        
          // Insert namespace declaration after "This class is part of..." file comment
          case self::ST_INITIAL.T_COMMENT: {
            $out.= $token[1]."\n\npackage ".str_replace('.', self::SEPARATOR, $namespace).";\n\n-%{IMPORTS}%-";
            $imported= array();
            array_unshift($state, self::ST_NAMESPACE);
            break;
          }
          
          // $package= 'package.name'; - swallow completely
          case self::ST_NAMESPACE.T_VARIABLE: {
            while (';' !== $t[$i] && $i < $s) { $i++; }
            break;
          }
          
          // Remember loaded classes in uses() for use as mapping
          case self::ST_NAMESPACE.self::T_USES: {
            $uses= array();
            array_unshift($state, self::ST_USES);
            $out= rtrim($out);
            break;
          }
          
          case self::ST_USES.T_CONSTANT_ENCAPSED_STRING: {
            $fqcn= self::SEPARATOR.str_replace('.', self::SEPARATOR, trim($token[1], "'"));
            $local= substr($fqcn, strrpos($fqcn, self::SEPARATOR)+ strlen(self::SEPARATOR));
            if ($local == $class) {
              // $this->err->writeLine('*** Name clash between ', $fqcn, ' and declared ', $class, ' in ', $qname, ', using qualified name for ', $fqcn);
              $imports[$fqcn]= $fqcn;
            } else if ($other= array_search($local, $imports)) {
              // $this->err->writeLine('*** Name clash between ', $fqcn, ' and other ', $other, ' in ', $qname, ', using qualified name for ', $fqcn);
              $imports[$fqcn]= $fqcn;
            } else {
              $uses[]= substr($fqcn, 1);
              $imports[$fqcn]= $local;
            }
            break;
          }
          
          case self::ST_USES.'(': case self::ST_USES.',': case self::ST_USES.')': 
          case self::ST_USES.T_WHITESPACE:
            // Swallow token
            break;
          
          case self::ST_USES.';': {
            foreach ($uses as $fqcn) {
              $imported['import '.$fqcn.';']= TRUE;
            }
            $uses= array();
            array_shift($state);
            break;
          }

          case self::ST_NAMESPACE.T_DOC_COMMENT: {
            $out= rtrim($out, "\n")."\n".str_replace("\n  ", "\n", $token[1]);
            break;
          }
          
          // class declaration - always use local name here!
          case self::ST_NAMESPACE.T_CLASS: case self::ST_NAMESPACE.T_INTERFACE: {
            if (NULL === $imported) {
              $out.= '-%{IMPORTS}%-';
            }
            $out.= 'public '.$token[1].' ';
            $declaration= $this->tokenOf($t[$i+ 2]);
            $out.= (FALSE !== $p= strrpos($declaration[1], '·')) ? substr($declaration[1], $p+ 1) : $declaration[1];
            $i+= 2;
            array_unshift($state, self::ST_DECL);
            break;
          }
          
          // extends X -> Remove if "Object" === X
          case self::ST_DECL.T_EXTENDS: {
            array_unshift($state, self::ST_EXTENDS);
            break;
          }
          
          case self::ST_EXTENDS.T_WHITESPACE: {
            break;
          }
          
          case self::ST_EXTENDS.T_STRING: {
            if ('lang.Object' === (string)$this->nameMap[$token[1]] || 'lang.Object' === $namespace.'.'.$token[1]) {
              $out= rtrim($out);
            } else {
              $out.= 'extends '.$this->mapName($token[1], $namespace, $imports, 'extends');
            }
            array_shift($state);
            break;
          }
          
          // implements X, Y
          case self::ST_DECL.T_IMPLEMENTS: {
            $out.= $token[1];
            array_unshift($state, self::ST_INTF);
            break;
          }
          
          case self::ST_INTF.T_STRING: {
            $out.= $this->mapName($token[1], $namespace, $imports, $qname);
            break;
          }
          
          case self::ST_INTF.'{': {
            $out.= $token[1];
            array_shift($state);
            break;
          }
          
          // Member variables. public $a, $b => public var $a; public var $b;
          case self::ST_DECL.T_PUBLIC:
          case self::ST_DECL.T_PROTECTED:
          case self::ST_DECL.T_PRIVATE:
          case self::ST_DECL.T_STATIC:
          case self::ST_DECL.T_ABSTRACT:
          case self::ST_DECL.T_FINAL: {
            $out.= $token[1];
            $modifiers[]= $token[1];
            break;
          }
          
          case self::ST_DECL.T_VARIABLE: {
            $out.= 'var '.$token[1];
            break;
          }

          case self::ST_DECL.'=': {
            $out.= '=';
            array_unshift($state, self::ST_FIELD_INIT);
            break;
          }
          
          case self::ST_FIELD_INIT.T_ARRAY: {
            array_unshift($brackets, 0);
            array_unshift($state, self::ST_ARRAY);
            $out.= '[';
            break;
          }
          
          case self::ST_FIELD_INIT.',': {
            array_shift($state);
            $out.= ";\n  ".implode(' ', $modifiers);
            break;
          }

          case self::ST_FIELD_INIT.';': {
            array_shift($state);
            $out.= ';';
            break;
          }

          case self::ST_DECL.',': {
            $out.= ";\n  ".implode(' ', $modifiers);
            break;
          }

          case self::ST_DECL.';': {
            $out.= ';';
            $modifiers= array();
            break;
          }
          
          // Annotations
          case self::ST_DECL.T_COMMENT: {
            if ('#' === $token[1]{0}) {
              $j= $i;
              $comment= '';
              while ($j < $s && T_COMMENT === $token[0] && '#' === $token[1]{0}) {
                $comment.= '  '.substr($token[1], 1);
                $token= $this->tokenOf($t[++$j]);
              }
              $i= $j- 1;
              $t[$i+ 1][1]= "\n".$t[$i+ 1][1];
              $out.= $this->convert(
                '', 
                array_slice(token_get_all('<?php '.substr($comment, 2, -1).'?>'), 1, -1),
                self::ST_ANNOTATIONS
              );
            } else {
              $out.= $token[1];
            }
            break;
          }
          
          // Apidoc comment: parse @param / @return ...
          case self::ST_DECL.T_DOC_COMMENT: {
            $meta= NULL;
            preg_match_all(
              '/@([a-z]+)\s*([^<\r\n]+<[^>]+>|[^\r\n ]+) ?([^\r\n ]+)?/',
              $token[1], 
              $matches, 
              PREG_SET_ORDER
            );
            foreach ($matches as $match) {
              @$meta[$match[1]][]= $match[2];
            }
            $out.= str_replace("\n  ", "\n", $token[1]);
            break;
          }
          
          // function name(X $var, Y $type)
          case self::ST_DECL.T_FUNCTION: {
            array_unshift($state, self::ST_FUNC);
            break;
          }
          
          case self::ST_FUNC.T_WHITESPACE: {
            // Swallow
            break;
          }
          
          case self::ST_FUNC.T_STRING: {
            array_unshift($brackets, 0);
            if ('__static' === $token[1]) {
              $out= rtrim($out, ' ');
              $i+= 2; // Swallow "(", ")"
              break;
            } 
            
            if ('__construct' !== $token[1]) {
              $out.= (isset($meta['return']) ? $meta['return'][0].' ' : 'void ').$token[1];
            } else {
              $out.= $token[1];
            }
            array_unshift($state, self::ST_FUNC_ARGS);
            $parameter= 0;
            $restriction= NULL;
            break;
          }
          
          case self::ST_FUNC.'{': {
            array_unshift($brackets, 0);
            if (isset($meta['throws'])) {
              $throws= '';
              foreach ($meta['throws'] as $exception) {
                $throws.= ', '.$this->mapName($exception, $namespace, $imports, $qname);
              }
              $out.= ' throws '.substr($throws, 2);
            }
            $out.= ' {';
            array_shift($state);
            array_unshift($state, self::ST_FUNC_BODY);
            break;
          }

          case self::ST_FUNC_BODY.'{': {
            $out.= $token[1];
            $brackets[0]++;
            break;
          }

          case self::ST_FUNC_BODY.'}': {
            $out.= $token[1];
            $brackets[0]--;
            if ($brackets[0] < 0) {
              array_shift($brackets);
              array_shift($state);
            }
            break;
          }
            
          case self::ST_FUNC.';': {
            $out.= ';';
            array_shift($state);
            break;
          }
          
          case self::ST_FUNC_ARGS.'(': {
            $out.= $token[1];
            $brackets[0]++;
            break;
          }

          case self::ST_FUNC_ARGS.')': {
            $out.= $token[1];
            $brackets[0]--;
            if ($brackets[0] <= 0) {
              array_shift($brackets);
              array_shift($state);
            }
            break;
          }
          
          case self::ST_FUNC_ARGS.T_STRING: {
            $nonClassTypes= array('array');   // Type hints that are not classes

            // Look ahead, decl(array $a, String $b, $c, $x= FALSE, $z= TRUE)
            // * $a -> array (non-class-type, yield array)
            // * $b -> String (map name)
            // * $c -> no type
            // * $x -> no type
            // * $z -> no type
            $ws= $this->tokenOf($t[$i+ 1]);
            $var= $this->tokenOf($t[$i+ 2]);
            if (T_WHITESPACE === $ws[0] && T_VARIABLE === $var[0]) {
              $restriction= $token[0];
              $i++;
            } else {
              $out.= $token[1];
            }
            break;
          }
          
          case self::ST_FUNC_ARGS.T_VARIABLE: {
            $primitives= array('string', 'int', 'double', 'bool', 'var');
            
            $type= isset($meta['param'][$parameter]) ? $meta['param'][$parameter] : 'var';
            if (!in_array($type, $primitives) && !$restriction) {
              $type.= '?';
            }
            $out.= $this->mapName($type, $namespace, $imports, $qname).' '.$token[1];
            $parameter++;
            break;
          }
          
          // Anonymous class creation - newinstance('fully.qualified', array(...), '{ source }');
          // -> new fully.qualified(...) { rewritten-source };
          case self::ST_FUNC_BODY.self::T_NEWINSTANCE: {
            $out.= 'new '.trim($t[$i+ 2][1], '"\'');
            $i+= 2;
            array_unshift($state, self::ST_ANONYMOUS);
            break;
          }
          
          case self::ST_ANONYMOUS.',': case self::ST_ANONYMOUS.T_WHITESPACE: {
            // Swallow
            break;
          }
          
          case self::ST_ANONYMOUS.T_ARRAY: {
            array_unshift($brackets, 0);
            array_unshift($state, self::ST_PARAMS);
            break;
          }

          case self::ST_PARAMS.'(': {
            $out.= $token[1];
            $brackets++;
            break;
          }

          case self::ST_PARAMS.')': {
            $out.= $token[1];
            $brackets[0]--;
            if ($brackets[0] <= 0) {
              array_shift($brackets);
              array_shift($state);
            }
            break;
          }
          
          case self::ST_ANONYMOUS.T_CONSTANT_ENCAPSED_STRING: {
            $quote= $token[1]{0};
            $out.= ' '.$this->convert(
              '', 
              array_slice(token_get_all('<?php '.trim($token[1], $quote).'?>'), 1, -1),
              self::ST_DECL
            );
            $i++;   // Swallow ")"
            array_shift($state);
            break;
          }
          
          // finally(); -> finally
          case self::ST_FUNC_BODY.self::T_FINALLY: {
            $out.= 'finally';
            $i+= 3;
            break;
          }
          
          // with($a= ...); -> with ($a= ...)
          case self::ST_FUNC_BODY.self::T_WITH: {
            $out.= 'with';
            array_unshift($brackets, 0);
            array_unshift($state, self::ST_WITH);
            array_unshift($state, self::ST_PARAMS);
            break;
          }
          
          case self::ST_WITH.';': {
            array_shift($state);
            break;
          }

          // create(...); -> ...
          // create(..., array(a, b)), -> ...(a, b)
          case self::ST_FUNC_BODY.self::T_CREATE: {
            $out.= trim($t[$i+ 2][1], '"\'');
            $i+= 3; // Swallow "(" and string
            array_unshift($state, self::ST_CREATE);
            break;
          }
          
          case self::ST_CREATE.')': {
            array_shift($state);
            break;
          }

          case self::ST_CREATE.T_WHITESPACE: {
            // Swallow
            break;
          }
          
          case self::ST_CREATE.T_ARRAY: {
            array_unshift($brackets, 0);
            array_unshift($state, self::ST_PARAMS);
            break;
          }
          
          // foreach ($a as $v) -> foreach ($v in $a)
          // foreach ($m as $k => $v) -> foreach ($k, $v in $m)
          case self::ST_FUNC_BODY.T_FOREACH: {
            $buf= $out;
            $out= '';
            array_unshift($state, self::ST_FOREACH);
            $i+= 2; // Swallow " " & "("
            break;
          }
          
          case self::ST_FOREACH.T_AS: {
            if (T_DOUBLE_ARROW === $t[$i+ 4][0]) {
              $out= $buf.'foreach ('.$t[$i+ 2][1].', '.$t[$i+ 6][1].' in '.rtrim($out, ' ');
              $i+= 6;
            } else {
              $out= $buf.'foreach ('.$t[$i+ 2][1].' in '.rtrim($out, ' ');
              $i+= 2;
            }
            array_shift($state);
            break;
          }

          // TRUE, FALSE and NULL constants
          case (in_array(self::ST_FUNC_BODY, $state)  || in_array(self::ST_FIELD_INIT, $state)) && (
            $token[0] === self::T_TRUE ||
            $token[0] === self::T_FALSE ||
            $token[0] === self::T_NULL
          ): {
            $out.= strtolower($token[1]);
            break;
          }
          
          // Replace concat operator with ~
          case in_array(self::ST_FUNC_BODY, $state) && $token[0] === '.': {
            $out.= ' ~ ';
            break;
          }

          case in_array(self::ST_FUNC_BODY, $state) && $token[0] === T_CONCAT_EQUAL: {
            $out.= ' ~=';
            break;
          }

          // Replace object operator with "."
          case in_array(self::ST_FUNC_BODY, $state) && $token[0] === T_OBJECT_OPERATOR: {
            $out.= '.';
            break;
          }

          // instanceof X, new X, catch(X $var)
          case in_array(self::ST_FUNC_BODY, $state) && (
            $token[0] === T_INSTANCEOF ||
            $token[0] === T_CATCH ||
            $token[0] === T_NEW
          ): {
            $out.= $token[1];
            array_unshift($state, self::ST_CLASS);
            break;
          }
          
          case self::ST_CLASS.T_STRING: {
            $out.= $this->mapName($token[1], $namespace, $imports, $qname);
            array_shift($state);
            break;
          }

          case self::ST_CLASS.T_VARIABLE: {
            $out.= $token[1];
            array_shift($state);
            break;
          }
  
          // Track function calls
          case in_array(self::ST_FUNC_BODY, $state) && $token[0] === T_STRING: {
            $next= $this->tokenOf($t[$i+ 1]);
            if (T_DOUBLE_COLON === $next[0]) {       // X::y(), X::$y, X::const
              $member= $this->tokenOf($t[$i+ 2]);
              $out.= $this->mapName($token[1], $namespace, $imports, $qname).'::'.$member[1];
              $i+= 2;
            } else if ('(' === $next[0] && '.' !== $out{strlen($out)- 1}) {
              $out.= $token[1];
              try {
                $func= new ReflectionFunction($token[1]);
                $ext= $func->getExtension();
              } catch (ReflectionException $e) {
                throw new IllegalStateException($e->getMessage().' @'.$state[0]."\n".$out);
              }
              $imported['import native '.strtolower($ext->getName()).'.'.$token[1].';']= TRUE;
            } else {
              $out.= $token[1];
            }
            break;
          }
          
          // Arrays
          case self::ST_ANNOTATIONS.T_ARRAY:
          case self::ST_FUNC_ARGS.T_ARRAY: 
          case self::ST_FUNC_BODY.T_ARRAY: {
            array_unshift($brackets, 0);
            $out.= '[';
            array_unshift($state, self::ST_ARRAY);
            break;
          }

          case self::ST_ARRAY.T_ARRAY: {
            array_unshift($brackets, 0);
            array_unshift($state, self::ST_ARRAY);
            $out.= '[';
            break;
          }
 
          case self::ST_ARRAY.T_DOUBLE_ARROW: {
            $out.= ':';
            break;
          }
         
          case self::ST_ARRAY.'(': {
            if ($brackets[0] > 0) {
              $out.= $token[1];
            }
            $brackets[0]++;
            break;
          }

          case self::ST_ARRAY.')': {
            $brackets[0]--;
            if ($brackets[0] <= 0) {
              array_shift($brackets);
              array_shift($state);
              $out.= ']';
              break;
            }
            $out.= $token[1];
            break;
          }

          case in_array(self::ST_FUNC_BODY, $state) && $token[0] === T_FUNCTION: {
            throw new IllegalStateException('Nested function @ '.$state[0]."\n".$out);
          }

          // Inline comments: Fix indenting
          case self::ST_FUNC_BODY.T_COMMENT: {
            if ("\n" === $token[1]{strlen($token[1])- 1}) {
              $out.= str_replace("\n  ", "\n", substr($token[1], 0, -1));
              $t[$i+ 1][1]= "\n".$t[$i+ 1][1];
            } else {
              $out.= str_replace("\n  ", "\n", $token[1]);
            }
            break;
          }
          
          default: {
            $out.= str_replace("\n  ", "\n", $token[1]);
          }
        }
      }
      
      if ($imported) {
        $replace= implode("\n", array_keys($imported))."\n\n";
      } else {
        $replace= '';
      }

      return str_replace('-%{IMPORTS}%-', $replace, $out);
    }
  }
?>
