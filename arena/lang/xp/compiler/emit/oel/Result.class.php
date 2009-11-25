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
    protected $type= NULL;
    
    /**
     * Constructor.
     *
     * @param   xp.compiler.types.Types type
     * @param   resource op
     */
    public function __construct(Types $type, $op) {
      $this->type= $type;
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

    /**
     * Return type
     *
     * @return  xp.compiler.types.Types type
     */
    public function type() {
      return $this->type;
    }

    /**
     * Execute with a given environment settings
     *
     * @param   array<string, var> env
     * @return  var
     */    
    public function executeWith(array $env= array()) {
      oel_execute($this->op);
      $class= $this->type->literal();
      method_exists($class, '__static') && call_user_func(array($class, '__static'));
    }
  }
?>
