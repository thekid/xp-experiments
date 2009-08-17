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
    public
      $token    = NULL,
      $value    = NULL,
      $position = array();

    private $tokens;
    private static $trans;

    function __static() {
      self::$trans= array(
        T_OPEN_TAG => xp搏de新ource搆arser感hp52Parser::T_OPEN_TAG,
      );
    }

    /**
     * Constructor
     *
     * @param   string expression
     */
    public function __construct($expression) {
      $this->tokens= array_filter(
        token_get_all($expression),
        create_function('$e', 'return !in_array($e[0], array(
          T_WHITESPACE,
          T_INLINE_HTML
        ));')
      );
    }

    /**
     * Advance this 
     *
     * @return  bool
     */
    public function advance() {
      $t= '';
      while ('' == $t) $t= array_shift($this->tokens);
      if (NULL === $t) return FALSE;

      switch ($t[0]) {
        case T_DOC_COMMENT:
        $this->token= xp搏de新ource搆arser感hp52Parser::T_OPEN_BCOMMENT;
        
        break;

        default: $this->token= $this->translate($t);
      }
      $this->value= new xp搏de新ource搆arser愁oken();
      $this->value->setValue($t[1]);
      $this->value->setLine($t[2]);
      $this->value->setColumn(0);
      $this->position= array($t[2], 0);
var_dump($t, token_name($t[0]));
      return TRUE;
    }

    private function translate($t) {
      return self::$trans[$t[0]];
    }

  }
?>
