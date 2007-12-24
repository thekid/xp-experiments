<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  
   /**
    * Build Exception, can optionally take an exit code
    *
    * @purpose  Indicate build failure
    */
   class AntBuildException extends XPException {
     protected
      $statusCode = NULL;
      
     public function __construct($message, $statusCode= NULL) {
       parent::__construct($message);
       $this->statusCode= $statusCode;
     }
     
     public function getStatusCode() {
       return $this->statusCode;
     }
   }
?>