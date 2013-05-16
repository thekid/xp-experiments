<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$
 */

  uses('text.Tokenizer', 'peer.sieve.SieveParser', 'text.parser.generic.AbstractLexer');
  
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
        'require'       => SieveParser::T_REQUIRE,
        'if'            => SieveParser::T_IF,
        'else'          => SieveParser::T_ELSE,
        'elsif'         => SieveParser::T_ELSEIF,
        'allof'         => SieveParser::T_ALLOF,
        'anyof'         => SieveParser::T_ANYOF,
        'elsif'         => SieveParser::T_ELSEIF,
        'not'           => SieveParser::T_NOT,
        'header'        => SieveParser::T_HEADER,
        'size'          => SieveParser::T_SIZE,
        'address'       => SieveParser::T_ADDRESS,
        'true'          => SieveParser::T_TRUE,
        'false'         => SieveParser::T_FALSE,
        'comparator'    => SieveParser::T_COMPARATOR,
        'envelope'      => SieveParser::T_ENVELOPE,
        'is'            => SieveParser::T_IS,
        'exists'        => SieveParser::T_EXISTS,
        'contains'      => SieveParser::T_CONTAINS,
        'matches'       => SieveParser::T_MATCHES,
        'regex'         => SieveParser::T_REGEX,
        'count'         => SieveParser::T_COUNT,
        'value'         => SieveParser::T_VALUE,
        'all'           => SieveParser::T_ALL,
        'domain'        => SieveParser::T_DOMAIN,
        'localpart'     => SieveParser::T_LOCALPART,
        'user'          => SieveParser::T_USER,
        'detail'        => SieveParser::T_DETAIL,
      );

    const 
      DELIMITERS = " |&?!.:;,@%~=<>(){}[]#+-*/\"'\r\n\t";
          
    private
      $ahead = NULL;

    /**
     * Constructor
     *
     * @param   text.Tokenizer tokenizer
     * @param   string source
     */
    public function __construct(Tokenizer $tokenizer, $source) {
      $this->tokenizer= $tokenizer;
      $this->tokenizer->delimiters= self::DELIMITERS;
      $this->tokenizer->returnDelims= TRUE;
      $this->fileName= $source;
      $this->position= array(1, 1);   // Y, X
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
        $done= $this->tokenizer->hasMoreTokens();
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
          $this->token= SieveParser::T_STRING;
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
              if (!$this->tokenizer->hasMoreTokens()) {
                throw new IllegalStateException('Unclosed multi-line comment');
              }
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
            $this->token= SieveParser::T_WORD;
            $this->value= $token;
          } else {
            $this->token= SieveParser::T_STRING;
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
          $this->token= SieveParser::T_NUMBER;
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
          $this->token= SieveParser::T_NUMBER;
          $this->value= intval($n) * $quantifiers[$quantifier];
        } else {
          $this->token= SieveParser::T_WORD;
          $this->value= $token;
        }
        
        break;
      } while (1);
      
      // fprintf(STDERR, "@ %d,%d: %d `%s`\n", $this->position[0], $this->position[1], $this->token, $this->value);
      return $done;
    }
  }
?>
