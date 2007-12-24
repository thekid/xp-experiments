<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('ant.task.file.AttributeTask');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class AntChownTask extends AttributeTask {
    protected
      $owner    = NULL;
      
    #[@xmlmapping(element= '@owner')]
    public function setOwner($o) {
      $this->owner= $o;
    }
    
    protected function perform($env, $uri) {
      if (FALSE === chown(parent::perform($env, $uri), $this->owner))
        throw new IOException('Could not change owner to "'.$this->group.'" for '.$name);
    }
    
    protected function writeStats($env) {
      $this->verbose && $env->out->writeLinef('Changed owner of %d files and %d directories to user "%s"',
        $this->stats['file'],
        $this->stats['dir'],
        $this->owner
      );
    }
  }
?>
