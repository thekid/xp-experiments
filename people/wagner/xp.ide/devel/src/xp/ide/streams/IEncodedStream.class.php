<?php
/* This class is part of the XP framework
 *
 * $Id: IInputStream.class.php 11317 2009-08-07 12:34:15Z ruben $ 
 */
  $package= 'xp.ide.streams';

  /**
   * stream interface with encoding meta information
   *
   * @purpose  IDE
   */
  interface xp·ide·streams·IEncodedStream {
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
