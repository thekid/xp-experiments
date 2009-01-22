<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses(
    'util.cmd.Command',
    'xml.DomXSLProcessor',
    'XSLFileLoader'
  );

  /**
   * Transformation
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class Transformation extends Command {
  
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function transformAgainst($path) {
      $this->out->writeLine('---> Running against xsl: ', $path);
      $proc= new DomXSLProcessor();
      $proc->setXMLBuf('<document/>');
      
      $proc->setXSLFile($path);
      $proc->run();
      $this->out->writeLine('>>> ', $proc->output());
    }  

    /**
     * Main runner method
     *
     */
    public function run() {
      stream_wrapper_register('xsl', 'XSLFileLoader');
      $this->transformAgainst('xsl://XSL-INF/master.xsl');
      $this->transformAgainst('xsl://XSL-INF/stylesheet-including-master.xsl');
    }
  }
?>
