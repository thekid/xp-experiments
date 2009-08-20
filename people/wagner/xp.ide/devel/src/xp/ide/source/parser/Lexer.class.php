<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$
 */

  $package= 'xp.ide.source.parser';

  uses(
    'xp.ide.source.parser.Token',
    'net.jaylex.JlexBase'
  );

  /**
   * Lexer for php language
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  abstract class xp·ide·source·parser·Lexer extends net·jaylex·JLexBase {

    public
      $value= '',
      $token= NULL,
      $position= array(0, 0);

    private
      $buffer= '';

    /**
     * Advance to next token. Return TRUE and set token, value and
     * position members to indicate we have more tokens, or FALSE
     * to indicate we've arrived at the end of the tokens.
     *
     * @return  bool
     */
    public function advance() {
      $this->value= NULL;
      $this->yylex();
      return NULL !== $this->value;
    }

    protected function resetBuffer() {
      $this->buffer= '';
    }

    protected function addBuffer($s) {
      $this->buffer.= $s;
    }

    protected function getBuffer() {
      return $this->buffer;
    }

    protected function createToken($t, $v= NULL) {
      $this->value= new xp·ide·source·parser·Token();
      $this->token= $t;
      $this->value->setValue(NULL === $v ? $this->yytext() : $v);
      $this->value->setLine($this->yyline);
      $this->value->setColumn($this->yycol);
      $this->position= array($this->yyline, $this->yycol);
    }

    protected function tokenFrom($t, $v, $l= 0, $c= 0) {
      $this->value= new xp·ide·source·parser·Token();
      $this->token= $t;
      $this->value->setValue($v);
      $this->value->setLine($l);
      $this->value->setColumn($c);
      $this->position= array($l, $c);
    }

  }
?>
