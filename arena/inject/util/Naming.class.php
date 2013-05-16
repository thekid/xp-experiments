<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.NamingException');

  /**
   * (Insert class' description here)
   *
   */
  class Naming extends Object {
    protected $dir= array();
  
    public function lookup($path) {
      if (!isset($this->dir[$path])) {
        throw new NamingException('No such object by path "'.$path.'"');
      }
      return $this->dir[$path];
    }
    
    public function bind($path, $o) {
      $path= rtrim($path, '/');
      $this->dir[$path]= $o;
    }
    
    public function create(XPClass $o) {

      // Create instance
      if ($o->hasConstructor()) {
        $c= $o->getConstructor();
        $args= array();
        if ($c->hasAnnotation('inject')) {
          $path= $c->getAnnotation('inject');
          foreach ($c->getParameters() as $param) {
            $args[]= $this->lookup($path.'/'.$param->getName());
          }
        }
        $i= $c->newInstance($args);
      } else {
        $i= $o->newInstance();
      }
      
      // Call injection methods
      foreach ($o->getMethods() as $m) {
        if (!$m->hasAnnotation('inject')) continue;
        
        $path= $m->getAnnotation('inject');
        $args= array();
        foreach ($m->getParameters() as $param) {
          $args[]= $this->lookup($path.'/'.$param->getName());
        }
        $m->invoke($i, $args);
      }
      
      return $i;
    }
  }
?>
