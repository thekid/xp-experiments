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

    protected function tokenFrom($t) {
      $this->value= new xp·ide·source·parser·Token();
      $this->token= $t[0];
      $this->value->setValue($t[1]);
      $this->value->setLine($t[2]);
      $this->value->setColumn(0);
      $this->position= array($t[2], 0);
    }

  }
?>
