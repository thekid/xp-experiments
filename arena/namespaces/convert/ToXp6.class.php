<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'lang.archive.Archive',
    'io.collections.FileCollection',
    'io.collections.iterate.FilteredIOCollectionIterator',
    'io.collections.iterate.NegationOfFilter',
    'io.collections.iterate.AllOfFilter',
    'io.collections.iterate.CollectionFilter',
    'io.collections.iterate.NegationOfFilter',
    'io.collections.iterate.RegexFilter',
    'io.collections.iterate.ExtensionEqualsFilter',
    'util.collections.HashTable',
    'text.StreamTokenizer',
    'io.streams.FileInputStream',
    'io.File',
    'io.Folder',
    'io.FileUtil',
    'lang.types.String'
  );

  /**
   * Converts XP5 sourcecode to XP6
   *
   * Subjectives
   * -----------
   * <ul>
   *   <li>Insert namespace declaration at the beginning of each file</li>
   *   <li>Fully qualify class names</li>
   *   <li>Fully qualify core functionality (newinstance, create, raise, ...)</li>
   * </ul>
   *
   * Examples
   * -----------
   * Convert all skeleton classes:
   * <pre>
   * $ xpcli convert.ToXp6 
   *   -b ../../../../../xp/trunk/skeleton/
   *   -o ../../../../../xp/trunk/skeleton/
   *   -t lib/xp-rt-6.0.0alpha.xar
   * </pre>
   *
   * Convert all tools classes:
   * <pre>
   * $ xpcli convert.ToXp6 
   *   -b ../../../../../xp/trunk/tools/
   *   -o ../../../../../xp/trunk/tools/
   *   -t lib/xp-tools-6.0.0alpha.xar
   * </pre>
   *
   * Convert all classes in the net.xp_framework package in ports:
   * <pre>
   * $ xpcli convert.ToXp6 
   *   -b ../../../../../xp/trunk/ports/classes/ 
   *   -o ../../../../../xp/trunk/ports/classes/net/xp_framework/
   *   -t lib/xp-net.xp_framework-6.0.0alpha.xar
   * </pre>
   *
   * Known issues
   * ------------
   * <ul>
   *   <li>Manual touches in lang package is needed</li>
   * </ul>
   *
   * @purpose  Command
   */
  class ToXp6 extends Command {
    protected
      $origin        = NULL,
      $iterator      = NULL,
      $baseUriLength = 0,
      $patchesDir    = '',
      $nameMap       = NULL,
      $verbose       = FALSE;

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
      T_CAST          = 0xF00B;
    
    // States
    const
      ST_INITIAL      = 'init',
      ST_DECL         = 'decl',
      ST_FUNC         = 'func',
      ST_FUNC_ARGS    = 'farg',
      ST_INTF         = 'intf',
      ST_CLASS        = 'clss',
      ST_USES         = 'uses',
      ST_ANONYMOUS    = 'anon',
      ST_NAMESPACE    = 'nspc';
    
    const
      SEPARATOR       = '\\';

    /**
     * Constructor
     *
     */
    public function __construct() {
      $this->patchesDir= dirname(__FILE__).'/patches/';
    }

    /**
     * Set origin directory
     *
     * @param   string origin
     */
    #[@arg]
    public function setOrigin($origin) {
      $this->origin= new FileCollection($origin);
      $this->iterator= new FilteredIOCollectionIterator(
        $this->origin,
        new AllOfFilter(array(
          new NegationOfFilter(new RegexFilter('#'.preg_quote(DIRECTORY_SEPARATOR).'(CVS|\.svn)'.preg_quote(DIRECTORY_SEPARATOR).'#')),
          new NegationOfFilter(new CollectionFilter())
        )),
        TRUE
      );
      $this->verbose && $this->out->writeLine($this->iterator);
    }

    /**
     * Set base directory
     *
     * @param   string base
     */
    #[@arg]
    public function setBase($base) {
      $this->baseUriLength= strlen(create(new FileCollection($base))->getUri());
    }

    /**
     * Set target directory
     *
     * @param   string base
     */
    #[@arg]
    public function setTarget($target) {
      $this->target= new Archive(new File($target));
      $this->target->open(ARCHIVE_CREATE);
    }
    
    /**
     * Enable verbose mode
     *
     * @param   bood v default FALSE
     */
    #[@arg]
    public function setVerbose($v= FALSE) {
      $this->verbose= ($v !== FALSE);
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
      );

      $normalized= is_array($t) ? $t : array($t, $t);
      if (
        (!is_array($last) || $last[0] !== T_OBJECT_OPERATOR) &&
        T_STRING == $normalized[0] && isset($map[$normalized[1]])
      ) {
        $normalized[0]= $map[$normalized[1]];
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
      if (NULL === ($mapped= $this->nameMap[$qname])) {

        // If the searched class resides in the same namespace, it does not
        // need to be fully qualified or mapped, so check for this
        $search= ($namespace !== NULL ? str_replace(self::SEPARATOR, '.', $namespace).'.' : '').$qname;
        if (!ClassLoader::findClass($search) instanceof IClassLoader) {
          $this->err->writeLine('*** No mapping for ', $qname, ' (current namespace: ', $namespace,', class= ', $context, ')');
        }
        return $qname;
      }

      // Return local name if mapped name is in imports or current namespace
      if (isset($imports[(string)$mapped])) {
        $this->verbose && $this->out->writeLine('I:', $context, ': ', $qname, ' => ', $imports[(string)$mapped]);
        return $imports[(string)$mapped]; 
      } else if (FALSE !== ($p= strrpos($mapped, self::SEPARATOR)) && $namespace == substr($mapped, 0, $p)) {
        $this->verbose && $this->out->writeLine('N:', $context, ': ', $qname, ' => ', substr($mapped, $p+ 2));
        return substr($mapped, $p+ 2);
      } else {
        $this->verbose && $this->out->writeLine('M:', $context, ': ', $qname, ' => ', $mapped);
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
    protected function convertSource($qname, array $t, $initial= self::ST_INITIAL) {

      // Calculate class and package name from qualified name
      $p= strrpos($qname, '.');
      $package= substr($qname, 0, $p);
      $namespace= str_replace('.', self::SEPARATOR, $package);
      $class= substr($qname, $p+ 1);
      
      // Tokenize file
      $state= array($initial);
      $imports= array();
      $out= '';
      for ($i= 0, $s= sizeof($t); $i < $s; $i++) {
        $token= $this->tokenOf($t[$i], ($i > 0 ? $t[$i- 1] : NULL));
        switch ($state[0].$token[0]) {
        
          // Insert namespace declaration after "This class is part of..." file comment
          case self::ST_INITIAL.T_COMMENT: {
            $out.= $token[1]."\n\n  namespace ".str_replace('.', self::SEPARATOR, $namespace).';';
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
            $out= rtrim($out)."\n";
            break;
          }
          
          case self::ST_USES.T_CONSTANT_ENCAPSED_STRING: {
            $fqcn= self::SEPARATOR.str_replace('.', self::SEPARATOR, trim($token[1], "'"));
            $local= substr($fqcn, strrpos($fqcn, self::SEPARATOR)+ strlen(self::SEPARATOR));
            if ($local == $class) {
              $this->err->writeLine('*** Name clash between ', $fqcn, ' and declared ', $class, ' in ', $qname, ', using qualified name for ', $fqcn);
              $imports[$fqcn]= $fqcn;
            } else if ($other= array_search($local, $imports)) {
              $this->err->writeLine('*** Name clash between ', $fqcn, ' and other ', $other, ' in ', $qname, ', using qualified name for ', $fqcn);
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
              $out.= '  use '.$fqcn.";\n";
            }
            $this->verbose && $this->err->writeLine('Imports in ', $qname, ': ', $imports);
            $uses= array();
            array_shift($state);
            break;
          }
          
          // class declaration - always use local name here!
          case self::ST_NAMESPACE.T_CLASS: case self::ST_NAMESPACE.T_INTERFACE: {
            $out.= $token[1].' ';
            $declaration= $this->tokenOf($t[$i+ 2]);
            $out.= (FALSE !== $p= strrpos($declaration[1], '·')) ? substr($declaration[1], $p+ 1) : $declaration[1];
            $i+= 2;
            array_unshift($state, self::ST_DECL);
            break;
          }
          
          // instanceof X, extends X, new X, catch(X $var)
          case self::ST_DECL.T_INSTANCEOF: case self::ST_DECL.T_EXTENDS: 
          case self::ST_DECL.T_NEW: case self::ST_DECL.T_CATCH: {
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
          
          // X::y(), X::$y, X::const
          case self::ST_DECL.T_STRING: {
            $next= $this->tokenOf($t[$i+ 1]);
            if (T_DOUBLE_COLON == $next[0]) {
              $out.= $this->mapName($token[1], $namespace, $imports, $qname);

              // Swallow token after double colon
              // (fixes self::create() being rewritten to self::::create())
              $member= $this->tokenOf($t[$i+ 2]);
              $out.= '::'.$member[1];
              $i+= 2;

              // ClassLoader::defineClass('fully.qualified', 'parent.fqcn', array('interface.fqcns'), '{ source }');
              // ClassLoader::defineInterface('fully.qualified', array('parent.fqcns'), '{ source }');
              $complete= $token[1].self::SEPARATOR.$member[1];
              $converted= NULL;
              if ('ClassLoader::defineClass' == $token[1].'::'.$member[1] || 'ClassLoader::defineInterface' == $token[1].'::'.$member[1]) {
                do {
                  $next= $this->tokenOf($t[++$i]);
                  if (';' == $next[0]) {
                    $out.= $next[1];
                    break;
                  } else if (T_CONSTANT_ENCAPSED_STRING === $next[0] && '{' === $next[1]{1}) {
                    $quote= $next[1]{0};
                    $converted= $this->convertSource('', token_get_all('<?php '.trim($next[1], $quote).' ?>'), self::ST_DECL);
                    $out.= $quote.substr($converted, 6, -3).$quote;
                  } else {
                    $out.= $next[1];
                  }
                } while (!$converted && $i < $s);
              }
            } else {
              $out.= $token[1];
            }
            break;
          }
          
          // function name(X $var, Y $type)
          case self::ST_DECL.T_FUNCTION: {
            $out.= $token[1];
            array_unshift($state, self::ST_FUNC);
            break;
          }
          
          case self::ST_FUNC.T_STRING: {
            $brackets= 0;
            $out.= $token[1];
            array_unshift($state, self::ST_FUNC_ARGS);
            break;
          }
          
          case self::ST_FUNC.'{': case self::ST_FUNC.';': {
            $out.= $token[1];
            array_shift($state);
            break;
          }
          
          case self::ST_FUNC_ARGS.'(': {
            $out.= $token[1];
            $brackets++;
            break;
          }

          case self::ST_FUNC_ARGS.')': {
            $out.= $token[1];
            $brackets--;
            if (0 == $brackets) {
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
              $out.= in_array($token[1], $nonClassTypes) ? $token[1] : $this->mapName($token[1], $namespace, $imports, $qname);
            } else {
              $out.= $token[1];
            }
            break;
          }
          
          // Anonymous class creation - newinstance('fully.qualified', array(...), '{ source }');
          case self::ST_DECL.self::T_NEWINSTANCE:  {
            $out.= self::SEPARATOR.'newinstance('.$t[$i+ 2][1];
            $i+= 2;
            array_unshift($state, self::ST_ANONYMOUS);
            break;
          }
          
          case self::ST_ANONYMOUS.T_CONSTANT_ENCAPSED_STRING: {
            $quote= $token[1]{0};
            $converted= $this->convertSource('', token_get_all('<?php '.trim($token[1], $quote).' ?>'), self::ST_DECL);
            $out.= $quote.substr($converted, 6, -3).$quote;
            array_shift($state);
            break;
          }
          
          // XP "keywords" - prefix with "::"
          case self::ST_ANONYMOUS.self::T_CREATE:case self::ST_DECL.self::T_CREATE:
          case self::ST_ANONYMOUS.self::T_REF: case self::ST_DECL.self::T_REF: 
          case self::ST_ANONYMOUS.self::T_DEREF: case self::ST_DECL.self::T_DEREF:
          case self::ST_DECL.self::T_RAISE: case self::ST_DECL.self::T_FINALLY:
          case self::ST_DECL.self::T_DELETE: case self::ST_DECL.self::T_WITH: 
          case self::ST_DECL.self::T_IS: case self::ST_DECL.self::T_CAST: {
            $out.= self::SEPARATOR.$token[1];
            break;
          }
          
          default: {
            $out.= $token[1];
          }
        }
      }

      return $out;      
    }
    
    /**
     * Add a file
     *
     * @param   lang.archive.Archive target
     * @param   io.collections.FileElement e
     * @param   int baseUriLength
     */
    protected function add(Archive $target, FileElement $e, $baseUriLength) {
      static $lastpackage= '';
      
      $uri= $e->getURI();
      if (xp::CLASS_FILE_EXT === substr($uri, -strlen(xp::CLASS_FILE_EXT))) {
        $qname= strtr(substr($uri, $baseUriLength, -strlen(xp::CLASS_FILE_EXT)), '/\\', '..');

        // Convert sourcecode
        $out= $this->convertSource($qname, token_get_all(file_get_contents($uri)));

        // See if there is a patch
        if (file_exists($patch= $this->patchesDir.$qname.'.patch')) {
          $this->verbose && $this->out->writeLine('XP ', $qname);
          
          $converted= new File($this->patchesDir.$qname);
          FileUtil::setContents($converted, $out);
          $cmd= sprintf('patch -i "%s" "%s"', $patch, $converted->getURI());
          $this->out->writeLine(`$cmd`);
          clearstatcache();
          $out= FileUtil::getContents($converted);
        } else {
          if ($lastpackage != substr($qname, 0, strrpos($qname, '.'))) {
            $lastpackage= substr($qname, 0, strrpos($qname, '.'));
            $this->out->writeLine();
            $this->out->write($lastpackage, ' ');
          }
          if ($this->verbose) {
            $this->out->writeLine('X  ', $qname);
          } else {
            $this->out->write('.');
          }
        }

        // Write converted sourcecode to target archive
        $urn= strtr($qname, '.', '/').xp::CLASS_FILE_EXT;
        $target->addFileBytes(
          $urn,
          dirname($urn),
          basename($urn),
          $out
        );
      } else if ('.xar' == substr($uri, -4)) {
      
        // Convert sourcecode inside
        $in= new Archive(new File($uri));
        $in->open(ARCHIVE_READ);
        $out= new Archive(new File($this->patchesDir.md5($uri).'.xar'));
        $out->open(ARCHIVE_CREATE);

        $base= 'xar://'.urlencode($uri).'?';
        $baseLen= strlen($base);
        while ($entry= $in->getEntry()) {
          $this->add($out, new FileElement($base.$entry), $baseLen);
        }
        
        $in->close();
        $out->create();
        
        $qname= strtr(substr($uri, $baseUriLength), DIRECTORY_SEPARATOR, '/');
        $this->verbose && $this->out->writeLine('XA ', $qname);
        $target->add($out->file, $qname);
      } else {
      
        // Copy file directly
        $qname= strtr(substr($uri, $baseUriLength), DIRECTORY_SEPARATOR, '/');
        $this->verbose && $this->out->writeLine('A  ', $qname);
        $target->add(new File($uri), $qname);
      }
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      $this->out->writeLine('===> Starting conversion to ', $this->target);
      
      $this->nameMap= create('new util.collections.HashTable<String, String>()');
      $package= $this->getClass()->getPackage();
      foreach ($package->getResources() as $resource) {
        if ('.map' != substr($resource, -4)) continue;
        
        $entries= 0;
        $st= new StreamTokenizer(new FileInputStream($package->getResourceAsStream($resource)), "\r\n");
        while ($st->hasMoreTokens()) {
          sscanf($st->nextToken(), "%[^=]=%[^\r]", $name, $qualified);
          $this->nameMap->put($name, new String(str_replace('.', self::SEPARATOR, $qualified)));
          $entries++;
        }
        $this->verbose && $this->out->writeLine('---> Loaded name map ', $resource, ' (', $entries, ')');
      }
      
      // Iterate over origin directory, converting each
      $this->verbose && $this->out->writeLine('===> Converting files from ', $this->iterator);
      while ($this->iterator->hasNext()) {
        $this->add($this->target, $this->iterator->next(), $this->baseUriLength);
      }
      
      // Finish off archive
      $this->target->create();
      
      $this->out->writeLine('===> Done');
    }
  }
?>
