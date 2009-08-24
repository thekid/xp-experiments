<?php
 /* This class is part of the XP framework
  *
  * $Id$
  */
  $package= 'xp.ide.source.parser';
  uses(
    'xp.ide.source.parser.Lexer',
    'xp.ide.source.parser.ClassFileParser'
  );
  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class xp·ide·source·parser·ClassFileLexer extends xp·ide·source·parser·Lexer  {
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

  const S_ENCAPSED_D = 5;
  const S_INNERBLOCK = 3;
  const S_COMMENT = 1;
  const YYINITIAL = 0;
  const S_COMMENT_END = 2;
  const S_ENCAPSED_S = 4;
  static $yy_state_dtrans = array(
    0,
    53,
    54,
    56,
    57,
    58
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
    /* 24 */ self::YY_NO_ANCHOR,
    /* 25 */ self::YY_NO_ANCHOR,
    /* 26 */ self::YY_NO_ANCHOR,
    /* 27 */ self::YY_NO_ANCHOR,
    /* 28 */ self::YY_NOT_ACCEPT,
    /* 29 */ self::YY_NO_ANCHOR,
    /* 30 */ self::YY_NO_ANCHOR,
    /* 31 */ self::YY_NO_ANCHOR,
    /* 32 */ self::YY_NO_ANCHOR,
    /* 33 */ self::YY_NOT_ACCEPT,
    /* 34 */ self::YY_NO_ANCHOR,
    /* 35 */ self::YY_NO_ANCHOR,
    /* 36 */ self::YY_NO_ANCHOR,
    /* 37 */ self::YY_NO_ANCHOR,
    /* 38 */ self::YY_NOT_ACCEPT,
    /* 39 */ self::YY_NO_ANCHOR,
    /* 40 */ self::YY_NO_ANCHOR,
    /* 41 */ self::YY_NO_ANCHOR,
    /* 42 */ self::YY_NO_ANCHOR,
    /* 43 */ self::YY_NOT_ACCEPT,
    /* 44 */ self::YY_NO_ANCHOR,
    /* 45 */ self::YY_NO_ANCHOR,
    /* 46 */ self::YY_NO_ANCHOR,
    /* 47 */ self::YY_NO_ANCHOR,
    /* 48 */ self::YY_NOT_ACCEPT,
    /* 49 */ self::YY_NO_ANCHOR,
    /* 50 */ self::YY_NO_ANCHOR,
    /* 51 */ self::YY_NOT_ACCEPT,
    /* 52 */ self::YY_NOT_ACCEPT,
    /* 53 */ self::YY_NOT_ACCEPT,
    /* 54 */ self::YY_NOT_ACCEPT,
    /* 55 */ self::YY_NOT_ACCEPT,
    /* 56 */ self::YY_NOT_ACCEPT,
    /* 57 */ self::YY_NOT_ACCEPT,
    /* 58 */ self::YY_NOT_ACCEPT,
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
    /* 77 */ self::YY_NO_ANCHOR,
    /* 78 */ self::YY_NO_ANCHOR,
    /* 79 */ self::YY_NO_ANCHOR,
    /* 80 */ self::YY_NO_ANCHOR,
    /* 81 */ self::YY_NO_ANCHOR,
    /* 82 */ self::YY_NO_ANCHOR
  );
    static $yy_cmap = array(
 37, 37, 37, 37, 37, 37, 37, 37, 37, 1, 1, 37, 1, 1, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 1, 34, 28, 37, 32, 34, 34, 29,
 34, 34, 31, 35, 34, 23, 22, 30, 24, 21, 21, 21, 21, 21, 21, 21, 21, 21, 34, 34,
 2, 34, 6, 3, 34, 10, 11, 14, 18, 9, 25, 38, 5, 19, 38, 38, 15, 20, 17, 38,
 4, 38, 13, 8, 12, 7, 38, 38, 16, 38, 38, 34, 36, 34, 34, 38, 37, 10, 11, 14,
 18, 9, 25, 38, 5, 19, 38, 38, 15, 20, 17, 38, 4, 38, 13, 8, 12, 7, 38, 38,
 16, 38, 38, 26, 34, 27, 34, 37, 0, 33,);

    static $yy_rmap = array(
 0, 1, 2, 3, 4, 5, 1, 1, 1, 1, 1, 1, 6, 4, 1, 4, 4, 4, 4, 7,
 1, 1, 1, 1, 1, 1, 1, 1, 8, 9, 10, 11, 1, 12, 1, 13, 14, 15, 16, 17,
 18, 19, 20, 21, 22, 23, 16, 24, 25, 21, 26, 19, 27, 28, 29, 30, 31, 32, 33, 34,
 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54,
 55, 56, 57,);

    static $yy_nxt = array(
array(
 1, 2, 3, 29, 4, 4, 34, 64, 4, 76, 79, 4, 4, 4, 69, 4, 4, 4, 4, 82,
 4, 5, 39, -1, 31, 4, 6, 7, 8, 9, 44, -1, 49, 4, 34, 34, -1, -1, 4,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, 2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, 28, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, 33, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 5, 36, -1, 5, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 12, 12, -1, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12,
 12, 12, -1, -1, 12, 12, -1, -1, -1, -1, -1, -1, -1, 12, -1, -1, -1, -1, 12,
),
array(
 -1, 19, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 48, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 10, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 13, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, 33, -1, -1, -1, -1, -1, -1, 38, -1, -1, -1,
 -1, 5, 36, -1, 5, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 41, -1, 51, 41, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 51, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 15, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, 33, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 36, -1, -1, 36, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 20, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, 46, 46, 46, -1, -1, 46, -1, -1, -1, 46, -1,
 -1, 46, -1, -1, 46, 46, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 36, -1, -1, 36, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 16, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 41, -1, -1, 41, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, 25, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 12, 12, -1, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12,
 12, -1, -1, -1, -1, 12, -1, -1, -1, -1, -1, -1, 43, 12, -1, -1, -1, -1, 12,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 11, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 17, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, 27, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, 52, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 18, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 14, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 1, 19, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32,
 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 37, 32, 1, 32, 32, 32, 32, 32,
),
array(
 1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 55, -1, 1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 21, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 1, 19, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32,
 32, 32, 32, 32, 32, 32, 22, 23, 32, 32, 32, 32, 32, 1, 32, 32, 32, 32, 32,
),
array(
 1, 19, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32,
 32, 32, 32, 32, 32, 32, 32, 32, 32, 24, 32, 32, 32, 1, 32, 32, 42, 32, 32,
),
array(
 1, 19, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32,
 32, 32, 32, 32, 32, 32, 32, 32, 26, 32, 32, 32, 32, 1, 32, 32, 47, 32, 32,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 30, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 35, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 40, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 45, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 50, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 59, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 60, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 61, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 62, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 63, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 65, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 66, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 67, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 68, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 70, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 71, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 72, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 73, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 74, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 75, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 77, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 78, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 80, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
),
array(
 -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 81, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1, 4,
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
              { return $this->createToken(ord($this->yytext())); }
            case -4:
              break;
            case 4:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -5:
              break;
            case 5:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -6:
              break;
            case 6:
              { $this->yybegin(self::S_INNERBLOCK); $this->cnt= 0; return $this->createToken(ord($this->yytext())); }
            case -7:
              break;
            case 7:
              { return $this->createToken(ord($this->yytext())); }
            case -8:
              break;
            case 8:
              { $this->yybegin(self::S_ENCAPSED_D); $this->addBuffer($this->yytext()); }
            case -9:
              break;
            case 9:
              { $this->yybegin(self::S_ENCAPSED_S); $this->addBuffer($this->yytext()); }
            case -10:
              break;
            case 10:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_TAG); }
            case -11:
              break;
            case 11:
              { $this->yybegin(self::S_COMMENT); return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_BCOMMENT); }
            case -12:
              break;
            case 12:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_VARIABLE); }
            case -13:
              break;
            case 13:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_USES); }
            case -14:
              break;
            case 14:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_TAG); }
            case -15:
              break;
            case 15:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLASS); }
            case -16:
              break;
            case 16:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_EXTENDS); }
            case -17:
              break;
            case 17:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_ABSTRACT); }
            case -18:
              break;
            case 18:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_IMPLEMENTS); }
            case -19:
              break;
            case 19:
              {  $this->addBuffer($this->yytext()); }
            case -20:
              break;
            case 20:
              {
  $this->yy_buffer_index -= 2;
  $this->yybegin(self::S_COMMENT_END);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_BCOMMENT, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -21:
              break;
            case 21:
              {
  $this->yybegin(self::YYINITIAL);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_BCOMMENT);
  return;
}
            case -22:
              break;
            case 22:
              { $this->addBuffer($this->yytext()); $this->cnt++; }
            case -23:
              break;
            case 23:
              {
  if (--$this->cnt < 0) {
    $this->yy_buffer_index--;
    $this->yybegin(self::YYINITIAL);
    $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_INNERBLOCK, $this->getBuffer());
    $this->resetBuffer();
    return;
  } else {
    $this->addBuffer($this->yytext());
  }
}
            case -24:
              break;
            case 24:
              {
  $this->yybegin(self::YYINITIAL);
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -25:
              break;
            case 25:
              { $this->addBuffer($this->yytext()); }
            case -26:
              break;
            case 26:
              {
  $this->yybegin(self::YYINITIAL);
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -27:
              break;
            case 27:
              { $this->addBuffer($this->yytext()); }
            case -28:
              break;
            case 29:
              { return $this->createToken(ord($this->yytext())); }
            case -29:
              break;
            case 30:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -30:
              break;
            case 31:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -31:
              break;
            case 32:
              {  $this->addBuffer($this->yytext()); }
            case -32:
              break;
            case 34:
              { return $this->createToken(ord($this->yytext())); }
            case -33:
              break;
            case 35:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -34:
              break;
            case 36:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -35:
              break;
            case 37:
              {  $this->addBuffer($this->yytext()); }
            case -36:
              break;
            case 39:
              { return $this->createToken(ord($this->yytext())); }
            case -37:
              break;
            case 40:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -38:
              break;
            case 41:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -39:
              break;
            case 42:
              {  $this->addBuffer($this->yytext()); }
            case -40:
              break;
            case 44:
              { return $this->createToken(ord($this->yytext())); }
            case -41:
              break;
            case 45:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -42:
              break;
            case 46:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -43:
              break;
            case 47:
              {  $this->addBuffer($this->yytext()); }
            case -44:
              break;
            case 49:
              { return $this->createToken(ord($this->yytext())); }
            case -45:
              break;
            case 50:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -46:
              break;
            case 59:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -47:
              break;
            case 60:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -48:
              break;
            case 61:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -49:
              break;
            case 62:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -50:
              break;
            case 63:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -51:
              break;
            case 64:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -52:
              break;
            case 65:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -53:
              break;
            case 66:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -54:
              break;
            case 67:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -55:
              break;
            case 68:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -56:
              break;
            case 69:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -57:
              break;
            case 70:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -58:
              break;
            case 71:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -59:
              break;
            case 72:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -60:
              break;
            case 73:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -61:
              break;
            case 74:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -62:
              break;
            case 75:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -63:
              break;
            case 76:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -64:
              break;
            case 77:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -65:
              break;
            case 78:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -66:
              break;
            case 79:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -67:
              break;
            case 80:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -68:
              break;
            case 81:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -69:
              break;
            case 82:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -70:
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
