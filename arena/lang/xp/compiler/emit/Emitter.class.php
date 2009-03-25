<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.ast.Node', 'xp.compiler.ast.ParseTree', 'util.log.Traceable');

  /**
   * (Insert class' description here)
   *
   * @see      xp://xp.compiler.ast.Node
   */
  abstract class Emitter extends Object implements Traceable {
    protected $cat = NULL;
    protected $errors = array();
    
    /**
     * Emit a parse tree
     *
     * @param   xp.compiler.ast.ParseTree tree
     * @return  
     */
    public abstract function emit(ParseTree $tree);

    /**
     * Raise an error
     *
     * @param   string code
     * @param   string message
     * @param   xp.compiler.ast.Node context
     */
    protected function error($code, $message, xp·compiler·ast·Node $context= NULL) {
      if ($context) {               // Use given context node
        $pos= $context->position;
      } else {                      // Try to determine last context node from backtrace
        $pos= array(0, 0);
        foreach (create(new Throwable(NULL))->getStackTrace() as $element) {
          if (
            'emit' == substr($element->method, 0, 4) &&
            sizeof($element->args) > 1 &&
            $element->args[1] instanceof xp·compiler·ast·Node
          ) {
            $pos= $element->args[1]->position;
            break;
          }
        }
      }
      
      $message= sprintf(
        '[%4s] %s at line %d, offset %d',
        $code,
        $message,
        $pos[0],
        $pos[1]
      );
      
      $this->cat && $this->cat->error($message);
      $this->errors[]= $message;
    }
    
    
    /**
     * Set a trace for debugging
     *
     * @param   util.log.LogCategory cat
     */
    public function setTrace($cat) {
      $this->cat= $cat;
    }
  }
?>
