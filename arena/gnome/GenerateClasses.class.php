<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 
  uses('io.streams.FileOutputStream', 'io.File', 'io.Folder');

  /**
   * Generates widget classes
   *
   * @ext      php-gtk
   */
  class GenerateClasses extends Object {
  
    protected static function translateClass(ReflectionClass $class) {
      return substr($class->getName(), strlen('Gtk'));
    }

    protected static function translateMethod(ReflectionMethod $method) {
      $name= $method->getName();
      if ('__construct' === $name) return $name;
      
      $methodName= '';
      foreach (explode('_', $method->getName()) as $i => $part) {
        $methodName.= $i ? ucfirst($part) : strtolower($part);
      }
      return $methodName;
    }
    
    protected function toPath($name) {
      return strtr($name, '.', DIRECTORY_SEPARATOR);
    }
  
    public static function main(array $args) {
      $package= Package::forName('org.gnome.gtk');
      $target= new Folder('generated', self::toPath($package->getName()));
      $target->exists() || $target->create();
      Console::writeLine('===> Output to ', $target);
      
      foreach (get_declared_classes() as $name) {
        $class= new ReflectionClass($name);
        if (!$class->isSubclassOf('GtkWidget')) continue;
        
        $className= self::translateClass($class);
        Console::writeLine('---> Processing ', $class->getName(), ' => ', $className);

        $file= new File($target, self::toPath(self::translateClass($class)).xp::CLASS_FILE_EXT);
        if ($file->exists()) {
          $file->open(FILE_MODE_READ);
          if (!strstr($file->read(8192), '* @generated')) {
            Console::writeLine('---> Not generated, continuing');
            continue;
          }
        }
        
        // Create
        with ($out= new FileOutputStream($file)); {
        
          // File header
          $out->write('<?php
  /* This class is part of the XP framework
   *
   * $Id$ 
   */

');
          $out->write('  uses(\''.$package->getName().'.'.self::translateClass($class->getParentClass()).'\');'."\n");
          $out->write('
  /**
   * '.$class->getName().'
   *
   * @generated
   * @ext   php-gtk
   */
');

          $out->write('  class '.$className.' extends '.self::translateClass($class->getParentClass()).' {'."\n\n");
          foreach ($class->getMethods() as $method) {
            if ($method->getDeclaringClass() != $class) continue;

            $methodName= self::translateMethod($method);
            $signature= $args= $docParams= array();
            foreach ($method->getParameters() as $param) {
              try {
                $typeHint= $param->getClass();
              } catch (ReflectionException $e) {
                Console::$err->writeLine('*** ', $param->getName(), ' ~ ', $e);
                $typeHint= NULL;
              }
              $signature[]= (NULL === $typeHint ? '' : self::translateClass($typeHint).' ').'$'.$param->name;
              $docParams[]= (NULL === $typeHint ? '' : $package->getName().'.'.self::translateClass($typeHint).' ').$param->name;
              $args[]= '$'.$param->name;
            }
            Console::writeLine('     >> ', $method->getName(), ' => ', $methodName);
            
            // Api doc
            $out->write('    /**'."\n");
            if ('__construct' != $methodName) {
              $out->write('     * '.$methodName."\n");
            } else {
              $out->write('     * Constructor'."\n");
            }
            $out->write('     *'."\n");
            foreach ($docParams as $param) {
              $out->write('     * @param   '.$param."\n");
            }
            if ('__construct' != $methodName) {
              $out->write('     * @return  mixed'."\n");
            }
            $out->write('     */'."\n");
            
            // Delegation
            $out->write('    public function '.$methodName.'('.implode(', ', $signature).') {'."\n");
            if ('__construct' == $methodName) {
              $out->write('      $this->handle= new '.$class->getName().'('.implode(', ', $args).');'."\n");
            } else {
              $out->write('      return $this->handle->'.$method->getName().'('.implode(', ', $args).');'."\n");
            }
            $out->write('    }'."\n\n");
          }
          $out->write('  }'."\n?>\n");

          // Done
          $out->close();
          Console::writeLine('---> ', $out);
        }
      }
    }
  }
?>
