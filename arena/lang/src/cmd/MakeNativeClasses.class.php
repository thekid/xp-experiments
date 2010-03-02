<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'util.collections.HashTable',
    'io.Folder',
    'io.File'
  );

  /**
   * Makes native classes
   *
   */
  class MakeNativeClasses extends Command {
    protected $package= '';
    protected $target= NULL;
  
    /**
     * Set namespace
     *
     * @param   string name
     */
    #[@arg(position= 0)]
    public function setNamespace($name) {
      $this->package= $name;
    }
    
    /**
     * Set output directory
     *
     * @param   string target
     */
    #[@arg(short= 'O')]
    public function setOutput($target= '.') {
      $this->target= new Folder($target);
    }
    
    /**
     * Main runner method
     *
     */
    public function run() {
      $this->out->writeLine('===> Starting for ', $this->namespace);
      
      // Create name map and directory layout
      $names= array();
      foreach (get_loaded_extensions() as $extname) {
        $ext= new ReflectionExtension($extname);

        $extname= strtolower($extname);
        foreach ($ext->getClasses() as $class) {
          $package= $this->package.'.'.$extname;
          $f= new Folder($this->target, strtr($package, '.', DIRECTORY_SEPARATOR));
          $f->exists() || $f->create();
          $names[$class->getName()]= $package.'.'.$class->getName();
        }
      }
      
      $this->out->writeLine('---> Generating ', sizeof($names), ' classes');
      foreach ($names as $name => $qualified) {
        $f= new File($this->target, strtr($qualified, '.', DIRECTORY_SEPARATOR).xp::CLASS_FILE_EXT);
        $this->out->write('     >> ', $qualified, ': ');
        
        with ($class= new ReflectionClass($name), $out= $f->getOutputStream()); {
          $out->write('<?php ');
          
          // Uses
          $uses= array();
          if ($parent= $class->getParentClass()) {
            $uses[]= $names[$parent->getName()];
          }
          foreach ($class->getInterfaces() as $implemented) {
            $uses[]= $names[$implemented->getName()];
          }
          $uses= array_filter(array_unique($uses));
          $uses && $out->write('uses(\''.implode('\', \'', $uses).'\');');
          
          // Class name
          $out->write(sprintf(
            'xp::$registry[\'class.%1$s\']= \'%2$s\';'.
            'xp::$registry[\'details.%2$s\']= array();',
            $name,
            $qualified
          ));
          $out->write('?>');
        }
        
        $this->out->writeLine('OK');
      }
    }
  }
?>
