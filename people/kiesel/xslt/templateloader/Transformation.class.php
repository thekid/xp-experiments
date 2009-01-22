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
     * Main runner method
     *
     */
    public function run() {
      stream_wrapper_register('xsl', 'XSLFileLoader');
    
      $proc= new DomXSLProcessor();
      $proc->setXMLBuf('<document/>');
      
      $proc->setXSLFile('xsl://XSL-INF/master.xsl');
      
      $proc->run();
      
      $this->out->writeLine('>>> ', $proc->output());
    }
  }
?>
