<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.text';
  
  uses(
    'xp.ide.text.IInputStream',
    'io.streams.ChannelInputStream'
  );
  
  /**
   * channel input stream with encoding meta information
   *
   * @purpose  IDE
   */
  class xp·ide·text·ChannelInputStream extends ChannelInputStream implements xp·ide·text·IInputStream {
    private
      $encoding= xp·ide·text·IInputStream::ENCODING_NONE;

    /**
     * Set encoding
     *
     * @param   string encoding
     */
    public function setEncoding($encoding) {
      $this->encoding= $encoding;
    }

    /**
     * Get encoding
     *
     * @param   string
     */
    public function getEncoding() {
      return $this->encoding;
    }

  }
?>
