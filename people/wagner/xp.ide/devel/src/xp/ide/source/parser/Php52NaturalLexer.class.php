<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$
 */

  $package= 'xp.ide.source.parser';

  uses(
    'text.StringTokenizer',
    'xp.ide.source.parser.Token',
    'xp.ide.source.parser.Php52Parser',
    'text.parser.generic.AbstractLexer'
  );

  /**
   * Lexer for mathematical expressions
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  class xp搏de新ource搆arser感hp52NaturalLexer extends AbstractLexer {

    private $tokens;

    /**
     * Constructor
     *
     * @param   string expression
     */
    public function __construct($expression) {
      $this->tokens= tokens_get_all($expression);
    }

    /**
     * Advance this 
     *
     * @return  bool
     */
    public function advance() {
      $this->position[1]+= is_null($this->value) ? 0 : strlen($this->value->getValue());
      $t= '';
      $this->value= new xp搏de新ource搆arser愁oken();
      $this->value->setLine($this->position[0]);
      $this->value->setColumn($this->position[1]);
      do {
        if (!$this->tokenizer->hasMoreTokens()) return FALSE;
        $token= $this->tokenizer->nextToken(self::DELIMITERS);

        switch ($this->state) {
          case self::S_ESTRING:
          if ($this->encaps == $token && "\\" != substr($t, -1)) {
            $this->token= xp搏de新ource搆arser感hp52Parser::T_ENCAPSE_STRING;
            $this->value->setValue($t);
            $this->state= self::S_INITIAL;
            break(2);
          } else {
            $t.= $token;
            continue(2);
          }

          // pass through comments
          case self::S_BCOMMENT:
          switch ($token) {
            case "\r":
            continue(3);

            case '*/':
            $this->token= xp搏de新ource搆arser感hp52Parser::T_CONTENT_BCOMMENT;
            $this->value->setValue($t);
            $this->tokenizer->pushBack($token);
            $this->state= self::S_INITIAL;
            break(3);

            default:
            $t.= $token;
            continue(3);
          }

          case self::S_INITIAL:
          // Ignore whitespace
          if (FALSE !== strpos(" \n\r\t", $token)) {
            if (PHP_EOL == $token || "\n" == $token && "\r\n" == PHP_OEL) {
              $this->position[0]++;
              $this->position[1]= 0;
            }
            $this->position[1]++;
            continue(2);
          } else if ($this->grep('"', $token, NULL)) {
            $this->encaps= '"';
            $this->state= self::S_ESTRING;
            $this->position[1]++;
            continue(2);
          } else if ($this->grep("'", $token, NULL)) {
            $this->encaps= "'";
            $this->state= self::S_ESTRING;
            $this->position[1]++;
            continue(2);
          } else if ($this->grep('/*', $token, xp搏de新ource搆arser感hp52Parser::T_OPEN_BCOMMENT)) {
            $this->state= self::S_BCOMMENT;
          } else if ($this->grep('*/', $token, xp搏de新ource搆arser感hp52Parser::T_CLOSE_BCOMMENT)) {
          } else if ($this->grep('NULL', $token, xp搏de新ource搆arser感hp52Parser::T_NULL)) {
          } else if ($this->grep('array', $token, xp搏de新ource搆arser感hp52Parser::T_ARRAY)) {
          } else if ($this->grep('private', $token, xp搏de新ource搆arser感hp52Parser::T_PRIVATE)) {
          } else if ($this->grep('static', $token, xp搏de新ource搆arser感hp52Parser::T_STATIC)) {
          } else if ($this->grep('protected', $token, xp搏de新ource搆arser感hp52Parser::T_PROTECTED)) {
          } else if ($this->grep('public', $token, xp搏de新ource搆arser感hp52Parser::T_PUBLIC)) {
          } else if ($this->grep('const', $token, xp搏de新ource搆arser感hp52Parser::T_CONST)) {
          } else if ($this->grep('<?php', $token, xp搏de新ource搆arser感hp52Parser::T_OPEN_TAG)) {
          } else if ($this->grep('?>', $token, xp搏de新ource搆arser感hp52Parser::T_CLOSE_TAG)) {
          } else if ($this->grep('uses', $token, xp搏de新ource搆arser感hp52Parser::T_USES)) {
          } else if ($this->grep('class', $token, xp搏de新ource搆arser感hp52Parser::T_CLASS)) {
          } else if ($this->grep('extends', $token, xp搏de新ource搆arser感hp52Parser::T_EXTENDS)) {
          } else if ($this->grep('implements', $token, xp搏de新ource搆arser感hp52Parser::T_IMPLEMENTS)) {
          } else if ($this->pgrep('/^(\$+[a-z][a-z0-9_-愍*)/i', $token, xp搏de新ource搆arser感hp52Parser::T_VARIABLE)) {
          } else if ($this->pgrep('/^([0-9]*.?[0-9]+)/i', $token, xp搏de新ource搆arser感hp52Parser::T_NUMBER)) {
          } else if ($this->pgrep('/^([a-z][a-z0-9_-愍*)/i', $token, xp搏de新ource搆arser感hp52Parser::T_STRING)) {
          } else {
            $this->token= ord($token);
            $this->value->setValue($token);
          }
          break(2);
        }
      } while (1);
      return TRUE;
    }

    private function grep($string, $test, $token) {
      if ($string == substr($test, 0, strlen($string))) {
        $this->token= $token;
        $this->value->setValue($string);
        if (strlen($test) > strlen($string)) $this->tokenizer->pushBack(substr($test, strlen($string)));
        return TRUE;
      }
      return FALSE;
    }

    private function pgrep($regex, $test, $token) {
      if (preg_match($regex, $test, $match)) {
        list($all, $string)= $match;
        $this->token= $token;
        $this->value->setValue($string);
        if (strlen($test) > strlen($string)) $this->tokenizer->pushBack(substr($test, strlen($string)));
        return TRUE;
      }
      return FALSE;
    }
  }
?>
