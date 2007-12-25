<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('net.xp_framework.quantum.task.QuantTask');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantTstampTask extends QuantTask {
  
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute(QuantEnvironment $env) {
      $env->put('DSTAMP', Date::now()->toString('Ymd'));
      $env->put('TSTAMP', Date::now()->toString('hi'));
      $env->put('TODAY', Date::now()->toString('M d Y'));
    }
  }
?>
