<?php
 /* This class is part of the XP framework
  *
  * $Id$
  */
  $package= 'xp.ide.source.parser';
  uses(
    'xp.ide.source.parser.Lexer',
    'xp.ide.source.parser.ClassParser'
  );
  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class xp穒de穝ource穚arser稢lassLexer extends xp穒de穝ource穚arser稬exer  {
  const YY_BUFFER_SIZE = 512;
  const YY_F = -1;
  const YY_NO_STATE = -1;
  const YY_NOT_ACCEPT = 0;
  const YY_START = 1;
  const YY_END = 2;
  const YY_NO_ANCHOR = 4;
  const YY_BOL = 128;
  var $YY_EOF = 129;
  protected $yy_count_chars = true;
  protected $yy_count_lines = true;

  function __construct($stream) {
    parent::__construct($stream);
    $this->yy_lexical_state = self::YYINITIAL;
  }

  const YYINITIAL = 0;
  const COMMENT = 2;
  const ENCAPSED = 1;
  static $yy_state_dtrans = array(
    0,
    53,
    55
  );
  static $yy_acpt = array(
    /* 0 */ self::YY_NOT_ACCEPT,
    /* 1 */ self::YY_NO_ANCHOR,
    /* 2 */ self::YY_NO_ANCHOR,
    /* 3 */ self::YY_NO_ANCHOR,
    /* 4 */ self::YY_NO_ANCHOR,
    /* 5 */ self::YY_NO_ANCHOR,
    /* 6 */ self::YY_NO_ANCHOR,
    /* 7 */ self::YY_NO_ANCHOR,
    /* 8 */ self::YY_NO_ANCHOR,
    /* 9 */ self::YY_NO_ANCHOR,
    /* 10 */ self::YY_NO_ANCHOR,
    /* 11 */ self::YY_NO_ANCHOR,
    /* 12 */ self::YY_NO_ANCHOR,
    /* 13 */ self::YY_NO_ANCHOR,
    /* 14 */ self::YY_NO_ANCHOR,
    /* 15 */ self::YY_NO_ANCHOR,
    /* 16 */ self::YY_NO_ANCHOR,
    /* 17 */ self::YY_NOT_ACCEPT,
    /* 18 */ self::YY_NO_ANCHOR,
    /* 19 */ self::YY_NOT_ACCEPT,
    /* 20 */ self::YY_NOT_ACCEPT,
    /* 21 */ self::YY_NOT_ACCEPT,
    /* 22 */ self::YY_NOT_ACCEPT,
    /* 23 */ self::YY_NOT_ACCEPT,
    /* 24 */ self::YY_NOT_ACCEPT,
    /* 25 */ self::YY_NOT_ACCEPT,
    /* 26 */ self::YY_NOT_ACCEPT,
    /* 27 */ self::YY_NOT_ACCEPT,
    /* 28 */ self::YY_NOT_ACCEPT,
    /* 29 */ self::YY_NOT_ACCEPT,
    /* 30 */ self::YY_NOT_ACCEPT,
    /* 31 */ self::YY_NOT_ACCEPT,
    /* 32 */ self::YY_NOT_ACCEPT,
    /* 33 */ self::YY_NOT_ACCEPT,
    /* 34 */ self::YY_NOT_ACCEPT,
    /* 35 */ self::YY_NOT_ACCEPT,
    /* 36 */ self::YY_NOT_ACCEPT,
    /* 37 */ self::YY_NOT_ACCEPT,
    /* 38 */ self::YY_NOT_ACCEPT,
    /* 39 */ self::YY_NOT_ACCEPT,
    /* 40 */ self::YY_NOT_ACCEPT,
    /* 41 */ self::YY_NOT_ACCEPT,
    /* 42 */ self::YY_NOT_ACCEPT,
    /* 43 */ self::YY_NOT_ACCEPT,
    /* 44 */ self::YY_NOT_ACCEPT,
    /* 45 */ self::YY_NOT_ACCEPT,
    /* 46 */ self::YY_NOT_ACCEPT,
    /* 47 */ self::YY_NOT_ACCEPT,
    /* 48 */ self::YY_NOT_ACCEPT,
    /* 49 */ self::YY_NOT_ACCEPT,
    /* 50 */ self::YY_NOT_ACCEPT,
    /* 51 */ self::YY_NOT_ACCEPT,
    /* 52 */ self::YY_NOT_ACCEPT,
    /* 53 */ self::YY_NOT_ACCEPT,
    /* 54 */ self::YY_NOT_ACCEPT,
    /* 55 */ self::YY_NOT_ACCEPT,
    /* 56 */ self::YY_NOT_ACCEPT,
    /* 57 */ self::YY_NOT_ACCEPT,
    /* 58 */ self::YY_NOT_ACCEPT,
    /* 59 */ self::YY_NOT_ACCEPT,
    /* 60 */ self::YY_NOT_ACCEPT,
    /* 61 */ self::YY_NOT_ACCEPT,
    /* 62 */ self::YY_NOT_ACCEPT,
    /* 63 */ self::YY_NOT_ACCEPT,
    /* 64 */ self::YY_NOT_ACCEPT,
    /* 65 */ self::YY_NOT_ACCEPT,
    /* 66 */ self::YY_NOT_ACCEPT,
    /* 67 */ self::YY_NOT_ACCEPT,
    /* 68 */ self::YY_NOT_ACCEPT
  );
    static $yy_cmap = array(
 21, 21, 21, 21, 21, 21, 21, 21, 21, 20, 20, 21, 20, 20, 21, 21, 21, 21, 21, 21,
 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 20, 21, 21, 21, 21, 21, 21, 1,
 21, 21, 21, 21, 21, 21, 21, 21, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 21, 21,
 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21,
 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 22, 21, 21, 21, 21, 11, 15, 2,
 13, 12, 18, 21, 21, 9, 21, 21, 16, 21, 4, 3, 7, 21, 8, 5, 6, 14, 10, 21,
 21, 17, 21, 21, 21, 21, 21, 21, 0, 0,);

    static $yy_rmap = array(
 0, 1, 2, 1, 3, 4, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 5, 6, 7,
 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27,
 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47,
 48, 49, 50, 51, 52, 53, 54, 55, 56,);

    static $yy_nxt = array(
array(
 1, 2, 3, 3, 3, 3, 3, 18, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4,
 5, 3, 3,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, 17, -1, 19, 20, 21, 22, -1, -1, -1, 56, -1, -1, -1, -1, -1, -1, 23, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 5, -1, -1,
),
array(
 -1, -1, -1, 25, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, 24, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 26, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 57, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, 27, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, 28, -1, -1, -1, -1, -1, 29, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 58, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, 31, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, 32, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 64, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 34, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, 60, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 67, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, 35, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 61, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, 65, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 37, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 38, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 40, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, 6, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, 43, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, 7, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 63, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 44, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 46, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, 8, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, 47, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, 9, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, 10, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 11, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, 12, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 50, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, 13, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 51, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 52, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, 14, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 1, 15, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, 54,
),
array(
 -1, 16, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, 30, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 33, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 59, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, 62, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 39, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 41, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 45, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, 48, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 36, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 42, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, 49, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 68, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, 66, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
);

  protected function yylex() {
    $yy_anchor = self::YY_NO_ANCHOR;
    $yy_state = self::$yy_state_dtrans[$this->yy_lexical_state];
    $yy_next_state = self::YY_NO_STATE;
    $yy_last_accept_state = self::YY_NO_STATE;
    $yy_initial = true;

    $this->yy_mark_start();
    $yy_this_accept = self::$yy_acpt[$yy_state];
    if (self::YY_NOT_ACCEPT != $yy_this_accept) {
      $yy_last_accept_state = $yy_state;
      $this->yy_mark_end();
    }
    while (true) {
      if ($yy_initial && $this->yy_at_bol) $yy_lookahead = self::YY_BOL;
      else $yy_lookahead = $this->yy_advance();
      $yy_next_state = self::$yy_nxt[self::$yy_rmap[$yy_state]][self::$yy_cmap[$yy_lookahead]];
      if ($this->YY_EOF == $yy_lookahead && true == $yy_initial) {
        return null;
      }
      if (self::YY_F != $yy_next_state) {
        $yy_state = $yy_next_state;
        $yy_initial = false;
        $yy_this_accept = self::$yy_acpt[$yy_state];
        if (self::YY_NOT_ACCEPT != $yy_this_accept) {
          $yy_last_accept_state = $yy_state;
          $this->yy_mark_end();
        }
      }
      else {
        if (self::YY_NO_STATE == $yy_last_accept_state) {
          throw new Exception("Lexical Error: Unmatched Input.");
        }
        else {
          $yy_anchor = self::$yy_acpt[$yy_last_accept_state];
          if (0 != (self::YY_END & $yy_anchor)) {
            $this->yy_move_end();
          }
          $this->yy_to_mark();
          switch ($yy_last_accept_state) {
            case 1:
              
            case -2:
              break;
            case 2:
              { $this->yybegin(self::ENCAPSED); }
            case -3:
              break;
            case 3:
              { return ord($this->yytext()); }
            case -4:
              break;
            case 4:
              { return xp路ide路source路parser路ClassParser::T_NUMBER; }
            case -5:
              break;
            case 5:
              { }
            case -6:
              break;
            case 6:
              { return xp路ide路source路parser路ClassParser::T_NULL; }
            case -7:
              break;
            case 7:
              { return xp路ide路source路parser路ClassParser::T_BOOLEAN; }
            case -8:
              break;
            case 8:
              { return xp路ide路source路parser路ClassParser::T_CONST; }
            case -9:
              break;
            case 9:
              { return xp路ide路source路parser路ClassParser::T_ARRAY; }
            case -10:
              break;
            case 10:
              { return xp路ide路source路parser路ClassParser::T_BOOLEAN; }
            case -11:
              break;
            case 11:
              { return xp路ide路source路parser路ClassParser::T_PRIVATE; }
            case -12:
              break;
            case 12:
              { return xp路ide路source路parser路ClassParser::T_STATIC; }
            case -13:
              break;
            case 13:
              { return xp路ide路source路parser路ClassParser::T_PUBLIC; }
            case -14:
              break;
            case 14:
              { return xp路ide路source路parser路ClassParser::T_PROTECTED; }
            case -15:
              break;
            case 15:
              { $this->yybegin(self::YYINITIAL); }
            case -16:
              break;
            case 16:
              { }
            case -17:
              break;
            case 18:
              { return ord($this->yytext()); }
            case -18:
              break;
            default:
            $this->yy_error('INTERNAL',false);
          case -1:
          }
          $yy_initial = true;
          $yy_state = self::$yy_state_dtrans[$this->yy_lexical_state];
          $yy_next_state = self::YY_NO_STATE;
          $yy_last_accept_state = self::YY_NO_STATE;
          $this->yy_mark_start();
          $yy_this_accept = self::$yy_acpt[$yy_state];
          if (self::YY_NOT_ACCEPT != $yy_this_accept) {
            $yy_last_accept_state = $yy_state;
            $this->yy_mark_end();
          }
        }
      }
    }
  }
}
?>
