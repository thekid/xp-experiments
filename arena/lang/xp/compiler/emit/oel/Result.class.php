<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler.emit.oel';
  
  uses('io.streams.OutputStream', 'io.streams.Streams');

  /**
   * Compilation result from OEL emitter
   *
   * @ext   oel
   */
  class xp·compiler·emit·oel·Result extends Object {
    protected $op= NULL;
    
    /**
     * Constructor.
     *
     * @param   resource op
     */
    public function __construct($op) {
      $this->op= $op;
    }
    
    /**
     * Write this result to an output stream
     *
     * @param   io.streams.OutputStream out
     */
    public function writeTo(OutputStream $out) {
      with ($fd= Streams::writeableFd($out)); {
        oel_write_header($fd);
        oel_write_op_array($fd, $this->op);
      }
    }
  }
?>
