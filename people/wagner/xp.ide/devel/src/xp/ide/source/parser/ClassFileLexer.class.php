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
  const YY_BOL = 256;
  var $YY_EOF = 257;
  protected $yy_count_chars = true;
  protected $yy_count_lines = true;

  function __construct($stream) {
    parent::__construct($stream);
    $this->yy_lexical_state = self::YYINITIAL;
  }

  const S_INNERBLOCK = 3;
  const S_APIDOC_END = 8;
  const S_ENCAPSED_S = 4;
  const S_BLOCKCOMMENT = 1;
  const YYINITIAL = 0;
  const S_BLOCKCOMMENT_END = 2;
  const S_APIDOC = 6;
  const S_ENCAPSED_D = 5;
  const S_APIDOC_DIRECTIVE = 7;
  static $yy_state_dtrans = array(
    0,
    64,
    65,
    67,
    68,
    69,
    70,
    72,
    79
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
    /* 29 */ self::YY_NO_ANCHOR,
    /* 30 */ self::YY_NO_ANCHOR,
    /* 31 */ self::YY_NO_ANCHOR,
    /* 32 */ self::YY_NO_ANCHOR,
    /* 33 */ self::YY_NO_ANCHOR,
    /* 34 */ self::YY_NOT_ACCEPT,
    /* 35 */ self::YY_NO_ANCHOR,
    /* 36 */ self::YY_NO_ANCHOR,
    /* 37 */ self::YY_NO_ANCHOR,
    /* 38 */ self::YY_NO_ANCHOR,
    /* 39 */ self::YY_NO_ANCHOR,
    /* 40 */ self::YY_NO_ANCHOR,
    /* 41 */ self::YY_NOT_ACCEPT,
    /* 42 */ self::YY_NO_ANCHOR,
    /* 43 */ self::YY_NO_ANCHOR,
    /* 44 */ self::YY_NO_ANCHOR,
    /* 45 */ self::YY_NO_ANCHOR,
    /* 46 */ self::YY_NOT_ACCEPT,
    /* 47 */ self::YY_NO_ANCHOR,
    /* 48 */ self::YY_NO_ANCHOR,
    /* 49 */ self::YY_NO_ANCHOR,
    /* 50 */ self::YY_NO_ANCHOR,
    /* 51 */ self::YY_NOT_ACCEPT,
    /* 52 */ self::YY_NO_ANCHOR,
    /* 53 */ self::YY_NO_ANCHOR,
    /* 54 */ self::YY_NO_ANCHOR,
    /* 55 */ self::YY_NO_ANCHOR,
    /* 56 */ self::YY_NOT_ACCEPT,
    /* 57 */ self::YY_NO_ANCHOR,
    /* 58 */ self::YY_NO_ANCHOR,
    /* 59 */ self::YY_NO_ANCHOR,
    /* 60 */ self::YY_NOT_ACCEPT,
    /* 61 */ self::YY_NO_ANCHOR,
    /* 62 */ self::YY_NOT_ACCEPT,
    /* 63 */ self::YY_NO_ANCHOR,
    /* 64 */ self::YY_NOT_ACCEPT,
    /* 65 */ self::YY_NOT_ACCEPT,
    /* 66 */ self::YY_NOT_ACCEPT,
    /* 67 */ self::YY_NOT_ACCEPT,
    /* 68 */ self::YY_NOT_ACCEPT,
    /* 69 */ self::YY_NOT_ACCEPT,
    /* 70 */ self::YY_NOT_ACCEPT,
    /* 71 */ self::YY_NOT_ACCEPT,
    /* 72 */ self::YY_NOT_ACCEPT,
    /* 73 */ self::YY_NOT_ACCEPT,
    /* 74 */ self::YY_NOT_ACCEPT,
    /* 75 */ self::YY_NOT_ACCEPT,
    /* 76 */ self::YY_NOT_ACCEPT,
    /* 77 */ self::YY_NOT_ACCEPT,
    /* 78 */ self::YY_NO_ANCHOR,
    /* 79 */ self::YY_NOT_ACCEPT,
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
    /* 96 */ self::YY_NO_ANCHOR,
    /* 97 */ self::YY_NO_ANCHOR,
    /* 98 */ self::YY_NO_ANCHOR,
    /* 99 */ self::YY_NO_ANCHOR,
    /* 100 */ self::YY_NO_ANCHOR,
    /* 101 */ self::YY_NO_ANCHOR,
    /* 102 */ self::YY_NO_ANCHOR
  );
    static $yy_cmap = array(
 39, 39, 39, 39, 39, 39, 39, 39, 39, 3, 1, 39, 3, 2, 39, 39, 39, 39, 39, 39,
 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 3, 36, 30, 39, 34, 36, 36, 31,
 36, 36, 33, 37, 36, 25, 24, 32, 26, 23, 23, 23, 23, 23, 23, 23, 23, 23, 36, 36,
 4, 36, 8, 5, 38, 12, 13, 16, 20, 11, 27, 35, 7, 21, 35, 35, 17, 22, 19, 35,
 6, 35, 15, 10, 14, 9, 35, 35, 18, 35, 35, 36, 40, 36, 36, 35, 39, 12, 13, 16,
 20, 11, 27, 35, 7, 21, 35, 35, 17, 22, 19, 35, 6, 35, 15, 10, 14, 9, 35, 35,
 18, 35, 35, 28, 36, 29, 36, 39, 39, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35,
 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35,
 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35,
 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35,
 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35,
 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35,
 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 0, 0,);

    static $yy_rmap = array(
 0, 1, 2, 3, 4, 5, 1, 1, 1, 1, 1, 6, 7, 1, 4, 1, 4, 4, 4, 4,
 8, 1, 1, 1, 1, 1, 1, 1, 1, 8, 1, 1, 1, 1, 9, 10, 11, 12, 1, 13,
 14, 15, 1, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 19, 27, 28, 24, 29, 30,
 22, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49,
 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69,
 70, 71, 72,);

    static $yy_nxt = array(
array(
 1, 2, 2, 2, 3, 35, 4, 4, 42, 84, 4, 96, 99, 4, 4, 4, 89, 4, 4, 4,
 4, 102, 4, 5, 47, -1, 37, 4, 6, 7, 8, 9, 52, -1, 57, 4, 42, 42, 42, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, 2, 2, 2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, 34, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 41, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, 5, 44, -1, 5, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 13, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 12, 12, -1, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12,
 12, 12, 12, 12, -1, -1, 12, 12, -1, -1, -1, -1, -1, -1, -1, 12, -1, -1, -1, -1,
 -1,
),
array(
 -1, 20, 20, 20, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 56, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, 10, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 14, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 41, -1, -1, -1, -1, -1, -1, 46, -1,
 -1, -1, -1, 5, 44, -1, 5, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, 39, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 31, -1,
 -1,
),
array(
 -1, -1, -1, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40,
 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40,
 40,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, 49, -1, 60, 49, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 60, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 16, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 41, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, 44, -1, -1, 44, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 21, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 54, 54, 54, -1, -1, 54, -1, -1, -1,
 54, -1, -1, 54, -1, -1, 54, 54, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, 44, -1, -1, 44, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 17, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, 49, -1, -1, 49, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 26, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 12, 12, -1, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12,
 12, 12, 12, -1, -1, -1, -1, 12, -1, -1, -1, -1, -1, -1, 51, 12, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 11, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 18, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 28, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 19, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, 20, 29, 63, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 30, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 15, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, 20, 20, 63, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 71, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 1, 20, 20, 20, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38,
 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 45, 38, 38, 38, 38, 38, 38,
 38,
),
array(
 1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 66, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 22, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 1, 20, 20, 20, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38,
 38, 38, 38, 38, 38, 38, 38, 38, 23, 24, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38,
 38,
),
array(
 1, 20, 20, 20, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38,
 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 25, 38, 38, 38, 38, 38, 38, 38, 38,
 50,
),
array(
 1, 20, 20, 20, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38,
 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 27, 38, 38, 38, 38, 38, 38, 38, 38, 38,
 55,
),
array(
 1, 59, 29, 20, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38,
 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 61, 38, 38, 38, 38, 38, 38,
 38,
),
array(
 -1, -1, -1, 39, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 1, 73, 32, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 74, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, 32, 75, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 33, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, 75, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 76, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, 77, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, 77, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 40, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 36, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 74, -1, -1, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 43, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 48, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 53, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 58, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 78, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 80, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 81,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 82, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 83,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 85, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 86, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 87, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 88, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 90, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 91, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 92, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 93, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 94, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 95, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 97, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 98, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 100, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 101, 4, -1, -1, 4, 4, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1, -1, -1,
 -1,
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
              { $this->yybegin(self::S_BLOCKCOMMENT); return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_BCOMMENT); }
            case -12:
              break;
            case 12:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_VARIABLE); }
            case -13:
              break;
            case 13:
              { $this->yybegin(self::S_APIDOC); return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_APIDOC); }
            case -14:
              break;
            case 14:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_USES); }
            case -15:
              break;
            case 15:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_TAG); }
            case -16:
              break;
            case 16:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLASS); }
            case -17:
              break;
            case 17:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_EXTENDS); }
            case -18:
              break;
            case 18:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_ABSTRACT); }
            case -19:
              break;
            case 19:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_IMPLEMENTS); }
            case -20:
              break;
            case 20:
              {  $this->addBuffer($this->yytext()); }
            case -21:
              break;
            case 21:
              {
  $this->yy_buffer_index -= 2;
  $this->yybegin(self::S_BLOCKCOMMENT_END);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_BCOMMENT, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -22:
              break;
            case 22:
              {
  $this->yybegin(self::YYINITIAL);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_BCOMMENT);
  return;
}
            case -23:
              break;
            case 23:
              { $this->addBuffer($this->yytext()); $this->cnt++; }
            case -24:
              break;
            case 24:
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
            case -25:
              break;
            case 25:
              {
  $this->yybegin(self::YYINITIAL);
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_ENCAPSED_STRING, $this->getBuffer());
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
              {
  $this->yybegin(self::YYINITIAL);
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -28:
              break;
            case 28:
              { $this->addBuffer($this->yytext()); }
            case -29:
              break;
            case 29:
              { $this->addBuffer(PHP_EOL); }
            case -30:
              break;
            case 30:
              {
  $this->yy_buffer_index -= 2;
  $this->yybegin(self::S_APIDOC_END);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_APIDOC, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -31:
              break;
            case 31:
              {
  $this->yy_buffer_index -= $this->yytext_length();
  $this->yybegin(self::S_APIDOC_DIRECTIVE);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_APIDOC, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -32:
              break;
            case 32:
              {
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_DIRECTIVE_APIDOC, $this->yytext());
}
            case -33:
              break;
            case 33:
              {
  $this->yybegin(self::YYINITIAL);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_APIDOC);
  return;
}
            case -34:
              break;
            case 35:
              { return $this->createToken(ord($this->yytext())); }
            case -35:
              break;
            case 36:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -36:
              break;
            case 37:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -37:
              break;
            case 38:
              {  $this->addBuffer($this->yytext()); }
            case -38:
              break;
            case 39:
              { $this->addBuffer(PHP_EOL); }
            case -39:
              break;
            case 40:
              {
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_DIRECTIVE_APIDOC, $this->yytext());
}
            case -40:
              break;
            case 42:
              { return $this->createToken(ord($this->yytext())); }
            case -41:
              break;
            case 43:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -42:
              break;
            case 44:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -43:
              break;
            case 45:
              {  $this->addBuffer($this->yytext()); }
            case -44:
              break;
            case 47:
              { return $this->createToken(ord($this->yytext())); }
            case -45:
              break;
            case 48:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -46:
              break;
            case 49:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -47:
              break;
            case 50:
              {  $this->addBuffer($this->yytext()); }
            case -48:
              break;
            case 52:
              { return $this->createToken(ord($this->yytext())); }
            case -49:
              break;
            case 53:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -50:
              break;
            case 54:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -51:
              break;
            case 55:
              {  $this->addBuffer($this->yytext()); }
            case -52:
              break;
            case 57:
              { return $this->createToken(ord($this->yytext())); }
            case -53:
              break;
            case 58:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -54:
              break;
            case 59:
              {  $this->addBuffer($this->yytext()); }
            case -55:
              break;
            case 61:
              {  $this->addBuffer($this->yytext()); }
            case -56:
              break;
            case 63:
              {  $this->addBuffer($this->yytext()); }
            case -57:
              break;
            case 78:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -58:
              break;
            case 80:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -59:
              break;
            case 81:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -60:
              break;
            case 82:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -61:
              break;
            case 83:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -62:
              break;
            case 84:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -63:
              break;
            case 85:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -64:
              break;
            case 86:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -65:
              break;
            case 87:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -66:
              break;
            case 88:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -67:
              break;
            case 89:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -68:
              break;
            case 90:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -69:
              break;
            case 91:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -70:
              break;
            case 92:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -71:
              break;
            case 93:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -72:
              break;
            case 94:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -73:
              break;
            case 95:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -74:
              break;
            case 96:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -75:
              break;
            case 97:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -76:
              break;
            case 98:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -77:
              break;
            case 99:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -78:
              break;
            case 100:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -79:
              break;
            case 101:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -80:
              break;
            case 102:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -81:
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
