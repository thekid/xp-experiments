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
  class xp·ide·source·parser·ClassLexer extends xp·ide·source·parser·Lexer  {
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

  const S_ENCAPSED_D = 2;
  const YYINITIAL = 0;
  const S_ENCAPSED_S = 1;
  static $yy_state_dtrans = array(
    0,
    41,
    43
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
    /* 17 */ self::YY_NO_ANCHOR,
    /* 18 */ self::YY_NO_ANCHOR,
    /* 19 */ self::YY_NO_ANCHOR,
    /* 20 */ self::YY_NO_ANCHOR,
    /* 21 */ self::YY_NO_ANCHOR,
    /* 22 */ self::YY_NO_ANCHOR,
    /* 23 */ self::YY_NO_ANCHOR,
    /* 24 */ self::YY_NOT_ACCEPT,
    /* 25 */ self::YY_NO_ANCHOR,
    /* 26 */ self::YY_NO_ANCHOR,
    /* 27 */ self::YY_NO_ANCHOR,
    /* 28 */ self::YY_NO_ANCHOR,
    /* 29 */ self::YY_NOT_ACCEPT,
    /* 30 */ self::YY_NO_ANCHOR,
    /* 31 */ self::YY_NO_ANCHOR,
    /* 32 */ self::YY_NO_ANCHOR,
    /* 33 */ self::YY_NO_ANCHOR,
    /* 34 */ self::YY_NOT_ACCEPT,
    /* 35 */ self::YY_NO_ANCHOR,
    /* 36 */ self::YY_NO_ANCHOR,
    /* 37 */ self::YY_NO_ANCHOR,
    /* 38 */ self::YY_NOT_ACCEPT,
    /* 39 */ self::YY_NO_ANCHOR,
    /* 40 */ self::YY_NO_ANCHOR,
    /* 41 */ self::YY_NOT_ACCEPT,
    /* 42 */ self::YY_NO_ANCHOR,
    /* 43 */ self::YY_NOT_ACCEPT,
    /* 44 */ self::YY_NO_ANCHOR,
    /* 45 */ self::YY_NO_ANCHOR,
    /* 46 */ self::YY_NO_ANCHOR,
    /* 47 */ self::YY_NO_ANCHOR,
    /* 48 */ self::YY_NO_ANCHOR,
    /* 49 */ self::YY_NO_ANCHOR,
    /* 50 */ self::YY_NO_ANCHOR,
    /* 51 */ self::YY_NO_ANCHOR,
    /* 52 */ self::YY_NO_ANCHOR,
    /* 53 */ self::YY_NO_ANCHOR,
    /* 54 */ self::YY_NO_ANCHOR,
    /* 55 */ self::YY_NO_ANCHOR,
    /* 56 */ self::YY_NO_ANCHOR,
    /* 57 */ self::YY_NO_ANCHOR,
    /* 58 */ self::YY_NO_ANCHOR,
    /* 59 */ self::YY_NO_ANCHOR,
    /* 60 */ self::YY_NO_ANCHOR,
    /* 61 */ self::YY_NO_ANCHOR,
    /* 62 */ self::YY_NO_ANCHOR,
    /* 63 */ self::YY_NO_ANCHOR,
    /* 64 */ self::YY_NO_ANCHOR,
    /* 65 */ self::YY_NO_ANCHOR,
    /* 66 */ self::YY_NO_ANCHOR,
    /* 67 */ self::YY_NO_ANCHOR,
    /* 68 */ self::YY_NO_ANCHOR,
    /* 69 */ self::YY_NO_ANCHOR,
    /* 70 */ self::YY_NO_ANCHOR,
    /* 71 */ self::YY_NO_ANCHOR,
    /* 72 */ self::YY_NO_ANCHOR,
    /* 73 */ self::YY_NO_ANCHOR,
    /* 74 */ self::YY_NO_ANCHOR,
    /* 75 */ self::YY_NO_ANCHOR,
    /* 76 */ self::YY_NO_ANCHOR,
    /* 77 */ self::YY_NO_ANCHOR
  );
    static $yy_cmap = array(
 33, 33, 33, 33, 33, 33, 33, 33, 33, 34, 1, 33, 34, 1, 33, 33, 33, 33, 33, 33,
 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 34, 30, 26, 33, 28, 30, 30, 27,
 30, 30, 33, 31, 30, 23, 22, 30, 24, 21, 21, 21, 21, 21, 21, 21, 21, 21, 30, 30,
 30, 19, 20, 30, 30, 13, 16, 5, 15, 14, 18, 35, 35, 11, 35, 35, 4, 35, 2, 6,
 9, 35, 10, 7, 8, 3, 12, 35, 25, 17, 35, 30, 32, 30, 30, 35, 33, 13, 16, 5,
 15, 14, 18, 35, 35, 11, 35, 35, 4, 35, 2, 6, 9, 35, 10, 7, 8, 3, 12, 35,
 25, 17, 35, 33, 30, 33, 30, 33, 0, 29,);

    static $yy_rmap = array(
 0, 1, 2, 3, 4, 5, 1, 1, 1, 6, 7, 7, 7, 7, 7, 7, 7, 7, 7, 1,
 1, 1, 1, 1, 8, 9, 1, 10, 11, 12, 13, 14, 15, 16, 17, 18, 17, 19, 19, 20,
 12, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39,
 40, 41, 42, 43, 44, 45, 46, 47, 48, 7, 49, 50, 51, 52, 53, 54, 55, 56,);

    static $yy_nxt = array(
array(
 1, 2, 3, 69, 69, 72, 69, 73, 74, 75, 69, 69, 69, 76, 69, 69, 69, 69, 77, 4,
 26, 5, 31, -1, 27, 69, 6, 7, 36, 69, 26, 26, -1, -1, 2, 69,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, 2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 2, -1,
),
array(
 -1, -1, 69, 48, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 8, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 24, -1, -1, -1, -1, -1,
 -1, 5, 32, -1, 5, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, -1,
 -1, 9, -1, -1, 9, 9, -1, -1, -1, 9, -1, -1, -1, -1, -1, 9,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 37, -1, 38, 37, -1, -1, -1, -1, -1, -1, 38, -1, -1, -1, -1,
),
array(
 -1, -1, 69, 69, 10, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 24, -1, -1, -1, -1, -1,
 -1, 5, 32, -1, 5, 29, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, 21, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, 40, -1, -1, -1, -1, -1, -1, -1, 40, 40, 40, 40, -1, 40, -1,
 -1, 40, -1, -1, 40, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 11, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 32, -1, -1, 32, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 24, -1, -1, -1, -1, -1,
 -1, 32, -1, -1, 32, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, 23, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, -1,
 -1, -1, -1, -1, -1, 9, -1, -1, 34, 9, -1, -1, -1, -1, -1, 9,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 12, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 37, -1, -1, 37, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 13, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 1, -1, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19,
 19, 19, 19, 19, 19, 19, 19, 20, 19, 1, 19, 19, 28, 19, 19, 19,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 14, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 1, -1, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19,
 19, 19, 19, 19, 19, 19, 22, 19, 19, 1, 19, 19, 33, 19, 19, 19,
),
array(
 -1, -1, 69, 69, 69, 15, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 16, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 17, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 18, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 25, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 56, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 57, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 30, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 70, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 71, 69, 69, 69, 69, 58, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 59, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 60, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 35, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 61, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 64, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 39, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 42, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 44, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 45, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 65, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 66, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 67, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 46, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 68, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 47, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 62, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 63, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 49, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 50, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 51, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 52, 69, 69, 69, 69, 69, 69, 53, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 54, 69, 69, 69, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
),
array(
 -1, -1, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 69, 55, 69, 69, 69, 69, 69, -1,
 -1, 69, -1, -1, 69, 69, -1, -1, -1, 69, -1, -1, -1, -1, -1, 69,
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
              { }
            case -3:
              break;
            case 3:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -4:
              break;
            case 4:
              { return $this->createToken(ord($this->yytext())); }
            case -5:
              break;
            case 5:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -6:
              break;
            case 6:
              { $this->yybegin(self::S_ENCAPSED_D); $this->addBuffer($this->yytext()); }
            case -7:
              break;
            case 7:
              { $this->yybegin(self::S_ENCAPSED_S); $this->addBuffer($this->yytext()); }
            case -8:
              break;
            case 8:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_DOUBLE_ARROW); }
            case -9:
              break;
            case 9:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_VARIABLE); }
            case -10:
              break;
            case 10:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NULL); }
            case -11:
              break;
            case 11:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_BOOLEAN); }
            case -12:
              break;
            case 12:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_CONST); }
            case -13:
              break;
            case 13:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_ARRAY); }
            case -14:
              break;
            case 14:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_BOOLEAN); }
            case -15:
              break;
            case 15:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STATIC); }
            case -16:
              break;
            case 16:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_PUBLIC); }
            case -17:
              break;
            case 17:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_PRIVATE); }
            case -18:
              break;
            case 18:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_PROTECTED); }
            case -19:
              break;
            case 19:
              {  $this->addBuffer($this->yytext()); }
            case -20:
              break;
            case 20:
              {
  $this->yybegin(self::YYINITIAL);
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -21:
              break;
            case 21:
              {  $this->addBuffer($this->yytext()); }
            case -22:
              break;
            case 22:
              {
  $this->yybegin(self::YYINITIAL);
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -23:
              break;
            case 23:
              {  $this->addBuffer($this->yytext()); }
            case -24:
              break;
            case 25:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -25:
              break;
            case 26:
              { return $this->createToken(ord($this->yytext())); }
            case -26:
              break;
            case 27:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -27:
              break;
            case 28:
              {  $this->addBuffer($this->yytext()); }
            case -28:
              break;
            case 30:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -29:
              break;
            case 31:
              { return $this->createToken(ord($this->yytext())); }
            case -30:
              break;
            case 32:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -31:
              break;
            case 33:
              {  $this->addBuffer($this->yytext()); }
            case -32:
              break;
            case 35:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -33:
              break;
            case 36:
              { return $this->createToken(ord($this->yytext())); }
            case -34:
              break;
            case 37:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -35:
              break;
            case 39:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -36:
              break;
            case 40:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -37:
              break;
            case 42:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -38:
              break;
            case 44:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -39:
              break;
            case 45:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -40:
              break;
            case 46:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -41:
              break;
            case 47:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -42:
              break;
            case 48:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -43:
              break;
            case 49:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -44:
              break;
            case 50:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -45:
              break;
            case 51:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -46:
              break;
            case 52:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -47:
              break;
            case 53:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -48:
              break;
            case 54:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -49:
              break;
            case 55:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -50:
              break;
            case 56:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -51:
              break;
            case 57:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -52:
              break;
            case 58:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -53:
              break;
            case 59:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -54:
              break;
            case 60:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -55:
              break;
            case 61:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -56:
              break;
            case 62:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -57:
              break;
            case 63:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -58:
              break;
            case 64:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -59:
              break;
            case 65:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -60:
              break;
            case 66:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -61:
              break;
            case 67:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -62:
              break;
            case 68:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -63:
              break;
            case 69:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -64:
              break;
            case 70:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -65:
              break;
            case 71:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -66:
              break;
            case 72:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -67:
              break;
            case 73:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -68:
              break;
            case 74:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -69:
              break;
            case 75:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -70:
              break;
            case 76:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -71:
              break;
            case 77:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -72:
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
