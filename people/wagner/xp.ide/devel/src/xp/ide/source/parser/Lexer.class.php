<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$
 */

  $package= 'xp.ide.source.parser';

  uses(
    'xp.ide.source.parser.Token',
    'text.parser.generic.AbstractLexer'
  );

  /**
   * Lexer for php language
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  abstract class xp·ide·source·parser·Lexer extends AbstractLexer {

    public
      $value= '',
      $token= NULL,
      $position= array(0, 0);

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
