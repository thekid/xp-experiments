<?php
/* This class is part of the XP framework
 *
 * $Id: Result.class.php 11013 2009-04-23 20:42:33Z friebe $ 
 */

  $package= 'xp.compiler.emit.source';
  
  uses('io.streams.OutputStream', 'io.streams.Streams');

  /**
   * Compilation result from source emitter
   *
   * @ext   oel
   */
  class xp·compiler·emit·source·Result extends Object {
    protected $source= NULL;
    protected $type= NULL;
    
    /**
     * Constructor.
     *
     * @param   xp.compiler.types.Types type
     * @param   xp.compiler.emit.source.Buffer source
     */
    public function __construct(Types $type, $source) {
      $this->type= $type;
      $this->source= $source;
    }
    
    /**
     * Write this result to an output stream
     *
     * @param   io.streams.OutputStream out
     */
    public function writeTo(OutputStream $out) {
      $out->write('<?php');
      $out->write($this->source);
      $out->write("\n?>\n");
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
      if (FALSE === eval($this->source)) {
        xp::error(xp::stringOf(new FormatException((string)$this->source)));
      }
      $class= $this->type->literal();
      method_exists($class, '__static') && call_user_func(array($class, '__static'));
      xp::$registry['classloader.'.$this->type->name()]= 'compiled://'.$this->hashCode();
    }
  }
?>
