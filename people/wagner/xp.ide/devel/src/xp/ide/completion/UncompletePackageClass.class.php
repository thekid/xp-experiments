<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.completion';
  
  /**
   * uncomplete fully quallivied package/class name
   *
   * @purpose  IDE
   */
  class xp·ide·completion·UncompletePackageClass extends Object {
    private
      $complete= '',
      $uncomplete= '',
      $origin= '';

    /**
     * constructor
     *
     * @param   string name
     */
    public function __construct($name= '') {
      $this->origin= $name;
      if (!ClassLoader::getDefault()->providesPackage($name)) {
        if (FALSE === strrpos($name, '.')) {
          $this->uncomplete= $name;
          $name= '';
        } else {
          $this->uncomplete= substr($name, 1 + strrpos($name, '.'));
          $name= substr($name, 0, strrpos($name, '.'));
        }
      }
      $this->complete= $name;
    }

    /**
     * Get complete
     *
     * @return  string
     */
    public function getComplete() {
      return $this->complete;
    }

    /**
     * Get uncomplete
     *
     * @return  string
     */
    public function getUncomplete() {
      return $this->uncomplete;
    }

    /**
     * Get origin
     *
     * @return  string
     */
    public function getOrigin() {
      return $this->origin;
    }

  }
?>
