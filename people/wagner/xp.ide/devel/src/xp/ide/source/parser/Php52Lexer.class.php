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

    const DELIMITERS= " \r\n\t@";
    const S_SOURCE= 0;
    const S_BCOMMENT= 1;

    protected $tokenizer= NULL;
    private $state= self::S_SOURCE;

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

        // pass through comments
        if (self::S_BCOMMENT == $this->state) {
          $this->token= xp搏de新ource搆arser感hp52Parser::T_CONTENT_BCOMMENT;
          $this->value= '';
          while ('*/' != substr($token, 0, 2)) {
            if ("\r" != $token) $this->value.= $token;
            if (!$this->tokenizer->hasMoreTokens()) return FALSE;
            $token= $this->tokenizer->nextToken(self::DELIMITERS);
          }
          $this->tokenizer->pushBack($token);
          $this->state= self::S_SOURCE;
          return TRUE;
        }
        // Ignore whitespace

        if (FALSE !== strpos(" \n\r\t", $token)) continue;
        if ('<?php' == substr($token, 0, 5)) {
          $this->token= xp搏de新ource搆arser感hp52Parser::T_OPEN_TAG;
          $this->value= "<?php";
          $this->tokenizer->pushBack(substr($token, 5));
        } else if ('?>' == substr($token, 0, 2)) {
          $this->token= xp搏de新ource搆arser感hp52Parser::T_CLOSE_TAG;
          $this->value= "?>";
          $this->tokenizer->pushBack(substr($token, 2));
        } else if ('/*' == substr($token, 0, 2)) {
          $this->token= xp搏de新ource搆arser感hp52Parser::T_OPEN_BCOMMENT;
          $this->value= "/*";
          $this->tokenizer->pushBack(substr($token, 2));
          $this->state= self::S_BCOMMENT;
        } else if ('*/' == substr($token, 0, 2)) {
          $this->token= xp搏de新ource搆arser感hp52Parser::T_CLOSE_BCOMMENT;
          $this->value= "*/";
          $this->tokenizer->pushBack(substr($token, 2));
        } else if (preg_match('/[a-z][a-z0-9_-]*/i', $token)) {
          $this->token= xp搏de新ource搆arser感hp52Parser::T_STRING;
          $this->value= $token;
        } else if (1 == sscanf($token, '%d', $digits)) {
          $this->token= xp搏de新ource搆arser感hp52Parser::T_NUMBER;
          $this->value= $token;
        } else {
          $this->token= ord($token);
          $this->value= $token;
        }
        break;
      } while (1);
      return TRUE;
    }
  }
?>
