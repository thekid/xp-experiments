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
  class QuantChgrpTask extends AttributeTask {
    protected
      $group    = NULL;      

    #[@xmlmapping(element= '@group')]
    public function setGroup($g) {
      $this->group= $g;
    }
    
    protected function perform($uri) {
      if (FALSE === chgrp(parent::perform($uri), $this->group))
        throw new IOException('Could not change group to "'.$this->group.'" for '.$name);
    }
    
    protected function writeStats() {
      $this->env()->out->writeLinef('Changed group of %d files and %d directories to group %s',
        $this->stats['file'],
        $this->stats['dir'],
        $this->group
      );      
    }
  }
?>
