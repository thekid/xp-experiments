<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'lang.Type',
    'lang.reflect.Method',
    'lang.reflect.Field',
    'lang.reflect.Constructor',
    'lang.reflect.Modifiers'
  );

  define('DETAIL_ARGUMENTS',      1);
  define('DETAIL_RETURNS',        2);
  define('DETAIL_THROWS',         3);
  define('DETAIL_COMMENT',        4);
  define('DETAIL_ANNOTATIONS',    5);
  define('DETAIL_NAME',           6);
 
  /**
   * Represents classes. Every instance of an XP class has an method
   * called getClass() which returns an instance of this class.
   *
   * Warning:
   *
   * Do not construct this class publicly, instead use either the
   * $o->getClass() syntax or the static method 
   * $class= XPClass::forName('fully.qualified.Name')
   *
   * To retrieve the fully qualified name of a class, use this:
   * <code>
   *   $o= new File();
   *   echo 'The class name for $o is '.$o->getClass()->getName();
   * </code>
   *
   * @see      xp://lang.Object#getClass()
   * @test     xp://net.xp_framework.unittest.reflection.ReflectionTest
   * @test     xp://net.xp_framework.unittest.reflection.ClassDetailsTest
   * @purpose  Reflection
   */
  class XPClass extends Type {
    public 
      $_objref  = NULL,
      $_reflect = NULL;
      
    /**
     * Constructor
     *
     * @param   mixed ref either a class name or an object
     */
    public function __construct($ref) {
      parent::__construct(xp::nameOf(is_object($ref) ? get_class($ref) : $ref));
      $this->_objref= $ref;
      $this->_reflect= new ReflectionClass($ref);
    }

    /**
     * Creates a new instance of the class represented by this Class object.
     * The class is instantiated as if by a new expression with an empty argument list.
     *
     * Example:
     * <code>
     *   try {
     *     $o= XPClass::forName($name)->newInstance();
     *   } catch (ClassNotFoundException $e) {
     *     // handle it!
     *   }
     * </code>
     *
     * Example (passing arguments):
     * <code>
     *   try {
     *     $o= XPClass::forName('peer.Socket')->newInstance('localhost', 6100);
     *   } catch (ClassNotFoundException $e) {
     *     // handle it!
     *   }
     * </code>
     *
     * @param   mixed* args
     * @return  lang.Object 
     */
    public function newInstance() {
      if (!$this->hasConstructor()) return $this->_reflect->newInstance();

      $args= func_get_args();
      return $this->_reflect->newInstanceArgs($args);
    }
    
    /**
     * Helper function that returns this class' methods.
     *
     * @param   
     * @return  array<string, string>
     */
    protected function _methods($filter= array()) {
      $r= array();
      foreach ($this->_reflect->getMethods() as $m) {
        in_array($name= strtolower($m->getName()), $filter) || $r[$name]= $m->getName();
      }
      return $r;
   }
    
    /**
     * Gets class methods for this class
     *
     * @return  lang.reflect.Method[]
     */
    public function getMethods() {
      $m= array();
      foreach ($this->_methods(array('__construct', '__destruct')) as $method) {
        $m[]= new Method($this->_objref, $method);
      }
      return $m;
    }

    /**
     * Gets a method by a specified name. Returns NULL if the specified 
     * method does not exist.
     *
     * @param   string name
     * @return  lang.Method
     * @see     xp://lang.reflect.Method
     */
    public function getMethod($name) {
      if ($this->hasMethod($name)) {
        return new Method($this->_objref, $name);
      }
      return NULL;
    }
    
    /**
     * Checks whether this class has a method named "$method" or not.
     *
     * Note: Since in PHP, methods are case-insensitive, calling 
     * hasMethod('toString') will provide the same result as 
     * hasMethod('tostring')
     *
     * @param   string method the method's name
     * @return  bool TRUE if method exists
     */
    public function hasMethod($method) {
      return in_array(strtolower($method), array_keys($this->_methods(array('__construct', '__destruct'))));
    }
    
    /**
     * Retrieve if a constructor exists
     *
     * @return  bool
     */
    public function hasConstructor() {
      return in_array('__construct', array_keys($this->_methods()));
    }
    
    /**
     * Retrieves this class' constructor. Returns NULL if no constructor
     * exists.
     *
     * @return  lang.reflect.Constructor
     * @see     xp://lang.reflect.Constructor
     */
    public function getConstructor() {
      if ($this->hasConstructor()) {
        return new Constructor($this->_objref); 
      }
      return NULL;
    }
    
    /**
     * Retrieve a list of all member variables
     *
     * @return  lang.reflect.Field[] array of field objects
     */
    public function getFields() {
      $f= array();
      $v= (is_object($this->_objref) 
        ? get_object_vars($this->_objref) 
        : get_class_vars($this->_objref)
      );
      foreach ($this->_reflect->getProperties() as $p) {
        if ('__id' == ($name= $p->getName())) continue;
        
        $f[]= new Field(
          $this->_objref, 
          $name,
          isset($v[$name]) ? gettype($v[$name]) : NULL
        );
      }
      return $f;
    }
    
    /**
     * Retrieve a field by a specified name. Returns NULL if the specified
     * field does not exist
     *
     * @param   string name
     * @return  lang.reflect.Field
     */
    public function getField($name) {
      if (!$this->hasField($name)) return NULL;

      $v= (is_object($this->_objref) 
        ? get_object_vars($this->_objref) 
        : get_class_vars($this->_objref)
      );
      return new Field($this->_objref, $name, isset($v[$name]) ? gettype($v[$name]) : NULL);
    }
    
    /**
     * Checks whether this class has a field named "$field" or not.
     *
     * @param   string field the fields's name
     * @return  bool TRUE if field exists
     */
    public function hasField($field) {
      return '__id' == $field ? FALSE : $this->_reflect->hasProperty($field);
    }

    /**
     * Retrieve the parent class's class object. Returns NULL if there
     * is no parent class.
     *
     * @return  lang.XPClass class object
     */
    public function getParentclass() {
      $parent= $this->_reflect->getParentClass();
      if (!$parent) return NULL;
      return new self($parent->getName());
    }
    
    /**
     * Tests whether this class is a subclass of a specified class.
     *
     * @param   string name class name
     * @return  bool
     */
    public function isSubclassOf($name) {
      // Catch bordercase (ZE bug?)
      if ($name == $this->name) return FALSE;
      return $this->_reflect->isSubclassOf(new ReflectionClass(xp::reflect($name)));
    }
    
    /**
     * Determines whether the specified object is an instance of this
     * class. This is the equivalent of the is() core functionality.
     *
     * <code>
     *   uses('io.File', 'io.TempFile');
     *   $class= XPClass::forName('io.File');
     * 
     *   var_dump($class->isInstance(new TempFile()));  // TRUE
     *   var_dump($class->isInstance(new File()));      // TRUE
     *   var_dump($class->isInstance(new Object()));    // FALSE
     * </code>
     *
     * @param   lang.Object obj
     * @return  bool
     */
    public function isInstance($obj) {
      return is($this->name, $obj);
    }
    
    /**
     * Determines if this XPClass object represents an interface type.
     *
     * @return  bool
     */
    public function isInterface() {
      return $this->_reflect->isInterface();
    }
    
    /**
     * Retrieve interfaces this class implements
     *
     * @return  lang.XPClass[]
     */
    public function getInterfaces() {
      $r= array();
      foreach ($this->_reflect->getInterfaces() as $iface) {
        $r[]= new self($iface->getName());
      }
      return $r;
    }

    /**
     * Retrieves the api doc comment for this class. Returns NULL if
     * no documentation is present.
     *
     * @return  string
     */
    public function getComment() {
      if (!($details= self::detailsForClass($this->name))) return NULL;
      return $details['class'][DETAIL_COMMENT];
    }

    /**
     * Check whether an annotation exists
     *
     * @param   string name
     * @param   string key default NULL
     * @return  bool
     */
    public function hasAnnotation($name, $key= NULL) {
      $details= self::detailsForClass($this->name);

      return $details && ($key 
        ? array_key_exists($key, @$details['class'][DETAIL_ANNOTATIONS][$name]) 
        : array_key_exists($name, @$details['class'][DETAIL_ANNOTATIONS])
      );
    }

    /**
     * Retrieve annotation by name
     *
     * @param   string name
     * @param   string key default NULL
     * @return  mixed
     * @throws  lang.ElementNotFoundException
     */
    public function getAnnotation($name, $key= NULL) {
      $details= self::detailsForClass($this->name);

      if (!$details || !($key 
        ? array_key_exists($key, @$details['class'][DETAIL_ANNOTATIONS][$name]) 
        : array_key_exists($name, @$details['class'][DETAIL_ANNOTATIONS])
      )) return raise(
        'lang.ElementNotFoundException', 
        'Annotation "'.$name.($key ? '.'.$key : '').'" does not exist'
      );

      return ($key 
        ? $details['class'][DETAIL_ANNOTATIONS][$name][$key] 
        : $details['class'][DETAIL_ANNOTATIONS][$name]
      );
    }

    /**
     * Retrieve whether a method has annotations
     *
     * @return  bool
     */
    public function hasAnnotations() {
      $details= self::detailsForClass($this->name);
      return $details ? !empty($details['class'][DETAIL_ANNOTATIONS]) : FALSE;
    }

    /**
     * Retrieve all of a method's annotations
     *
     * @return  array annotations
     */
    public function getAnnotations() {
      $details= self::detailsForClass($this->name);
      return $details ? $details['class'][DETAIL_ANNOTATIONS] : array();
    }
    
    /**
     * Retrieve the class loader a class was loaded with
     *
     * @return  lang.ClassLoader
     */
    public function getClassLoader() {
      return self::_classLoaderFor($this->name);
    }
    
    /**
     * Fetch a class' classloader by its name
     *
     * @param   string name fqcn of class
     * @return  lang.ClassLoader
     */
    protected static function _classLoaderFor($name) {
      if (!($cl= xp::registry('classloader.'.$name))) {
        return ClassLoader::getDefault();
      }

      // The class loader information can be a string identifying the responsible
      // classloader for the class. In that case, fetch it's class and get an
      // instance through the instanceFor() method.
      if (is_string($cl)) {
        list($className, $argument)= sscanf($cl, '%[^:]://%s');
        $class= self::forName($className);
        $method= $class->getMethod('instanceFor');

        $dummy= NULL;
        $cl= $method->invoke($dummy, array($argument));
        
        // Replace the "symbolic" representation of the classloader with a reference
        // to an instance.
        xp::$registry['classloader.'.$name]= $cl;
      }
      
      return $cl;
    }

    /**
     * Retrieve details for a specified class. Note: Results from this 
     * method are cached!
     *
     * @param   string class fully qualified class name
     * @return  array or NULL to indicate no details are available
     */
    public static function detailsForClass($class) {
      static $details= array();

      if (!$class) return NULL;        // Border case
      if (isset($details[$class])) return $details[$class];

      // Retrieve class' sourcecode
      $cl= self::_classLoaderFor($class);
      if (!($bytes= $cl->loadClassBytes($class))) return NULL;

      $details[$class]= array(array(), array());
      $annotations= array();
      $comment= NULL;
      $members= TRUE;
      $tokens= token_get_all($bytes);
      for ($i= 0, $s= sizeof($tokens); $i < $s; $i++) {
        switch ($tokens[$i][0]) {
          case T_DOC_COMMENT:
            $comment= $tokens[$i][1];
            break;

          case T_COMMENT:

            // Annotations
            if (strncmp('#[@', $tokens[$i][1], 3) == 0) {
              $annotations[0]= substr($tokens[$i][1], 2);
            } else if (strncmp('#', $tokens[$i][1], 1) == 0) {
              $annotations[0].= substr($tokens[$i][1], 1);
            }

            // End of annotations
            if (']' == substr(rtrim($tokens[$i][1]), -1)) {
              $annotations= eval('return array('.preg_replace(
                array('/@([a-z_]+),/i', '/@([a-z_]+)\(\'([^\']+)\'\)/i', '/@([a-z_]+)\(/i', '/([^a-z_@])([a-z_]+) *= */i'),
                array('\'$1\' => NULL,', '\'$1\' => \'$2\'', '\'$1\' => array(', '$1\'$2\' => '),
                trim($annotations[0], "[]# \t\n\r").','
              ).');');
            }
            break;

          case T_CLASS:
          case T_INTERFACE:
            $details[$class]['class']= array(
              DETAIL_COMMENT      => trim(preg_replace('/\n   \* ?/', "\n", "\n".substr(
                $comment, 
                4,                              // "/**\n"
                strpos($comment, '* @')- 2      // position of first details token
              ))),
              DETAIL_ANNOTATIONS  => $annotations
            );
            $annotations= array();
            $comment= NULL;
            break;

          case T_VARIABLE:
            if (!$members) break;

            // Have a member variable
            $name= substr($tokens[$i][1], 1);
            $details[$class][0][$name]= array(
              DETAIL_ANNOTATIONS => $annotations
            );
            $annotations= array();
            break;

          case T_FUNCTION:
            $members= FALSE;
            while (T_STRING !== $tokens[$i][0]) $i++;
            $m= $tokens[$i][1];
            $details[$class][1][$m]= array(
              DETAIL_ARGUMENTS    => array(),
              DETAIL_RETURNS      => 'void',
              DETAIL_THROWS       => array(),
              DETAIL_COMMENT      => trim(preg_replace('/\n     \* ?/', "\n", "\n".substr(
                $comment, 
                4,                              // "/**\n"
                strpos($comment, '* @')- 2      // position of first details token
              ))),
              DETAIL_ANNOTATIONS  => $annotations,
              DETAIL_NAME         => $tokens[$i][1]
            );
            $matches= NULL;
            preg_match_all(
              '/@([a-z]+)\s*([^<\r\n]+<[^>]+>|[^\r\n ]+) ?([^\r\n ]+)?/',
              $comment, 
              $matches, 
              PREG_SET_ORDER
            );
            $annotations= array();
            $comment= NULL;
            foreach ($matches as $match) {
              switch ($match[1]) {
                case 'param':
                  $details[$class][1][$m][DETAIL_ARGUMENTS][]= $match[2];
                  break;

                case 'return':
                  $details[$class][1][$m][DETAIL_RETURNS]= $match[2];
                  break;

                case 'throws': 
                  $details[$class][1][$m][DETAIL_THROWS][]= $match[2];
                  break;
              }
            }
            break;

          default:
            // Empty
        }
      }
      
      // Return details for specified class
      return $details[$class]; 
    }

    /**
     * Retrieve details for a specified class and method. Note: Results 
     * from this method are cached!
     *
     * @param   string class unqualified class name
     * @param   string method
     * @return  array
     */
    public static function detailsForMethod($class, $method) {
      while ($details= self::detailsForClass(xp::nameOf($class))) {
        if (isset($details[1][$method])) return $details[1][$method];
        $class= get_parent_class($class);
      }
      return NULL;
    }

    /**
     * Retrieve details for a specified class and field. Note: Results 
     * from this method are cached!
     *
     * @param   string class unqualified class name
     * @param   string method
     * @return  array
     */
    public static function detailsForField($class, $field) {
      while ($details= self::detailsForClass(xp::nameOf($class))) {
        if (isset($details[0][$field])) return $details[0][$field];
        $class= get_parent_class($class);
      }
      return NULL;
    }
    
    /**
     * Returns the XPClass object associated with the class with the given 
     * string name. Uses the default classloader if none is specified.
     *
     * @param   string name - e.g. "io.File", "rdbms.mysql.MySQL"
     * @param   lang.ClassLoader classloader default NULL
     * @return  lang.XPClass class object
     * @throws  lang.ClassNotFoundException when there is no such class
     */
    public static function forName($name, $classloader= NULL) {
      if (NULL === $classloader) {
        $fname= strtr('.', '/', $name).'.class.php';

        foreach (explode(PATH_SEPARATOR, ini_get('include_path')) as $path) {
          if (is_dir($path) && file_exists($path.DIRECTORY_SEPARATOR.$fname)) {
            break;
          }
          
          if (is_file($path)) {
            $cl= ArchiveClassLoader::instanceFor($path);
            if ($cl->providesClass($name)) {
              $classloader= $cl;
              break;
            }
          }
        }
      }
    
      // Last-chance fallback
      if (NULL === $classloader) $classloader= ClassLoader::getDefault();

      return $classloader->loadClass($name);
    }
    
    /**
     * Returns an array containing class objects representing all the 
     * public classes
     *
     * @return  lang.XPClass[] class objects
     */
    public static function getClasses() {
      $ret= array();
      foreach (get_declared_classes() as $name) {
        if (xp::registry('class.'.$name)) $ret[]= new self($name);
      }
      return $ret;
    }
  }
?>
