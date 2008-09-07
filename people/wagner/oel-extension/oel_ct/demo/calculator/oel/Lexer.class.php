<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$
 */

  $package= 'oel';

  uses('text.StringTokenizer', 'oel.Parser', 'text.parser.generic.AbstractLexer');

  /**
   * Lexer for mathematical expressions
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  class oel微exer extends AbstractLexer {

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
        } else if ($token === "euler") {
          $this->token= oel感arser::T_EULER;
          $this->value= M_EULER;
        } else if ($token === "pi") {
          $this->token= oel感arser::T_PI;
          $this->value= M_PI;
        } else if ($token === "e") {
          $this->token= oel感arser::T_E;
          $this->value= M_E;
        } else if (ctype_digit($token)) {
          $this->token= oel感arser::T_INTEGER;
          $this->value= intval($token);
        } else if (2 == sscanf($token, '%d.%d', $whole, $fraction)) {
          $this->token= oel感arser::T_DOUBLE;
          $this->value= doubleval($token);
        } else {
          throw new IllegalStateException('Unknown token "'.$token.'"');
        }

        break;
      } while (1);

      return TRUE;
    }
  }
?>
