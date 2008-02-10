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
      DELIMITERS  = " |&?!:;,@%~=<>(){}[]#+-*/\"'\r\n\t";
    
    private
      $ahead = NULL;

    /**
     * Constructor
     *
     * @param   string input
     * @param   string source
     */
    public function __construct($input, $source) {
      $this->tokenizer= new StringTokenizer($input." \0", self::DELIMITERS, TRUE);
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
        if (isset(self::$keywords[$token])) {
          $this->token= self::$keywords[$token];
          $this->value= $token;
        } else if (FALSE !== strpos(self::DELIMITERS, $token) && 1 == strlen($token)) {
          $this->token= ord($token);
          $this->value= $token;
        } else if (is_numeric($token)) {
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
