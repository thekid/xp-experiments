<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$
 */

  uses('text.StringTokenizer', 'text.parser.generic.AbstractLexer');
  
  $package= 'peer.sieve';

  /**
   * Lexer for Sieve
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  class peer·sieve·Lexer extends AbstractLexer {
    protected static
      $keywords  = array(
        'require'       => TOKEN_T_REQUIRE,
        'if'            => TOKEN_T_IF,
        'elsif'         => TOKEN_T_ELSEIF,
        'allof'         => TOKEN_T_ALLOF,
        'elsif'         => TOKEN_T_ELSEIF,
      );

    protected static
      $lookahead= array(
      );

    const 
      DELIMITERS = " |&?!.:;,@%~=<>(){}[]#+-*/\"'\r\n\t";
    
          
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
        } else if ('$' === $token{0}) {
          $this->token= TOKEN_T_VARIABLE;
          $this->value= $token;
        } else if (isset(self::$keywords[$token])) {
          $this->token= self::$keywords[$token];
          $this->value= $token;
        } else if ('#' === $token{0}) {
          $this->tokenizer->nextToken("\n");
          $this->position[1]= 1;
          $this->position[0]++;
          continue;
        } else if (isset(self::$lookahead[$token])) {
          $ahead= $this->tokenizer->nextToken(self::DELIMITERS);
          $combined= $token.$ahead;
          if (isset(self::$lookahead[$token][$combined])) {
            $this->token= self::$lookahead[$token][$combined];
            $this->value= $combined;
          } else {
            $this->token= ord($token);
            $this->value= $token;
            $this->ahead= $ahead;
          }
        } else if (FALSE !== strpos(self::DELIMITERS, $token) && 1 == strlen($token)) {
          $this->token= ord($token);
          $this->value= $token;
        } else if (ctype_digit($token)) {
          $ahead= $this->tokenizer->nextToken(self::DELIMITERS);
          if ('.' === $ahead{0}) {
            $decimal= $this->tokenizer->nextToken(self::DELIMITERS);
            if (!ctype_digit($decimal)) {
              throw new FormatException('Illegal decimal number "'.$token.$ahead.$decimal.'"');
            }
            $this->token= TOKEN_T_DECIMAL;
            $this->value= $token.$ahead.$decimal;
          } else {
            $this->token= TOKEN_T_NUMBER;
            $this->value= $token;
            $this->ahead= $ahead;
          }
        } else if ('0' === $token{0} && 'x' === @$token{1}) {
          if (!ctype_xdigit(substr($token, 2))) {
            throw new FormatException('Illegal hex number "'.$token.'"');
          }
          $this->token= TOKEN_T_NUMBER;
          $this->value= $token;
        } else {
          $this->token= TOKEN_T_WORD;
          $this->value= $token;
        }
        
        break;
      } while (1);
      
      fprintf(STDERR, "@ %d,%d: %d `%s`\n", $this->position[0], $this->position[1], $this->token, $this->value);
      return $this->tokenizer->hasMoreTokens();
    }
  }
?>
