<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('text.StringTokenizer', 'text.parser.generic.AbstractLexer');


  /**
   * FQL Lexer
   *
   * @see      xp://text.parser.generic.AbstractParser
   * @purpose  Abstract base class
   */
  class FQLLexer extends AbstractLexer {
    const DELIMITERS = " =<>()/'\"\r\n";

    protected static
      $keywords= array(
        'select'  => FQLParser::T_SELECT,
        'from'    => FQLParser::T_FROM,
        'where'   => FQLParser::T_WHERE,
        'and'     => FQLParser::T_AND,
        'or'      => FQLParser::T_OR,
        'like'    => FQLParser::T_LIKE,
        'ilike'   => FQLParser::T_ILIKE,
        'matches' => FQLParser::T_MATCHES
     );
      
    /**
     * Constructor
     *
     * @param   var input either a string or an InputStream
     * @param   string source
     */
    public function __construct($input, $source) {
      if ($input instanceof InputStream) {
        $this->tokenizer= new StreamTokenizer($input, self::DELIMITERS, TRUE);
      } else {
        $this->tokenizer= new StringTokenizer($input, self::DELIMITERS, TRUE);
      }
      $this->fileName= $source;
      $this->position= $this->forward= array(1, 1);   // Y, X
    }

    /**
     * Get next token and recalculate position
     *
     * @param   string delim default self::DELIMITERS
     * @return  string token
     */
    protected function nextToken($delim= self::DELIMITERS) {
      $t= $this->tokenizer->nextToken($delim);
      $l= substr_count($t, "\n");
      if ($l > 0) {
        $this->forward[0]+= $l;
        $this->forward[1]= strlen($t) - strrpos($t, "\n");
      } else {
        $this->forward[1]+= strlen($t);
      }
      return $t;
    }
  
    /**
     * Advance to next token. Return TRUE and set token, value and
     * position members to indicate we have more tokens, or FALSE
     * to indicate we've arrived at the end of the tokens.
     *
     * @return  bool
     */
    public function advance() {
      while ($hasMore= $this->tokenizer->hasMoreTokens()) {
        $this->position= $this->forward;
        $token= $this->nextToken();
        
        // Check for whitespace-only
        if (FALSE !== strpos(" \n\r\t", $token)) {
          continue;
        } else if ("'" === $token{0} || '"' === $token{0}) {
          $t= $token{0};
          $this->token= FQLParser::T_STRING;
          $this->value= $this->nextToken($t);
          $this->nextToken($t);
        } else if ('/' === $token{0}) {
          $this->token= FQLParser::T_REGEX;
          $this->value= $this->nextToken('/');
          $this->nextToken('/');
        } else if (isset(self::$keywords[$token])) {
          $this->token= self::$keywords[$token];
          $this->value= $token;
        } else if (FALSE !== strpos(self::DELIMITERS, $token) && 1 == strlen($token)) {
          $this->token= ord($token);
          $this->value= $token;
        } else if (preg_match('/^[0-9]+$/', $token)) {
          $this->token= FQLParser::T_NUMBER;
          $this->value= $token;
        } else {
          $this->token= FQLParser::T_WORD;
          $this->value= $token;
        }
        break;
      }

      return -1 === $this->token ? FALSE : $hasMore;
    }
  }
?>
