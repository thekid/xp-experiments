<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.text';
  
  uses(
    'xp.ide.text.Snippet'
  );

  /**
   * PHP source stream worker
   *
   * @purpose  IDE
   */
  class xp·ide·text·StreamWorker extends Object {

    /**
     * grep a class name from $this->inputStream
     *
     * @param  xp.ide.text.IInputStream input
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.text.Snippet
     */
    public function grepClassName(xp·ide·text·IInputStream $stream, xp·ide·Cursor $cursor) {
      $buffer= '';
      while ($stream->available() && $this->eStrlen($buffer, $stream->getEncoding()) < $cursor->getPosition()) {
        $buffer.= $stream->read($cursor->getPosition() - $this->eStrlen($buffer, $stream->getEncoding()));
      }

      $searchword= '';
      $byte_startpos= strlen($buffer);
      for ($i= $byte_startpos - 1; $i >= 0; $i--) {
        if (!$this->isClassChar($buffer{$i})) break;
        $byte_startpos= $i;
        $searchword= $buffer{$i}.$searchword;
      }
      $startpos= $this->eStrlen($buffer, $stream->getEncoding()) - $this->eStrlen($searchword, $stream->getEncoding());
      while ($c= $stream->read(1)) {
        if (!$this->isClassChar($c)) break;
        $searchword.= $c;
      }
      return new xp·ide·text·Snippet($startpos, $searchword);
    }

    /**
     * get the string length of characters
     * respecting encoding
     *
     * @param   string string
     * @param   string encoding
     * @return  bool
     */
    private function eStrlen(&$string, $encoding) {
      return xp·ide·text·IInputStream::ENCODING_NONE == $encoding ? strlen($string) : iconv_strlen($string, $encoding);
    }

    /**
     * test if char is allowed in a fully qualified class name
     *
     * @param   char c
     * @return  bool
     */
    private function isClassChar($c) {
      if (FALSE !== strpos('._', $c)) return TRUE;
      if (96 < ord(strToLower($c)) && ord(strToLower($c)) < 123) return TRUE;
      if (47 < ord($c) && ord($c) < 58) return TRUE;
      return FALSE;
    }

  }
?>
