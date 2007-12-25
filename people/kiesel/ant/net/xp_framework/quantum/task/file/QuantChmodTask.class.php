<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('net.xp_framework.quantum.task.file.AttributeTask');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantChmodTask extends AttributeTask {
    protected
      $perm = NULL;
      
    #[@xmlmapping(element= '@perm')]
    public function setPerm($p) {
      if (!is_numeric($p)) throw new IllegalArgumentException('Non-numeric permission values are not supported, yet');
      $this->perm= $p;
    }
    
    protected function perform($env, $uri) {
      if (FALSE === chmod(parent::perform($env, $uri), octdec($this->perm)))
        throw new IOException('Could not change owner to "'.$this->group.'" for '.$name);
    }
    
    protected function writeStats($env) {
      $this->verbose && $env->out->writeLinef('Changed mode of %d files and %d directories to %s',
        $this->stats['file'],
        $this->stats['dir'],
        $this->perm
      );
    }
  }
?>
