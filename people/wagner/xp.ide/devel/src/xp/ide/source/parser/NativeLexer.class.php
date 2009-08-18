<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$
 */

  $package= 'xp.ide.source.parser';

  uses(
    'xp.ide.source.parser.Token',
    'xp.ide.source.parser.Php52Parser',
    'text.parser.generic.AbstractLexer'
  );

  /**
   * Lexer for php language
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  class xp搏de新ource搆arser意ativeLexer extends AbstractLexer {
    const
      S_CLASS= 1,
      S_COMMENT= 2,
      S_INNERBLOCK= 3;

    public
      $token    = NULL,
      $value    = NULL,
      $position = array();

    private
      $tokens,
      $state= self::S_CLASS;

    private static $trans= array(
      T_OPEN_TAG => xp搏de新ource搆arser感hp52Parser::T_OPEN_TAG,
      T_CLOSE_TAG => xp搏de新ource搆arser感hp52Parser::T_CLOSE_TAG,
      T_CLASS    => xp搏de新ource搆arser感hp52Parser::T_CLASS,
      T_STRING   => xp搏de新ource搆arser感hp52Parser::T_STRING,
      T_EXTENDS  => xp搏de新ource搆arser感hp52Parser::T_EXTENDS,
      T_IMPLEMENTS => xp搏de新ource搆arser感hp52Parser::T_IMPLEMENTS,
      T_CONSTANT_ENCAPSED_STRING => xp搏de新ource搆arser感hp52Parser::T_ENCAPSED_STRING,
      T_VARIABLE => xp搏de新ource搆arser感hp52Parser::T_VARIABLE,
      T_PRIVATE => xp搏de新ource搆arser感hp52Parser::T_PRIVATE,
      T_PROTECTED => xp搏de新ource搆arser感hp52Parser::T_PROTECTED,
      T_PUBLIC => xp搏de新ource搆arser感hp52Parser::T_PUBLIC,
      T_STATIC => xp搏de新ource搆arser感hp52Parser::T_STATIC,
      T_CONST => xp搏de新ource搆arser感hp52Parser::T_CONST,
      T_LNUMBER => xp搏de新ource搆arser感hp52Parser::T_NUMBER,
    );

    /**
     * Constructor
     *
     * @param   string expression
     */
    public function __construct($expression) {
      $this->tokens= token_get_all($expression);
    }

    /**
     * Advance this 
     *
     * @return  bool
     */
    public function advance() {
      $op_cnt= 0;
      $c= '';
      while (1) {
        $t= array_shift($this->tokens);
        if ('' === $t) continue;
        if (NULL === $t) return FALSE;

        switch ($this->state) {
          case self::S_INNERBLOCK:
          if ('{' === $t) $op_cnt++;
          if ('}' === $t) $op_cnt--;
          if ('}' === $t && 0 > $opt_cnt) {
            $this->state= self::S_CLASS;
            $this->tokenFrom(array(xp搏de新ource搆arser感hp52Parser::T_CONTENT_INNERBLOCK, $c, 0));
            array_unshift($t5his->tokens, $t);
            break(2);
          }
          $c.= is_string($t) ? $t : $t[1];
          continue(2);

          case self::S_COMMENT:
          if (xp搏de新ource搆arser感hp52Parser::T_CLOSE_BCOMMENT == $t[0]) $this->state= self::S_CLASS;
          $this->tokenFrom($t);
          break(2);

          case self::S_CLASS:
          if (is_string($t)) {
            switch ($t) {
              case '{':
              $this->tokenFrom(array(xp搏de新ource搆arser感hp52Parser::T_OPEN_INNERBLOCK, $t, 0));
              $this->state= self::S_INNERBLOCK;
              break(3);

              case '}':
              $this->tokenFrom(array(xp搏de新ource搆arser感hp52Parser::T_CLOSE_INNERBLOCK, $t, 0));
              break(3);

              default;
              $this->token= ord($t);
              $this->value= $t;
              break(3);
            }
          }
          switch ($t[0]) {
            case T_WHITESPACE:
            case T_INLINE_HTML:
            continue (3);

            case T_DOC_COMMENT:
            case T_COMMENT:
            array_unshift($this->tokens,
              array(
                xp搏de新ource搆arser感hp52Parser::T_OPEN_BCOMMENT,
                substr($t[1], 0, 2),
                $t[2]
              ),
              array(
                xp搏de新ource搆arser感hp52Parser::T_CONTENT_BCOMMENT,
                substr($t[1], 2, -2),
                $t[2]
              ),
              array(
                xp搏de新ource搆arser感hp52Parser::T_CLOSE_BCOMMENT,
                substr($t[1], -2),
                $t[2]
              )
            );
            $this->state= self::S_COMMENT;
            continue(3);

            case T_STRING:
            switch ($t[1]) {
              case 'uses':
              $t[0]= xp搏de新ource搆arser感hp52Parser::T_USES;
              $this->tokenFrom($t);
              break(3);
            }

            default: $t= $this->translate($t);
          }
          $this->tokenFrom($t);
          break(2);
        }
      }
      return TRUE;
    }

    private function translate($t) {
      $t[0]= self::$trans[$t[0]];
      return $t;
    }

    private function tokenFrom($t) {
      $this->value= new xp搏de新ource搆arser愁oken();
      $this->token= $t[0];
      $this->value->setValue($t[1]);
      $this->value->setLine($t[2]);
      $this->value->setColumn(0);
      $this->position= array($t[2], 0);
    }

  }
?>
