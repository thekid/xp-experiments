<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$
 */

  $package= 'math';

  uses('text.StringTokenizer', 'math.Parser', 'text.parser.generic.AbstractLexer');

  /**
   * Lexer for mathematical expressions
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  class math微exer extends AbstractLexer {
    const DELIMITERS= " +-*:/,^%眾!()\r\n\t";
    protected $tokenizer= NULL;
          
    /**
     * Constructor
     *
     * @param   string expression
     */
    public function __construct($expression) {
      $this->tokenizer= new StringTokenizer($expression, self::DELIMITERS, TRUE);
      $this->fileName= $expression;
      $this->position= array(1, 1);   // Y, X
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
        
        // Check for whitespace
        if (FALSE !== strpos(" \n\r\t", $token)) {
          $l= substr_count($token, "\n");
          $this->position[1]= strlen($token) + ($l ? 1 : $this->position[1]);
          $this->position[0]+= $l;
          continue;
        }
        
        $this->position[1]+= strlen($this->value);
        
        if (FALSE !== strpos(self::DELIMITERS, $token) && 1 == strlen($token)) {
          $this->token= ord($token);
          $this->value= $token;
        } else if (ctype_digit($token)) {
          $this->token= math感arser::T_INTEGER;
          $this->value= intval($token);
        } else if (2 == sscanf($token, '%d.%d', $whole, $fraction)) {
          $this->token= math感arser::T_DOUBLE;
          $this->value= doubleval($token);
        } else {
          $this->token= math感arser::T_WORD;
          $this->value= $token;
        }
        
        break;
      } while (1);

      return TRUE;
    }
  }
?>
