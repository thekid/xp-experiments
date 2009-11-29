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
  const S_APIDOC_DIRECTIVE_TEXT = 10;
  const YYINITIAL = 0;
  const S_BLOCKCOMMENT_END = 2;
  const S_APIDOC_TEXT = 9;
  const S_APIDOC = 6;
  const S_ENCAPSED_D = 5;
  const S_ANNOTATION = 11;
  const S_APIDOC_DIRECTIVE = 7;
  static $yy_state_dtrans = array(
    0,
    77,
    79,
    81,
    82,
    83,
    84,
    88,
    93,
    38,
    39,
    94
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
    /* 34 */ self::YY_NO_ANCHOR,
    /* 35 */ self::YY_NO_ANCHOR,
    /* 36 */ self::YY_NO_ANCHOR,
    /* 37 */ self::YY_NO_ANCHOR,
    /* 38 */ self::YY_NO_ANCHOR,
    /* 39 */ self::YY_NO_ANCHOR,
    /* 40 */ self::YY_NO_ANCHOR,
    /* 41 */ self::YY_NO_ANCHOR,
    /* 42 */ self::YY_NO_ANCHOR,
    /* 43 */ self::YY_NO_ANCHOR,
    /* 44 */ self::YY_NO_ANCHOR,
    /* 45 */ self::YY_NOT_ACCEPT,
    /* 46 */ self::YY_NO_ANCHOR,
    /* 47 */ self::YY_NO_ANCHOR,
    /* 48 */ self::YY_NO_ANCHOR,
    /* 49 */ self::YY_NO_ANCHOR,
    /* 50 */ self::YY_NO_ANCHOR,
    /* 51 */ self::YY_NO_ANCHOR,
    /* 52 */ self::YY_NO_ANCHOR,
    /* 53 */ self::YY_NOT_ACCEPT,
    /* 54 */ self::YY_NO_ANCHOR,
    /* 55 */ self::YY_NO_ANCHOR,
    /* 56 */ self::YY_NO_ANCHOR,
    /* 57 */ self::YY_NO_ANCHOR,
    /* 58 */ self::YY_NOT_ACCEPT,
    /* 59 */ self::YY_NO_ANCHOR,
    /* 60 */ self::YY_NO_ANCHOR,
    /* 61 */ self::YY_NO_ANCHOR,
    /* 62 */ self::YY_NO_ANCHOR,
    /* 63 */ self::YY_NOT_ACCEPT,
    /* 64 */ self::YY_NO_ANCHOR,
    /* 65 */ self::YY_NO_ANCHOR,
    /* 66 */ self::YY_NO_ANCHOR,
    /* 67 */ self::YY_NO_ANCHOR,
    /* 68 */ self::YY_NOT_ACCEPT,
    /* 69 */ self::YY_NO_ANCHOR,
    /* 70 */ self::YY_NO_ANCHOR,
    /* 71 */ self::YY_NOT_ACCEPT,
    /* 72 */ self::YY_NO_ANCHOR,
    /* 73 */ self::YY_NO_ANCHOR,
    /* 74 */ self::YY_NOT_ACCEPT,
    /* 75 */ self::YY_NO_ANCHOR,
    /* 76 */ self::YY_NO_ANCHOR,
    /* 77 */ self::YY_NOT_ACCEPT,
    /* 78 */ self::YY_NO_ANCHOR,
    /* 79 */ self::YY_NOT_ACCEPT,
    /* 80 */ self::YY_NO_ANCHOR,
    /* 81 */ self::YY_NOT_ACCEPT,
    /* 82 */ self::YY_NOT_ACCEPT,
    /* 83 */ self::YY_NOT_ACCEPT,
    /* 84 */ self::YY_NOT_ACCEPT,
    /* 85 */ self::YY_NOT_ACCEPT,
    /* 86 */ self::YY_NOT_ACCEPT,
    /* 87 */ self::YY_NOT_ACCEPT,
    /* 88 */ self::YY_NOT_ACCEPT,
    /* 89 */ self::YY_NOT_ACCEPT,
    /* 90 */ self::YY_NOT_ACCEPT,
    /* 91 */ self::YY_NOT_ACCEPT,
    /* 92 */ self::YY_NOT_ACCEPT,
    /* 93 */ self::YY_NOT_ACCEPT,
    /* 94 */ self::YY_NOT_ACCEPT,
    /* 95 */ self::YY_NO_ANCHOR,
    /* 96 */ self::YY_NO_ANCHOR,
    /* 97 */ self::YY_NO_ANCHOR,
    /* 98 */ self::YY_NO_ANCHOR,
    /* 99 */ self::YY_NO_ANCHOR,
    /* 100 */ self::YY_NO_ANCHOR,
    /* 101 */ self::YY_NO_ANCHOR,
    /* 102 */ self::YY_NO_ANCHOR,
    /* 103 */ self::YY_NO_ANCHOR,
    /* 104 */ self::YY_NO_ANCHOR,
    /* 105 */ self::YY_NO_ANCHOR,
    /* 106 */ self::YY_NO_ANCHOR,
    /* 107 */ self::YY_NO_ANCHOR,
    /* 108 */ self::YY_NO_ANCHOR,
    /* 109 */ self::YY_NO_ANCHOR,
    /* 110 */ self::YY_NO_ANCHOR,
    /* 111 */ self::YY_NO_ANCHOR,
    /* 112 */ self::YY_NO_ANCHOR,
    /* 113 */ self::YY_NO_ANCHOR,
    /* 114 */ self::YY_NO_ANCHOR,
    /* 115 */ self::YY_NO_ANCHOR,
    /* 116 */ self::YY_NO_ANCHOR,
    /* 117 */ self::YY_NO_ANCHOR,
    /* 118 */ self::YY_NO_ANCHOR,
    /* 119 */ self::YY_NO_ANCHOR,
    /* 120 */ self::YY_NO_ANCHOR,
    /* 121 */ self::YY_NO_ANCHOR,
    /* 122 */ self::YY_NO_ANCHOR,
    /* 123 */ self::YY_NO_ANCHOR,
    /* 124 */ self::YY_NO_ANCHOR,
    /* 125 */ self::YY_NO_ANCHOR,
    /* 126 */ self::YY_NO_ANCHOR,
    /* 127 */ self::YY_NO_ANCHOR
  );
    static $yy_cmap = array(
 41, 41, 41, 41, 41, 41, 41, 41, 41, 3, 1, 41, 3, 2, 41, 41, 41, 41, 41, 41,
 41, 41, 41, 41, 41, 41, 41, 41, 41, 41, 41, 41, 3, 41, 29, 34, 36, 41, 41, 30,
 41, 41, 32, 26, 41, 26, 25, 31, 27, 24, 24, 24, 24, 24, 24, 24, 24, 24, 41, 41,
 4, 41, 8, 5, 39, 12, 13, 16, 22, 11, 17, 37, 7, 18, 37, 37, 20, 23, 19, 37,
 6, 37, 15, 10, 14, 9, 37, 37, 21, 37, 37, 35, 42, 40, 41, 37, 41, 12, 13, 16,
 22, 11, 17, 37, 7, 18, 37, 37, 20, 23, 19, 37, 6, 37, 15, 10, 14, 9, 37, 37,
 21, 37, 37, 28, 33, 38, 41, 41, 41, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 0, 0,);

    static $yy_rmap = array(
 0, 1, 2, 3, 4, 5, 1, 1, 1, 1, 6, 7, 1, 8, 1, 4, 1, 4, 4, 4,
 4, 4, 4, 9, 1, 1, 1, 1, 1, 1, 1, 1, 1, 10, 1, 1, 1, 1, 11, 12,
 13, 14, 1, 1, 15, 16, 17, 18, 19, 1, 20, 21, 22, 23, 1, 24, 25, 26, 27, 28,
 29, 30, 31, 32, 33, 34, 27, 35, 36, 37, 38, 30, 32, 39, 40, 41, 42, 43, 44, 45,
 46, 47, 48, 49, 50, 51, 52, 20, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64,
 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84,
 85, 86, 87, 88, 89, 90, 91, 92,);

    static $yy_nxt = array(
array(
 1, 2, 2, 2, 3, 46, 4, 4, 54, 102, 4, 119, 123, 4, 4, 4, 109, 110, 126, 4,
 4, 4, 4, 4, 5, 59, 54, 48, 6, 7, 8, 64, 54, 54, 69, 54, 72, 4, 54, 54,
 54, 54, 54,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, 2, 2, 2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, 45, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 53, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, 5, 56, -1, 5, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10,
 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10,
 10, 10, 10,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 14, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 13, 13, -1, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13,
 13, 13, 13, 13, 13, -1, -1, 13, -1, -1, -1, -1, -1, -1, -1, -1, -1, 13, -1, -1,
 -1, -1, -1,
),
array(
 -1, 23, 23, 23, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, 50, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 34, -1, -1, -1, -1, -1, -1, -1, 32,
 -1, -1, -1,
),
array(
 1, -1, -1, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51,
 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 54, 51, 51, 51, 51, 51, 51,
 51, 51, 51,
),
array(
 1, -1, -1, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52,
 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52,
 52, 52, 52,
),
array(
 -1, -1, -1, 40, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 41, 41, -1, 41, 41, 41, 41, 41, 41, 41, 41, 41, 41, 41,
 41, 41, 41, 41, 41, -1, -1, 41, -1, -1, -1, -1, -1, -1, -1, -1, -1, 41, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 44, 44, -1, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44,
 44, 44, 44, 44, 44, -1, -1, 44, -1, -1, -1, -1, -1, -1, -1, -1, -1, 44, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 68, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, 9, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 15, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 53, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 58, -1, -1, 5, 56, -1, 5, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, 87, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 32,
 -1, -1, -1,
),
array(
 -1, -1, -1, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51,
 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, -1, 51, 51, 51, 51, 51, 51,
 51, 51, 51,
),
array(
 -1, -1, -1, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52,
 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52,
 52, 52, 52,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, 61, -1, 71, 61, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 17, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 53, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, 56, -1, -1, 56, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 24, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 66, 66, 66, -1, -1, 66, 66, -1, -1,
 -1, -1, 66, -1, 66, -1, -1, 66, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, 56, -1, -1, 56, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 18, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, 61, -1, -1, 61, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 29, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 13, 13, -1, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13,
 13, 13, 13, 13, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 63, 13, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 10, 11, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 19, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, 31, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, 74, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 12, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 20, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 21, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 16, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 25, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 22, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 1, 23, 23, 23, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49,
 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 57, 49, 49, 49, 49, 49, 49, 49,
 49, 49, 49,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 37, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 1, -1, -1, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54,
 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 75, 54, 54, 54, 54, 54, 54, 54,
 54, 54, 54,
),
array(
 -1, -1, -1, -1, -1, -1, 44, 44, -1, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44,
 44, 44, 44, 44, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 44, -1, -1,
 -1, -1, -1,
),
array(
 1, 23, 23, 23, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49,
 49, 49, 49, 49, 49, 49, 49, 49, 26, 49, 49, 49, 49, 49, 49, 49, 49, 49, 27, 49,
 49, 49, 49,
),
array(
 1, 23, 23, 23, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49,
 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 28, 49, 49, 49, 49, 49, 49, 49, 49, 49,
 49, 49, 62,
),
array(
 1, 23, 23, 23, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49,
 49, 49, 49, 49, 49, 49, 49, 49, 49, 30, 49, 49, 49, 49, 49, 49, 49, 49, 49, 49,
 49, 49, 67,
),
array(
 1, 85, 32, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54,
 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54,
 54, 54, 54,
),
array(
 -1, -1, 32, 86, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, 86, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 33, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 1, 89, 35, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54,
 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54,
 54, 54, 54,
),
array(
 -1, -1, 35, 90, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, 90, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 91, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, 92, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 36, -1, -1, -1, -1, -1, -1, -1, 35,
 -1, -1, -1,
),
array(
 -1, -1, -1, 92, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 35,
 -1, -1, -1,
),
array(
 1, -1, -1, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54,
 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 54, 78, 54, 54, 54, 54, 54, 54, 54,
 54, 54, 54,
),
array(
 1, -1, -1, 40, 54, 54, 41, 41, 54, 41, 41, 41, 41, 41, 41, 41, 41, 41, 41, 41,
 41, 41, 41, 41, 54, 54, 54, 54, 54, 54, 42, 54, 54, 54, 54, 54, 54, 41, 54, 80,
 43, 54, 54,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 47, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 55, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 60, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 65, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 70, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 73, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 76, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 95, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 96, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 97,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 98,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 99, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 100, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 101,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 103, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 104, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 105, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 106, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 107, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 108, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 111, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 112, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 113, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 114, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 115, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 116, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 117, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 118, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 120, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 121, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 122, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 4, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 124,
 4, 4, 4, 127, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
 -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, 125, 4, -1, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
 4, 4, 4, 4, 4, -1, -1, 4, -1, -1, -1, -1, -1, -1, -1, -1, -1, 4, -1, -1,
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
              { }
            case -3:
              break;
            case 3:
              {  return $this->createToken(ord($this->yytext())); }
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
              { $this->pushState(self::S_INNERBLOCK); $this->cnt= 0; return $this->createToken(ord($this->yytext())); }
            case -7:
              break;
            case 7:
              { $this->pushState(self::S_ENCAPSED_D); $this->addBuffer($this->yytext()); }
            case -8:
              break;
            case 8:
              { $this->pushState(self::S_ENCAPSED_S); $this->addBuffer($this->yytext()); }
            case -9:
              break;
            case 9:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_TAG); }
            case -10:
              break;
            case 10:
              {}
            case -11:
              break;
            case 11:
              { $this->pushState(self::S_BLOCKCOMMENT); return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_BCOMMENT); }
            case -12:
              break;
            case 12:
              { $this->pushState(self::S_ANNOTATION); return $this->createToken(xp·ide·source·parser·ClassFileParser::T_START_ANNOTATION); }
            case -13:
              break;
            case 13:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_VARIABLE); }
            case -14:
              break;
            case 14:
              { $this->pushState(self::S_APIDOC); return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_APIDOC); }
            case -15:
              break;
            case 15:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_USES); }
            case -16:
              break;
            case 16:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_TAG); }
            case -17:
              break;
            case 17:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLASS); }
            case -18:
              break;
            case 18:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_FINAL); }
            case -19:
              break;
            case 19:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_EXTENDS); }
            case -20:
              break;
            case 20:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_ABSTRACT); }
            case -21:
              break;
            case 21:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_INTERFACE); }
            case -22:
              break;
            case 22:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_IMPLEMENTS); }
            case -23:
              break;
            case 23:
              {  $this->addBuffer($this->yytext()); }
            case -24:
              break;
            case 24:
              {
  $this->yypushback(2);
  $this->yybegin(self::S_BLOCKCOMMENT_END);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_BCOMMENT, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -25:
              break;
            case 25:
              {
  $this->popState();
  return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_BCOMMENT);
}
            case -26:
              break;
            case 26:
              { $this->addBuffer($this->yytext()); $this->cnt++; }
            case -27:
              break;
            case 27:
              {
  if (--$this->cnt < 0) {
  $this->yypushback(1);
    $this->popState();
    $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_INNERBLOCK, $this->getBuffer());
    $this->resetBuffer();
    return;
  } else {
    $this->addBuffer($this->yytext());
  }
}
            case -28:
              break;
            case 28:
              {
  $this->popState();
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -29:
              break;
            case 29:
              { $this->addBuffer($this->yytext()); }
            case -30:
              break;
            case 30:
              {
  $this->popState();
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -31:
              break;
            case 31:
              { $this->addBuffer($this->yytext()); }
            case -32:
              break;
            case 32:
              {
  $this->yypushback($this->yylength());
  $this->yybegin(self::S_APIDOC_DIRECTIVE);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_APIDOC, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -33:
              break;
            case 33:
              {
  $this->addBuffer(PHP_EOL);
  $this->yybegin(self::S_APIDOC_TEXT);
}
            case -34:
              break;
            case 34:
              {
  $this->yypushback(2);
  $this->yybegin(self::S_APIDOC_END);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_APIDOC, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -35:
              break;
            case 35:
              {
  $this->yybegin(self::S_APIDOC_DIRECTIVE_TEXT);
  $this->yypushback(1);
}
            case -36:
              break;
            case 36:
              {
  $this->yypushback(2);
  $this->yybegin(self::S_APIDOC_END);
}
            case -37:
              break;
            case 37:
              {
  $this->popState(self::YYINITIAL);
  return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_APIDOC);
}
            case -38:
              break;
            case 38:
              {
  $this->addBuffer($this->yytext());
  $this->yybegin(self::S_APIDOC);
}
            case -39:
              break;
            case 39:
              {
  $this->yybegin(self::S_APIDOC_DIRECTIVE);
  return $this->createToken(xp·ide·source·parser·ClassFileParser::T_DIRECTIVE_APIDOC, $this->yytext());
}
            case -40:
              break;
            case 40:
              {}
            case -41:
              break;
            case 41:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -42:
              break;
            case 42:
              { $this->pushState(self::S_ENCAPSED_S); $this->addBuffer($this->yytext()); }
            case -43:
              break;
            case 43:
              {
  $this->popState();
  return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_ANNOTATION);
}
            case -44:
              break;
            case 44:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_ANNOTATION); }
            case -45:
              break;
            case 46:
              {  return $this->createToken(ord($this->yytext())); }
            case -46:
              break;
            case 47:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -47:
              break;
            case 48:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -48:
              break;
            case 49:
              {  $this->addBuffer($this->yytext()); }
            case -49:
              break;
            case 50:
              {
  $this->addBuffer(PHP_EOL);
  $this->yybegin(self::S_APIDOC_TEXT);
}
            case -50:
              break;
            case 51:
              {
  $this->addBuffer($this->yytext());
  $this->yybegin(self::S_APIDOC);
}
            case -51:
              break;
            case 52:
              {
  $this->yybegin(self::S_APIDOC_DIRECTIVE);
  return $this->createToken(xp·ide·source·parser·ClassFileParser::T_DIRECTIVE_APIDOC, $this->yytext());
}
            case -52:
              break;
            case 54:
              {  return $this->createToken(ord($this->yytext())); }
            case -53:
              break;
            case 55:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -54:
              break;
            case 56:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -55:
              break;
            case 57:
              {  $this->addBuffer($this->yytext()); }
            case -56:
              break;
            case 59:
              {  return $this->createToken(ord($this->yytext())); }
            case -57:
              break;
            case 60:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -58:
              break;
            case 61:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -59:
              break;
            case 62:
              {  $this->addBuffer($this->yytext()); }
            case -60:
              break;
            case 64:
              {  return $this->createToken(ord($this->yytext())); }
            case -61:
              break;
            case 65:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -62:
              break;
            case 66:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
            case -63:
              break;
            case 67:
              {  $this->addBuffer($this->yytext()); }
            case -64:
              break;
            case 69:
              {  return $this->createToken(ord($this->yytext())); }
            case -65:
              break;
            case 70:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -66:
              break;
            case 72:
              {  return $this->createToken(ord($this->yytext())); }
            case -67:
              break;
            case 73:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -68:
              break;
            case 75:
              {  return $this->createToken(ord($this->yytext())); }
            case -69:
              break;
            case 76:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -70:
              break;
            case 78:
              {  return $this->createToken(ord($this->yytext())); }
            case -71:
              break;
            case 80:
              {  return $this->createToken(ord($this->yytext())); }
            case -72:
              break;
            case 95:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -73:
              break;
            case 96:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -74:
              break;
            case 97:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -75:
              break;
            case 98:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -76:
              break;
            case 99:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -77:
              break;
            case 100:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -78:
              break;
            case 101:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -79:
              break;
            case 102:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -80:
              break;
            case 103:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -81:
              break;
            case 104:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -82:
              break;
            case 105:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -83:
              break;
            case 106:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -84:
              break;
            case 107:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -85:
              break;
            case 108:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -86:
              break;
            case 109:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -87:
              break;
            case 110:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -88:
              break;
            case 111:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -89:
              break;
            case 112:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -90:
              break;
            case 113:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -91:
              break;
            case 114:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -92:
              break;
            case 115:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -93:
              break;
            case 116:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -94:
              break;
            case 117:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -95:
              break;
            case 118:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -96:
              break;
            case 119:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -97:
              break;
            case 120:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -98:
              break;
            case 121:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -99:
              break;
            case 122:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -100:
              break;
            case 123:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -101:
              break;
            case 124:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -102:
              break;
            case 125:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -103:
              break;
            case 126:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -104:
              break;
            case 127:
              { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
            case -105:
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
