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

    /**
     * Advance to next token. Return TRUE and set token, value and
     * position members to indicate we have more tokens, or FALSE
     * to indicate we've arrived at the end of the tokens.
     *
     * @return  bool
     */
    public function advance() {
      $this->token= $this->yylex();
      $this->position= array($this->yyline, $this->yycol);
      $this->value= new xp·ide·source·parser·Token();
      $this->value->setValue($this->yytext());
      $this->value->setLine($this->yyline);
      $this->value->setColumn($this->yycol);
      return TRUE;
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
