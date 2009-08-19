<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$
 */

  $package= 'xp.ide.source.parser';

  uses(
    'xp.ide.source.parser.ClassFileParser',
    'xp.ide.source.parser.Lexer'
  );

  /**
   * Lexer for php language
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  class xp·ide·source·parser·ClassFileLexer extends xp·ide·source·parser·Lexer {
    const
      S_CLASS= 1,
      S_COMMENT= 2,
      S_INNERBLOCK= 3;

    private
      $state= self::S_CLASS,
      $tokens;

    public
      $token    = NULL,
      $value    = NULL,
      $position = array();

    /**
     * Constructor
     *
     * @param   string expression
     */
    public function __construct($expression) {
      $this->tokens= token_get_all($expression);
    }

    private static $trans= array(
      T_OPEN_TAG => xp·ide·source·parser·ClassFileParser::T_OPEN_TAG,
      T_CLOSE_TAG => xp·ide·source·parser·ClassFileParser::T_CLOSE_TAG,
      T_CLASS    => xp·ide·source·parser·ClassFileParser::T_CLASS,
      T_STRING   => xp·ide·source·parser·ClassFileParser::T_STRING,
      T_EXTENDS  => xp·ide·source·parser·ClassFileParser::T_EXTENDS,
      T_IMPLEMENTS => xp·ide·source·parser·ClassFileParser::T_IMPLEMENTS,
      T_CONSTANT_ENCAPSED_STRING => xp·ide·source·parser·ClassFileParser::T_ENCAPSED_STRING,
      T_VARIABLE => xp·ide·source·parser·ClassFileParser::T_VARIABLE,
    );

    private function translate($t) {
      $t[0]= self::$trans[$t[0]];
      return $t;
    }

    protected function tokenFrom($t) {
      parent::tokenFrom(array_shift($t), array_shift($t), array_shift($t), array_shift($t));
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
          if ('}' === $t && 0 > $op_cnt) {
            $this->state= self::S_CLASS;
            $this->tokenFrom(array(xp·ide·source·parser·ClassFileParser::T_CONTENT_INNERBLOCK, $c, 0));
            array_unshift($this->tokens, $t);
            break(2);
          }
          $c.= is_string($t) ? $t : $t[1];
          continue(2);

          case self::S_COMMENT:
          if (xp·ide·source·parser·ClassFileParser::T_CLOSE_BCOMMENT == $t[0]) $this->state= self::S_CLASS;
          $this->tokenFrom($t);
          break(2);

          case self::S_CLASS:
          if (is_string($t)) {
            switch ($t) {
              case '{':
              $this->tokenFrom(array(xp·ide·source·parser·ClassFileParser::T_OPEN_INNERBLOCK, $t, 0));
              $this->state= self::S_INNERBLOCK;
              break(3);

              case '}':
              $this->tokenFrom(array(xp·ide·source·parser·ClassFileParser::T_CLOSE_INNERBLOCK, $t, 0));
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
                xp·ide·source·parser·ClassFileParser::T_OPEN_BCOMMENT,
                substr($t[1], 0, 2),
                $t[2]
              ),
              array(
                xp·ide·source·parser·ClassFileParser::T_CONTENT_BCOMMENT,
                substr($t[1], 2, -2),
                $t[2]
              ),
              array(
                xp·ide·source·parser·ClassFileParser::T_CLOSE_BCOMMENT,
                substr($t[1], -2),
                $t[2]
              )
            );
            $this->state= self::S_COMMENT;
            continue(3);

            case T_STRING:
            switch ($t[1]) {
              case 'uses':
              $t[0]= xp·ide·source·parser·ClassFileParser::T_USES;
              $this->tokenFrom($t);
              break(4);
            }

            default: $t= $this->translate($t);
          }
          $this->tokenFrom($t);
          break(2);
        }
      }
      return TRUE;
    }

  }
?>
