<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$ 
 */

  uses(
    'text.Tokenizer', 
    'text.StringTokenizer', 
    'text.StreamTokenizer', 
    'io.streams.InputStream',
    'xp.compiler.Parser', 
    'text.parser.generic.AbstractLexer'
  );
  
  $package= 'xp.compiler';

  /**
   * Lexer for XP language
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  class xp�compiler�Lexer extends AbstractLexer {
    protected static
      $keywords  = array(
        'public'        => Parser::T_PUBLIC,
        'private'       => Parser::T_PRIVATE,
        'protected'     => Parser::T_PROTECTED,
        'static'        => Parser::T_STATIC,
        'final'         => Parser::T_FINAL,
        'abstract'      => Parser::T_ABSTRACT,
        'inline'        => Parser::T_INLINE,
        'native'        => Parser::T_NATIVE,
        
        'package'       => Parser::T_PACKAGE,
        'import'        => Parser::T_IMPORT,
        'class'         => Parser::T_CLASS,
        'interface'     => Parser::T_INTERFACE,
        'enum'          => Parser::T_ENUM,
        'extends'       => Parser::T_EXTENDS,
        'implements'    => Parser::T_IMPLEMENTS,
        'instanceof'    => Parser::T_INSTANCEOF,

        'operator'      => Parser::T_OPERATOR,
        'throws'        => Parser::T_THROWS,

        'throw'         => Parser::T_THROW,
        'try'           => Parser::T_TRY,
        'catch'         => Parser::T_CATCH,
        'finally'       => Parser::T_FINALLY,
        
        'return'        => Parser::T_RETURN,
        'new'           => Parser::T_NEW,
        
        'for'           => Parser::T_FOR,
        'foreach'       => Parser::T_FOREACH,
        'in'            => Parser::T_IN,
        'do'            => Parser::T_DO,
        'while'         => Parser::T_WHILE,
        'break'         => Parser::T_BREAK,
        'continue'      => Parser::T_CONTINUE,

        'if'            => Parser::T_IF,
        'else'          => Parser::T_ELSE,
        'switch'        => Parser::T_SWITCH,
        'case'          => Parser::T_CASE,
        'default'       => Parser::T_DEFAULT,
      );

    protected static
      $lookahead= array(
        '.' => array('..' => Parser::T_DOTS),
        '-' => array('-=' => Parser::T_SUB_EQUAL, '--' => Parser::T_DEC),
        '>' => array('>=' => Parser::T_GE),
        '<' => array('<=' => Parser::T_SE),
        '~' => array('~=' => Parser::T_CONCAT_EQUAL),
        '+' => array('+=' => Parser::T_ADD_EQUAL, '++' => Parser::T_INC),
        '*' => array('*=' => Parser::T_MUL_EQUAL),
        '/' => array('/=' => Parser::T_DIV_EQUAL),
        '%' => array('%=' => Parser::T_MOD_EQUAL),
        '=' => array('==' => Parser::T_EQUALS, '=>' => Parser::T_DOUBLE_ARROW),
        '!' => array('!=' => Parser::T_NOT_EQUALS),
        ':' => array('::' => Parser::T_DOUBLE_COLON),
        '|' => array('||' => Parser::T_BOOLEAN_OR),
        '&' => array('&&' => Parser::T_BOOLEAN_AND),
      );

    const 
      DELIMITERS = " |&?!.:;,@%~=<>(){}[]#+-*/\"'\r\n\t";
    
          
    private
      $ahead   = NULL,
      $comment = NULL;

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
      if ($this->comment) $n->comment= $this->comment;
      return $n;
    }
  
    /**
     * Advance this 
     *
     * @return  bool
     */
    public function advance() {
      do {
        $hasMore= $this->tokenizer->hasMoreTokens();
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
        if ("'" === $token{0} || '"' === $token{0}) {
          $this->token= Parser::T_STRING;
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
          $this->token= Parser::T_VARIABLE;
          $this->value= $token;
        } else if (isset(self::$keywords[$token])) {
          $this->token= self::$keywords[$token];
          $this->value= $token;
        } else if ('/' === $token{0}) {
          $ahead= $this->tokenizer->nextToken(self::DELIMITERS);
          if ('/' === $ahead) {           // Single-line comment
            $this->tokenizer->nextToken("\n");
            $this->position[1]= 1;
            $this->position[0]++;
            continue;
          } else if ('*' === $ahead) {    // Multi-line comment
            $this->comment= '';
            do { 
              $t= $this->tokenizer->nextToken('/'); 
              $l= substr_count($t, "\n");
              $this->position[1]= strlen($t) + ($l ? 1 : $this->position[1]);
              $this->position[0]+= $l;
              $this->comment.= $t;
            } while ('*' !== $t{strlen($t)- 1});
            $this->tokenizer->nextToken('/');
            continue;
          } else {
            $this->token= ord($token);
            $this->value= $token;
            $this->ahead= $ahead;
          }
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
            $this->token= Parser::T_DECIMAL;
            $this->value= $token.$ahead.$decimal;
          } else {
            $this->token= Parser::T_NUMBER;
            $this->value= $token;
            $this->ahead= $ahead;
          }
        } else if ('0' === $token{0} && 'x' === @$token{1}) {
          if (!ctype_xdigit(substr($token, 2))) {
            throw new FormatException('Illegal hex number "'.$token.'"');
          }
          $this->token= Parser::T_NUMBER;
          $this->value= $token;
        } else {
          $this->token= Parser::T_WORD;
          $this->value= $token;
        }
        
        break;
      } while (1);
      
      // fprintf(STDERR, "@ %d,%d: %d `%s`\n", $this->position[0], $this->position[1], $this->token, $this->value);
      return $hasMore;
    }
  }
?>
