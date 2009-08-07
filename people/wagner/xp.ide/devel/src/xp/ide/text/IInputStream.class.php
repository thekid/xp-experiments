<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.text';
  
  uses(
    'io.streams.InputStream'
  );
  
  /**
   * input stream interface with encoding meta information
   *
   * @purpose  IDE
   */
  interface xp·ide·text·IInputStream extends InputStream {
    const ENCODING_NONE= "BINARY";

    /**
     * Set encoding
     *
     * @param   string encoding
     */
    public function setEncoding($encoding);

    /**
     * Get encoding
     *
     * @param   string
     */
    public function getEncoding();

  }
?>
