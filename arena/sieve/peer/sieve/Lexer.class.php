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
        'else'          => TOKEN_T_ELSE,
        'elsif'         => TOKEN_T_ELSEIF,
        'allof'         => TOKEN_T_ALLOF,
        'anyof'         => TOKEN_T_ANYOF,
        'elsif'         => TOKEN_T_ELSEIF,
        'not'           => TOKEN_T_NOT,
        'header'        => TOKEN_T_HEADER,
        'size'          => TOKEN_T_SIZE,
        'address'       => TOKEN_T_ADDRESS,
        'true'          => TOKEN_T_TRUE,
        'false'         => TOKEN_T_FALSE,
        'comparator'    => TOKEN_T_COMPARATOR,
        'envelope'      => TOKEN_T_ENVELOPE,
        'is'            => TOKEN_T_IS,
        'exists'        => TOKEN_T_EXISTS,
        'contains'      => TOKEN_T_CONTAINS,
        'matches'       => TOKEN_T_MATCHES,
        'regex'         => TOKEN_T_REGEX,
        'count'         => TOKEN_T_COUNT,
        'value'         => TOKEN_T_VALUE,
        'all'           => TOKEN_T_ALL,
        'domain'        => TOKEN_T_DOMAIN,
        'localpart'     => TOKEN_T_LOCALPART,
        'user'          => TOKEN_T_USER,
        'detail'        => TOKEN_T_DETAIL,
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
      static $quantifiers= array(
        'K' => 1024,
        'M' => 1048576,
        'G' => 1073741824
      );

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
          $quantifier= strtoupper($token{strlen($token)- 1});
          if (!isset($quantifiers[$quantifier])) {
            throw new FormatException(sprintf(
              'Unknown quantifier "%s", expected one of %s',
              $quantifier,
              implode(', ', array_keys($quantifiers))
            ));
          } 
          $this->token= TOKEN_T_NUMBER;
          $this->value= intval($n) * $quantifiers[$quantifier];
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
