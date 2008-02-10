<?php
/* This class is part of the XP framework's experiments
 *
 * $Id: Lexer.class.php 10112 2008-02-02 03:51:06Z friebe $
 */

  uses(
    'text.StringTokenizer', 
    'text.parser.generic.AbstractLexer',
    'calc.ExpressionParser'
  );
  
  $package= 'calc';

  /**
   * Lexer for Sieve
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  class calc·Lexer extends AbstractLexer {
    protected static
      $keywords  = array(
      );

    const 
      DELIMITERS  = " |&?!.:;,@%~=<>(){}[]#+-*/\"'\r\n\t";
    
    private
      $ahead = NULL;

    /**
     * Constructor
     *
     * @param   string input
     * @param   string source
     */
    public function __construct($input, $source) {
      $this->tokenizer= new StringTokenizer($input."\0", self::DELIMITERS, TRUE);
      $this->fileName= $source;
      $this->position= array(1, 1);   // Y, X
    }

    /**
     * Create a new node 
     *
     * @param   xp.compiler.ast.Node
     * @return  xp.compiler.ast.Node
     */
    public function create($n) {
      $n->position= $this->position;
      return $n;
    }
  
    /**
     * Advance this 
     *
     * @return  bool
     */
    public function advance() {
      do {
        if ($this->ahead) {
          $token= $this->ahead;
          $this->ahead= NULL;
        } else {
          $token= $this->tokenizer->nextToken(self::DELIMITERS);
        }
        
        // Check for whitespace
        if (FALSE !== strpos(" \n\r\t", $token)) {
          $l= substr_count($token, "\n");
          $this->position[1]= strlen($token) + ($l ? 1 : $this->position[1]);
          $this->position[0]+= $l;
          continue;
        }
        
        $this->position[1]+= strlen($this->value);
        if ('"' === $token{0}) {
          $this->token= TOKEN_T_STRING;
          $this->value= '';
          do {
            if ($token{0} === ($t= $this->tokenizer->nextToken($token{0}))) {
              // Empty string, e.g. "" or ''
              break;
            }
            $this->value.= $t;
            if ('\\' === $this->value{strlen($this->value)- 1}) {
              $this->value= substr($this->value, 0, -1).$this->tokenizer->nextToken($token{0});
              continue;
            } 
            $this->tokenizer->nextToken($token{0});
            break;
          } while ($this->tokenizer->hasMoreTokens());
        } else if ('/' === $token{0}) {
          $ahead= $this->tokenizer->nextToken(self::DELIMITERS);
          if ('*' === $ahead) {    // Multi-line comment
            do { 
              $t= $this->tokenizer->nextToken('/'); 
              $l= substr_count($t, "\n");
              $this->position[1]= strlen($t) + ($l ? 1 : $this->position[1]);
              $this->position[0]+= $l;
            } while ('*' !== $t{strlen($t)- 1});
            $this->tokenizer->nextToken('/');
            continue;
          } else {
            $this->token= ord($token);
            $this->value= $token;
            $this->ahead= $ahead;
          } 
        } else if ('text' === $token) {
          $ahead= $this->tokenizer->nextToken(self::DELIMITERS);
          if (':' !== $ahead{0}) {
            $this->token= TOKEN_T_WORD;
            $this->value= $token;
          } else {
            $this->token= TOKEN_T_STRING;
            $this->value= ltrim(substr($ahead, 1), "\r\n\t ");
            do {
              $this->value.= $this->tokenizer->nextToken('.');
              if ("\n" !== $this->value{strlen($this->value)- 1}) {
                continue;
              }
              $this->tokenizer->nextToken('.');
              break;
            } while ($this->tokenizer->hasMoreTokens());
          }
        } else if (isset(self::$keywords[$token])) {
          $this->token= self::$keywords[$token];
          $this->value= $token;
        } else if ('#' === $token{0}) {
          $this->tokenizer->nextToken("\n");
          $this->position[1]= 1;
          $this->position[0]++;
          continue;
        } else if (FALSE !== strpos(self::DELIMITERS, $token) && 1 == strlen($token)) {
          $this->token= ord($token);
          $this->value= $token;
        } else if (ctype_digit($token)) {
          $this->token= TOKEN_T_NUMBER;
          $this->value= $token;
        } else if (ctype_digit($n= substr($token, 0, -1))) {
          $this->token= TOKEN_T_NUMBER;
          $this->value= intval($n);
        } else {
          $this->token= TOKEN_T_WORD;
          $this->value= $token;
        }
        
        break;
      } while (1);
      
      // fprintf(STDERR, "@ %d,%d: %d `%s`\n", $this->position[0], $this->position[1], $this->token, $this->value);
      return $this->tokenizer->hasMoreTokens();
    }
  }
?>
