<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
  uses('lang.IllegalArgumentException');

/**
 * A stateful list for expectations.
 *
 * @purpose 
 */
  class ExpectationList extends Object {
    private 
      $list= null,
      $current=0;
    
      /**
       * Constructor      
       */
      public function __construct() {
        $this->list=new Vector();
      }


      /**
       * Adds an expectation.
       * 
       * @param unittest.mock.Expectation expectation    
       */
      public function add($expectation) {
        if(!($expectation instanceof Expectation))
          throw new IllegalArgumentException("Expectation expected.");
        
        $this->list->add($expectation);
      }


      /**
       * Returns the next expectation or null if no expectations left.
       * 
       * @return unittest.mock.Expectation  
       */
      public function getNext() {
        if($this->current >= $this->list->size())
          return null;
        
        return $this->list->get($this->current++);
      }

    
    
}
?>