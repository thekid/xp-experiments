<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.InputStream');

  /**
   * Writes XML in a streaming fashion
   *
   * @ext      iconv
   * @test     xp://testXmlStreamReaderTest
   */
  class XmlStreamReader extends Object {
    protected $stream       = NULL;
    
    /**
     * Creates a new XML stream writer
     *
     * @param   io.streams.OutputStream stream
     */
    public function __construct(InputStream $stream) {
      $this->stream= $stream;
    }
  }
?>
