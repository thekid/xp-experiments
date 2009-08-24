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
  const YY_BOL = 256;
  var $YY_EOF = 257;
  protected $yy_count_chars = true;
  protected $yy_count_lines = true;

  function __construct($stream) {
    parent::__construct($stream);
    $this->yy_lexical_state = self::YYINITIAL;
  }

  const S_ENCAPSED_D = 2;
  const YYINITIAL = 0;
  const S_METHOD_CONTENT = 3;
  const S_ENCAPSED_S = 1;
  static $yy_state_dtrans = array(
    0,
    47,
    49,
    51
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
    /* 38 */ self::YY_NO_ANCHOR,
    /* 39 */ self::YY_NOT_ACCEPT,
    /* 40 */ self::YY_NO_ANCHOR,
    /* 41 */ self::YY_NO_ANCHOR,
    /* 42 */ self::YY_NO_ANCHOR,
    /* 43 */ self::YY_NO_ANCHOR,
    /* 44 */ self::YY_NOT_ACCEPT,
    /* 45 */ self::YY_NO_ANCHOR,
    /* 46 */ self::YY_NO_ANCHOR,
    /* 47 */ self::YY_NOT_ACCEPT,
    /* 48 */ self::YY_NO_ANCHOR,
    /* 49 */ self::YY_NOT_ACCEPT,
    /* 50 */ self::YY_NO_ANCHOR,
    /* 51 */ self::YY_NOT_ACCEPT,
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
    /* 77 */ self::YY_NO_ANCHOR,
    /* 78 */ self::YY_NO_ANCHOR,
    /* 79 */ self::YY_NO_ANCHOR,
    /* 80 */ self::YY_NO_ANCHOR,
    /* 81 */ self::YY_NO_ANCHOR,
    /* 82 */ self::YY_NO_ANCHOR,
    /* 83 */ self::YY_NO_ANCHOR,
    /* 84 */ self::YY_NO_ANCHOR,
    /* 85 */ self::YY_NO_ANCHOR,
    /* 86 */ self::YY_NO_ANCHOR,
    /* 87 */ self::YY_NO_ANCHOR,
    /* 88 */ self::YY_NO_ANCHOR,
    /* 89 */ self::YY_NO_ANCHOR,
    /* 90 */ self::YY_NO_ANCHOR,
    /* 91 */ self::YY_NO_ANCHOR,
    /* 92 */ self::YY_NO_ANCHOR,
    /* 93 */ self::YY_NO_ANCHOR,
    /* 94 */ self::YY_NO_ANCHOR,
    /* 95 */ self::YY_NO_ANCHOR,
    /* 96 */ self::YY_NO_ANCHOR
  );
    static $yy_cmap = array(
 35, 35, 35, 35, 35, 35, 35, 35, 35, 1, 1, 35, 1, 1, 35, 35, 35, 35, 35, 35,
 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 1, 32, 27, 35, 29, 32, 32, 28,
 32, 32, 35, 33, 32, 23, 22, 32, 24, 21, 21, 21, 21, 21, 21, 21, 21, 21, 32, 32,
 32, 19, 20, 32, 32, 13, 16, 5, 15, 14, 18, 30, 30, 11, 30, 30, 4, 30, 2, 6,
 9, 30, 10, 7, 8, 3, 12, 30, 25, 17, 30, 32, 34, 32, 32, 30, 35, 13, 16, 5,
 15, 14, 18, 30, 30, 11, 30, 30, 4, 30, 2, 6, 9, 30, 10, 7, 8, 3, 12, 30,
 25, 17, 30, 26, 32, 31, 32, 35, 35, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30,
 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30,
 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30,
 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30,
 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30,
 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30,
 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 0, 0,);

    static $yy_rmap = array(
 0, 1, 2, 3, 4, 5, 1, 1, 1, 1, 6, 7, 7, 7, 7, 7, 7, 7, 7, 7,
 7, 7, 8, 1, 1, 1, 1, 1, 1, 9, 10, 1, 11, 1, 12, 13, 14, 15, 16, 17,
 18, 17, 19, 20, 19, 21, 12, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34,
 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54,
 55, 56, 57, 58, 59, 60, 7, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70,);

    static $yy_nxt = array(
array(
 1, 2, 3, 86, 86, 90, 86, 92, 93, 94, 86, 86, 86, 95, 86, 86, 86, 86, 96, 4,
 31, 5, 36, -1, 32, 86, 6, 7, 8, 41, 86, 31, 31, 31, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, 2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 57, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 9, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 29, -1, -1, -1, -1, -1,
 -1, 5, 37, -1, 5, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, -1,
 -1, 10, -1, -1, 10, 10, -1, -1, -1, -1, 10, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, 22, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 42, -1, 44, 42, -1, -1, -1, -1, -1, -1, -1, -1, 44, -1, -1,
),
array(
 -1, -1, 86, 86, 11, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 29, -1, -1, -1, -1, -1,
 -1, 5, 37, -1, 5, 34, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, 46, -1, -1, -1, -1, -1, -1, -1, 46, 46, 46, 46, -1, 46, -1,
 -1, 46, -1, -1, 46, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 12, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 37, -1, -1, 37, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 29, -1, -1, -1, -1, -1,
 -1, 37, -1, -1, 37, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, 24, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, -1,
 -1, -1, -1, -1, -1, 10, -1, -1, -1, 39, 10, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 13, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 42, -1, -1, 42, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, 26, -1, -1, -1, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 14, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 1, 22, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33,
 33, 33, 33, 33, 33, 33, 33, 33, 23, 33, 33, 33, 33, 33, 38, 33,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 15, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 1, 22, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33,
 33, 33, 33, 33, 33, 33, 33, 25, 33, 33, 33, 33, 33, 33, 43, 33,
),
array(
 -1, -1, 86, 86, 86, 16, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 1, 22, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33,
 33, 33, 33, 33, 33, 33, 27, 33, 33, 33, 33, 28, 33, 33, 33, 33,
),
array(
 -1, -1, 86, 86, 86, 17, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 18, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 19, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 20, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 21, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 30, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 66, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 67, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 35, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 88, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 89, 86, 86, 86, 86, 68, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 69, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 91, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 71, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 40, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 72, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 75, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 45, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 77, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 48, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 50, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 52, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 78, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 79, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 80, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 81, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 82, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 53, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 83, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 84, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 85, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 54, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 55, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 56, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 70, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 73, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 74, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 58, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 76, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 59, 86, 86, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 60, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 61, 86, 86, 86, 86, 86, 86, 62, 86, 86, 86, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 86, 86, 86, 86, 86, 86, 86, 63, 86, 86, 86, 86, 86, 64, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
),
array(
 -1, -1, 86, 87, 86, 86, 86, 86, 86, 86, 86, 86, 86, 65, 86, 86, 86, 86, 86, -1,
 -1, 86, -1, -1, 86, 86, -1, -1, -1, -1, 86, -1, -1, -1, -1, -1,
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
              { $this->yybegin(self::S_METHOD_CONTENT); $this->cnt= 0; return $this->createToken(ord($this->yytext())); }
            case -7:
              break;
            case 7:
              { $this->yybegin(self::S_ENCAPSED_D); $this->addBuffer($this->yytext()); }
            case -8:
              break;
            case 8:
              { $this->yybegin(self::S_ENCAPSED_S); $this->addBuffer($this->yytext()); }
            case -9:
              break;
            case 9:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_DOUBLE_ARROW); }
            case -10:
              break;
            case 10:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_VARIABLE); }
            case -11:
              break;
            case 11:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NULL); }
            case -12:
              break;
            case 12:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_BOOLEAN); }
            case -13:
              break;
            case 13:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_CONST); }
            case -14:
              break;
            case 14:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_ARRAY); }
            case -15:
              break;
            case 15:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_BOOLEAN); }
            case -16:
              break;
            case 16:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STATIC); }
            case -17:
              break;
            case 17:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_PUBLIC); }
            case -18:
              break;
            case 18:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_PRIVATE); }
            case -19:
              break;
            case 19:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_ABSTRACT); }
            case -20:
              break;
            case 20:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_FUNCTION); }
            case -21:
              break;
            case 21:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_PROTECTED); }
            case -22:
              break;
            case 22:
              {  $this->addBuffer($this->yytext()); }
            case -23:
              break;
            case 23:
              {
  $this->yybegin(self::YYINITIAL);
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -24:
              break;
            case 24:
              { $this->addBuffer($this->yytext()); }
            case -25:
              break;
            case 25:
              {
  $this->yybegin(self::YYINITIAL);
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -26:
              break;
            case 26:
              { $this->addBuffer($this->yytext()); }
            case -27:
              break;
            case 27:
              { $this->addBuffer($this->yytext()); $this->cnt++; }
            case -28:
              break;
            case 28:
              {
  if (--$this->cnt < 0) {
    $this->yy_buffer_index--;
    $this->yybegin(self::YYINITIAL);
    $this->createToken(xp·ide·source·parser·ClassParser::T_FUNCTION_BODY, $this->getBuffer());
    $this->resetBuffer();
    return;
  } else {
    $this->addBuffer($this->yytext());
  }
}
            case -29:
              break;
            case 30:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -30:
              break;
            case 31:
              { return $this->createToken(ord($this->yytext())); }
            case -31:
              break;
            case 32:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -32:
              break;
            case 33:
              {  $this->addBuffer($this->yytext()); }
            case -33:
              break;
            case 35:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -34:
              break;
            case 36:
              { return $this->createToken(ord($this->yytext())); }
            case -35:
              break;
            case 37:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -36:
              break;
            case 38:
              {  $this->addBuffer($this->yytext()); }
            case -37:
              break;
            case 40:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -38:
              break;
            case 41:
              { return $this->createToken(ord($this->yytext())); }
            case -39:
              break;
            case 42:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -40:
              break;
            case 43:
              {  $this->addBuffer($this->yytext()); }
            case -41:
              break;
            case 45:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -42:
              break;
            case 46:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -43:
              break;
            case 48:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -44:
              break;
            case 50:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -45:
              break;
            case 52:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -46:
              break;
            case 53:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -47:
              break;
            case 54:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -48:
              break;
            case 55:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -49:
              break;
            case 56:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -50:
              break;
            case 57:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -51:
              break;
            case 58:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -52:
              break;
            case 59:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -53:
              break;
            case 60:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -54:
              break;
            case 61:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -55:
              break;
            case 62:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -56:
              break;
            case 63:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -57:
              break;
            case 64:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -58:
              break;
            case 65:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -59:
              break;
            case 66:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -60:
              break;
            case 67:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -61:
              break;
            case 68:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -62:
              break;
            case 69:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -63:
              break;
            case 70:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -64:
              break;
            case 71:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -65:
              break;
            case 72:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -66:
              break;
            case 73:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -67:
              break;
            case 74:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -68:
              break;
            case 75:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -69:
              break;
            case 76:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -70:
              break;
            case 77:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -71:
              break;
            case 78:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -72:
              break;
            case 79:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -73:
              break;
            case 80:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -74:
              break;
            case 81:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -75:
              break;
            case 82:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -76:
              break;
            case 83:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -77:
              break;
            case 84:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -78:
              break;
            case 85:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -79:
              break;
            case 86:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -80:
              break;
            case 87:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -81:
              break;
            case 88:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -82:
              break;
            case 89:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -83:
              break;
            case 90:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -84:
              break;
            case 91:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -85:
              break;
            case 92:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -86:
              break;
            case 93:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -87:
              break;
            case 94:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -88:
              break;
            case 95:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -89:
              break;
            case 96:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -90:
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
