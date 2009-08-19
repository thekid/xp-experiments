<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$
 */

  $package= 'xp.ide.source.parser';

  uses(
    'xp.ide.source.parser.ClassParser',
    'xp.ide.source.parser.Lexer',
    'text.StringTokenizer'
  );

  /**
   * Lexer for php language
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  class xp·ide·source·parser·ClassLexer extends xp·ide·source·parser·Lexer {

    const
      S_CLASS= 1,
      S_ENCAPSED= 2;

    private
      $state= self::S_CLASS,
      $encapse= '',
      $t= '',
      $tok= 0,
      $line= 0,
      $col= 0;

    public function __construct($string) {
      $this->tok= new StringTokenizer($string, "\n\t \r{}()=.;,'\"", TRUE);
    }

    protected function tokenFrom($t, $v) {
      parent::tokenFrom($t, $v, $this->line, $this->col);
    }

    /**
     * Advance this 
     *
     * @return  bool
     */
    public function advance() {
      $c= '';
      while ($this->tok->hasMoreTokens()) {
        $this->col+= strlen($this->t);
        $this->t= $this->tok->nextToken();

        if ("\n" == $this->t) {
          $this->line++;
          $this->pos= 0;
        }

        switch ($this->state) {
          case self::S_ENCAPSED:
          $c.= $this->t;
          if ($this->t != $this->encapse || substr($c, -2, 1) === '\\') continue(2);
          $this->state= self::S_CLASS;
          $this->tokenFrom(xp·ide·source·parser·ClassParser::T_ENCAPSED_STRING, $c);
          break;

          case self::S_CLASS:
          if (FALSE !== strpos("\n\t \r", $this->t)) {
            continue(2);
          } else if (is_numeric($this->t)) {
            $this->tokenFrom(xp·ide·source·parser·ClassParser::T_NUMBER, $this->t);
          } else if (strlen($this->t) === 1) {
            if (FALSE !== strpos("\"'", $this->t)) {
              $this->encapse= $c= $this->t;
              $this->state= self::S_ENCAPSED;
              continue(2);
            }
            $this->tokenFrom(ord($this->t), $this->t);
          } else if ($this->is('const', xp·ide·source·parser·ClassParser::T_CONST)) {
          } else if ($this->is('private', xp·ide·source·parser·ClassParser::T_PRIVATE)) {
          } else if ($this->is('protected', xp·ide·source·parser·ClassParser::T_PROTECTED)) {
          } else if ($this->is('public', xp·ide·source·parser·ClassParser::T_PUBLIC)) {
          } else if ($this->is('static', xp·ide·source·parser·ClassParser::T_STATIC)) {
          } else if ($this->is('array', xp·ide·source·parser·ClassParser::T_ARRAY)) {
          } else if ($this->is('null', xp·ide·source·parser·ClassParser::T_NULL)) {
          } else if ($this->is('true', xp·ide·source·parser·ClassParser::T_BOOLEAN)) {
          } else if ($this->is('false', xp·ide·source·parser·ClassParser::T_BOOLEAN)) {
          } else if ($this->pgrep('/^\$+.+/', xp·ide·source·parser·ClassParser::T_VARIABLE)) {
          } else {
            $this->tokenFrom(xp·ide·source·parser·ClassParser::T_STRING, $this->t);
          }
          break;
        }
        return TRUE;
      }
      return FALSE;
    }

    private function is($test, $token) {
      $tok= $this->t;
      if (strlen($tok) != strlen($test)) return FALSE;
      if (strToLower($tok) != $test) return FALSE;
      $this->tokenFrom($token, $this->t);
      return TRUE;
    }

    private function pgrep($test, $token) {
      if (!preg_match($test, $this->t)) return FALSE;
      $this->tokenFrom($token, $this->t);
      return TRUE;
    }

  }
?>
