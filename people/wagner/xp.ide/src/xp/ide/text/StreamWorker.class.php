<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.text';
  
  uses(
    'xp.ide.Snippet'
  );

  /**
   * PHP source stream worker
   *
   * @purpose  IDE
   */
  class xp·ide·text·StreamWorker extends Object {
    private
      $inputStream= NULL,
      $cursor= NULL;

    /**
     * consructor
     *
     * @param   lang.Object inputStream
     * @param   xp.ide.Cursor cursor
     */
    public function __construct($inputStream, $cursor) {
      $this->inputStream= $inputStream;
      $this->cursor= $cursor;
    }

    /**
     * grep a class name from $this->inputStream
     *
     * @return xp.ide.Snippet
     */
    public function grepClassName() {
      $buffer= (0 == $this->cursor->getPosition()) ? '' : $this->inputStream->read($this->cursor->getPosition());
      $searchword= '';
      $startpos= strlen($buffer);
      for ($i= $startpos - 1; $i >= 0; $i--) {
        if (!$this->isClassChar($buffer{$i})) break;
        $startpos= $i;
        $searchword= $buffer{$i}.$searchword;
      }
      while ($c= $this->inputStream->read(1)) {
        if (!$this->isClassChar($c)) break;
        $searchword.= $c;
      }
      return new xp·ide·Snippet($startpos, $searchword);
    }

    /**
     * test if char is allowed in a fully qualified class name
     *
     * @param   char c
     * @return  bool
     */
    private function isClassChar($c) {
      if ($c == '.') return TRUE;
      if (96 < ord(strToLower($c)) && ord(strToLower($c)) < 123) return TRUE;
      if (47 < ord($c) && ord($c) < 58) return TRUE;
      return FALSE;
    }
    
    /**
     * Set inputStream
     *
     * @param   lang.Object inputStream
     */
    public function setInputStream($inputStream) {
      $this->inputStream= $inputStream;
    }

    /**
     * Set cursor
     *
     * @param   xp.ide.Cursor cursor
     */
    public function setCursor($cursor) {
      $this->cursor= $cursor;
    }

  }
?>
