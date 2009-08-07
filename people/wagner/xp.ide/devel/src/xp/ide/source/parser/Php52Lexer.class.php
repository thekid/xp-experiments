<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$
 */

  $package= 'xp.ide.source.parser';

  uses(
    'text.StringTokenizer',
    'xp.ide.source.parser.Php52Parser',
    'text.parser.generic.AbstractLexer'
  );

  /**
   * Lexer for mathematical expressions
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  class xp搏de新ource搆arser感hp52Lexer extends AbstractLexer {

    const DELIMITERS= " +-*:/%()\r\n\t";

    protected $tokenizer= NULL;

    /**
     * Constructor
     *
     * @param   string expression
     */
    public function __construct($expression) {
      $this->tokenizer= new StringTokenizer($expression, self::DELIMITERS, TRUE);
      $this->position= array(1, 1);
    }

    /**
     * Advance this 
     *
     * @return  bool
     */
    public function advance() {
      do {
        if (!$this->tokenizer->hasMoreTokens()) return FALSE;
        $token= $this->tokenizer->nextToken(self::DELIMITERS);

        // Ignore whitespace
        if (FALSE !== strpos(" \n\r\t", $token)) continue;

        if (FALSE !== strpos(self::DELIMITERS, $token) && 1 == strlen($token)) {
          $this->token= ord($token);
          $this->value= $token;
        } else if (1 == sscanf($token, '%s', $string)) {
          $this->token= xp搏de新ource搆arser感hp52Parser::T_STRING;
          $this->value= $token;
        } else if (1 == sscanf($token, '%d', $digits)) {
          $this->token= xp搏de新ource搆arser感hp52Parser::T_NUMBER;
          $this->value= $token;
        } else {
          throw new IllegalStateException('Unknown token "'.$token.'"');
        }

        break;
      } while (1);

      return TRUE;
    }
  }
?>
