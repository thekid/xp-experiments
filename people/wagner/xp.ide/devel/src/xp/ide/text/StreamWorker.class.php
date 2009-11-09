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
     * @param  io.streams.TextReader text
     * @param  xp.ide.Cursor cursor
     * throws lang.IllegalStateException
     * @return xp.ide.text.Snippet
     */
    public function grepClassName(TextReader $text, xp·ide·Cursor $cursor) {
      $buffer= $text->read($cursor->getPosition());
      if (strlen($buffer) < $cursor->getPosition()) throw new IllegalStateException('cursor behind end');
      $searchword= '';
      for ($i= strlen($buffer) - 1; $i >= 0; $i--) {
        if (!$this->isClassChar($buffer{$i})) break;
        $searchword= $buffer{$i}.$searchword;
      }
      $startpos= strlen($buffer) - strlen($searchword);
      while (NULL !== $c= $text->read(1)) {
        if (!$this->isClassChar($c)) break;
        $searchword.= $c;
      }
      return new xp·ide·text·Snippet($startpos, $searchword);
    }

    /**
     * test if char is allowed in a fully qualified class name
     *
     * @param   char c
     * @return  bool
     */
    private function isClassChar($c) {
      if (FALSE !== strpos('._·', $c)) return TRUE;
      if (96 < ord(strToLower($c)) && ord(strToLower($c)) < 123) return TRUE;
      if (47 < ord($c) && ord($c) < 58) return TRUE;
      return FALSE;
    }

  }
?>
