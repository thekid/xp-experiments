<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'io.Folder',
    'io.File',
    'io.streams.Streams',
    'io.collections.FileCollection',
    'io.collections.iterate.FilteredIOCollectionIterator',
    'io.collections.iterate.ExtensionEqualsFilter'
  );

  /**
   * Converts PHP classes inside a given directory to namespaced versions
   * as discussed in RFC #222
   *
   * @see   https://github.com/xp-framework/xp-framework/pull/22
   */
  class ConvertToNamespaces extends Command {
    protected $base= NULL;
    protected $target= NULL;
    protected $self= NULL;
    protected $imports= array();
    
    const ST_INITIAL = 0;
    const ST_USES    = 1;
    const ST_DECL    = 2;
    const ST_BODY    = 3;
    
    /**
     * Set directory to work on
     *
     * @param   string
     */
    #[@arg(position= 0)]
    public function setOrigin($dir) {
      $this->base= new FileCollection(new Folder($dir));
      ClassLoader::getDefault()->registerPath($this->base->getURI());
    }

    /**
     * Set output directory. Will be created if non-existant
     *
     * @param   string
     */
    #[@arg(position= 1)]
    public function setTarget($dir) {
      $this->target= new Folder($dir);
    }
    
    /**
     * Create name literal
     *
     * @param   string namespace current namespace
     * @param   [:lang.XPClass] imports import lookup table
     * @param   string local local, unqualified name
     * @param   string context file
     * @return  string qualified name
     */
    protected function nameOf($namespace, $imports, $local, $context) {
      static $special= array('self', 'parent', 'static', 'xp');

      // Leave special class names 
      if (in_array($local, $special)) return $local;

      // Fully-qualify name. For RFC#37-style names, it's clear, for 
      // other cases, we use 
      if (FALSE !== ($p= strrpos($local, '·'))) {
        $qualified= strtr($local, '·', '\\');
        $local= substr($local, $p+ 1);
      } else {
        $qualified= strtr(xp::nameOf($local), '.', '\\');
      }

      // If imported, we can use local name
      if (isset($imports[$local])) return $local;

      // PHP classes are global
      if (0 === strncmp($qualified, 'php\\', 4)) {
        if (!class_exists($local, FALSE) && !interface_exists($local, FALSE)) {
          throw new IllegalStateException(sprintf(
            'In %s: Cannot resolve name "%s" namespace "%s", imports= %s',
            $context,
            $local,
            $namespace,
            xp::stringOf($imports)
          ));
        }
        return '\\'.$local;
      }

      // If name is in current namespace, use local, else globally qualified version
      if (0 === strncmp($qualified, $namespace, strlen($namespace))) return $local;
      return '\\'.$qualified;
    }
    
    /**
     * Process a file
     *
     * @param   io.collections.IOElement e
     */
    protected function process(IOElement $e) {
      $base= strlen($this->base->getURI());
      $relative= substr($e->getOrigin()->getURI(), $base, -1);

      // Ensure output folder exists
      $folder= new Folder($this->target, $relative);
      $folder->exists() || $folder->create();

      // Create output file
      $target= new File($this->target, substr($e->getURI(), $base));
      $out= $target->getOutputStream();
      
      // Initialize
      $context= $e->getURI();
      $imports= array();
      $namespace= strtr($relative, DIRECTORY_SEPARATOR, '\\');
      $tokens= token_get_all(Streams::readAll($e->getInputStream()));
      $state= self::ST_INITIAL;
      $cl= ClassLoader::getDefault();

      // Handle tokens
      for ($i= 0, $s= sizeof($tokens); $i < $s; $i++) {
        switch ($state.$tokens[$i][0]) {
          case self::ST_INITIAL.T_STRING:
            if ('uses' === $tokens[$i][1]) {
              $state= self::ST_USES;
              $namespace && $out->write('namespace '.$namespace.";\n  ");
              $out->write('use');
            } else {
              $out->write($tokens[$i][1]);
            }
            break;
          
          case self::ST_INITIAL.T_VARIABLE:
            if ('$package' == $tokens[$i][1]) {
              $i+= 4; // Skip token itself, whitespace, string, semicolon
            } else {
              $out->write($tokens[$i][1]);
            }
            break;

          case self::ST_USES.'(': 
            $out->write(' ');
            break;

          case self::ST_USES.')':
            $state= self::ST_INITIAL;
            break;
          
          case self::ST_USES.T_CONSTANT_ENCAPSED_STRING:
            $name= substr($tokens[$i][1], 1, -1);
            $local= substr($name, strrpos($name, '.')+ 1);
            $imports[$local]= $cl->loadClass($name);
            $out->write(strtr($name, '.', '\\'));
            break;
          
          case self::ST_INITIAL.T_CLASS:
          case self::ST_INITIAL.T_INTERFACE:
            $out->write($tokens[$i][1].' ');
            $local= $tokens[$i+ 2][1];
            if (FALSE !== ($p= strrpos($local, '·'))) { // Unqualify RFC#37- qualified class names
              $out->write(substr($local, $p+ 1));
            } else {
              $out->write($local);
            }
            $imports[$local]= $this->self;

            $i+= 2; // Skip over whitespace and class name
            $state= self::ST_DECL;
            break;
          
          case self::ST_DECL.T_STRING:
            $out->write($this->nameOf($namespace, $imports, $tokens[$i][1], $context));
            break;

          case self::ST_DECL.'{':
            $out->write('{');
            $state= self::ST_BODY;
            break;
          
          case self::ST_BODY.T_STRING:
            if (T_DOUBLE_COLON === $tokens[$i+ 1][0]) {
              $out->write($this->nameOf($namespace, $imports, $tokens[$i][1], $context));   // Static method calls
            } else if (T_WHITESPACE === $tokens[$i+ 1][0] && T_VARIABLE === $tokens[$i+ 2][0]) {
              $out->write($this->nameOf($namespace, $imports, $tokens[$i][1], $context));   // Typehint
            } else {
              $out->write($tokens[$i][1]);
            }
            break;

          case self::ST_BODY.T_NEW:
            if (T_STRING === $tokens[$i+ 2][0]) {
              $out->write('new '.$this->nameOf($namespace, $imports, $tokens[$i+ 2][1], $context));
              $i+= 2; // Skip over whitespace and class name
            } else {
              $out->write('new');
            }
            break;
          
          default:
            $out->write(is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i]);
        }
      }
      
      $out->close();
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      $this->self= newinstance('lang.XPClass', array(), '{ 
        public function __construct() {
          Type::__construct("self");
        }
      }');
      $files= new FilteredIOCollectionIterator(
        $this->base, 
        new ExtensionEqualsFilter(xp::CLASS_FILE_EXT),
        TRUE
      );
      $this->out->writeLine($files);
      
      // Iterate
      $this->out->write('[');
      foreach ($files as $file) {
        $this->process($file);
        $this->out->write('.');
      }
      $this->out->writeLine(']');
    }
  }
?>
