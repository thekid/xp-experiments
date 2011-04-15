<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.log.Appender',
    'scriptlet.HttpScriptletResponse',
    'webservices.json.JsonDecoder'
  );

  /**
   * Appender which appends all data to the FirePHP console
   *
   * @see      xp://util.log.Appender
   * @purpose  Appender
   */  
  class FirebugAppender extends Appender {
    protected $buffer= array();

    /**
     * Append data
     *
     * @param   util.log.LoggingEvent event
     */ 
    public function append(LoggingEvent $event) {
      $this->buffer[]= $event;
    }
    
    /**
     * Get buffer's contents
     *
     * @return  string
     */
    public function getBuffer() {
      return $this->buffer;
    }
    
    /**
     * Clears the buffers content.
     *
     */
    public function clear() {
      $this->buffer= '';
    }

    /**
     * Write appender data to response
     *
     * @param   scriptlet.HttpResponse response
     */
     public function writeTo(HttpScriptletResponse $response) {
       $encoder= new JsonDecoder();

       $response->setHeader('X-Wf-Protocol-1', 'http://meta.wildfirehq.org/Protocol/JsonStream/0.2');
       $response->setHeader('X-Wf-1-Plugin-1', 'http://meta.firephp.org/Wildfire/Plugin/FirePHP/Library-FirePHPCore/0.3');
       $response->setHeader('X-Wf-1-Structure-1', 'http://meta.firephp.org/Wildfire/Structure/FirePHP/FirebugConsole/0.1');

       $i= 1;
       foreach ($this->buffer as $event) {
         $fmtd= $this->layout->format($event);

         switch ($event->getLevel()) {
           default:
           case LogLevel::DEBUG: $type= "LOG"; break;
           case LogLevel::INFO: $type= "INFO"; break;
           case LogLevel::WARN: $type= "WARN"; break;
           case LogLevel::ERROR: $type= "ERROR"; break;
         }

         $str= $encoder->encode(array(
           array('Type' => $type),
           array($fmtd)
         ));

         $offset= 0;
         $out= strlen($str);
         while ($offset < strlen($str)) {
           $use= substr($str, $offset, 4000);

           $out.= '|'.$use.'|';
           $offset+= strlen($use);

           if ($offset < strlen($str)) $out.= '\\';

           $response->setHeader(sprintf('X-Wf-1-1-1-%d', $i++), $out);

           $out= '';
         }
       }
     }
  }
?>
