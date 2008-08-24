<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @see      reference
   * @purpose  purpose
   */
  class EntityManager extends Object {
    protected $classes= array();
  
    protected function classes($class) {
      $id= $class->getName();
      if (!isset($this->classes[$id])) {
        $this->classes[$id]= array(
          $class->hasAnnotation('table', 'name') ? $class->getAnnotation('table', 'name') : strtolower(xp::reflect($id)),
          $class->getAnnotation('entity')
        );
        foreach ($class->getFields() as $field) {
          if ($field->hasAnnotation('column')) {
            $name= $field->hasAnnotation('column', 'name') ? $field->getAnnotation('column', 'name') : $field->getName();
            $this->classes[$id][3][$name]= $field;
            if ($field->hasAnnotation('id')) {
              $this->classes[$id][2]= $name;
            }
          }
        }
      }
      return $this->classes[$id];
    }
   
    /**
     * (Insert method's description here)
     *
     * @param   
     * @param   
     * @return  
     */
    public function find(XPClass $class, $id) {
      $e= $this->classes($class);
      if (!($r= ConnectionManager::getInstance()->getByHost($e[1]['datasource'], 0)->query(
        'select * from %l where %l = %d',
        $e[0],
        $e[2],
        $id
      )->next())) {
        return xp::null();
      }
      
      $i= $class->newInstance();
      $e[3][$e[2]]->set($i, $e[2]);
      foreach ($e[3] as $name => $field) {
        $field->set($i, $r[$name]);
      }
      return $i;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function persist(Object $o) {
    
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function remove(Object $o) {
    
    }
  }
?>
