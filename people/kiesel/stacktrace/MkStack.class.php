<?php
/** This file is part of the XP framework
 *
 * $Id$
 */

  class MkStack extends Object {
    public static function main($args) {
      $s= new self();
      $s->call(5);
    }
    
    protected function call($i) {
      if (0 == $i) $this->callInner();
      $this->call($i -1);
    }
    
    protected function callInner() {
      throw new XPException('Got me.');
    }
  }
?>