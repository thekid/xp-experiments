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

  const S_METHOD_CONTENT = 3;
  const S_APIDOC_END = 6;
  const S_ENCAPSED_S = 1;
  const S_APIDOC_DIRECTIVE_TEXT = 8;
  const YYINITIAL = 0;
  const S_APIDOC_TEXT = 7;
  const S_APIDOC = 4;
  const S_ENCAPSED_D = 2;
  const S_ANNOTATION = 9;
  const S_APIDOC_DIRECTIVE = 5;
  static $yy_state_dtrans = array(
    0,
    72,
    74,
    76,
    78,
    85,
    90,
    39,
    40,
    92
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
    /* 45 */ self::YY_NO_ANCHOR,
    /* 46 */ self::YY_NOT_ACCEPT,
    /* 47 */ self::YY_NO_ANCHOR,
    /* 48 */ self::YY_NO_ANCHOR,
    /* 49 */ self::YY_NO_ANCHOR,
    /* 50 */ self::YY_NO_ANCHOR,
    /* 51 */ self::YY_NO_ANCHOR,
    /* 52 */ self::YY_NO_ANCHOR,
    /* 53 */ self::YY_NO_ANCHOR,
    /* 54 */ self::YY_NOT_ACCEPT,
    /* 55 */ self::YY_NO_ANCHOR,
    /* 56 */ self::YY_NO_ANCHOR,
    /* 57 */ self::YY_NO_ANCHOR,
    /* 58 */ self::YY_NO_ANCHOR,
    /* 59 */ self::YY_NOT_ACCEPT,
    /* 60 */ self::YY_NO_ANCHOR,
    /* 61 */ self::YY_NO_ANCHOR,
    /* 62 */ self::YY_NO_ANCHOR,
    /* 63 */ self::YY_NO_ANCHOR,
    /* 64 */ self::YY_NOT_ACCEPT,
    /* 65 */ self::YY_NO_ANCHOR,
    /* 66 */ self::YY_NO_ANCHOR,
    /* 67 */ self::YY_NO_ANCHOR,
    /* 68 */ self::YY_NOT_ACCEPT,
    /* 69 */ self::YY_NO_ANCHOR,
    /* 70 */ self::YY_NOT_ACCEPT,
    /* 71 */ self::YY_NO_ANCHOR,
    /* 72 */ self::YY_NOT_ACCEPT,
    /* 73 */ self::YY_NO_ANCHOR,
    /* 74 */ self::YY_NOT_ACCEPT,
    /* 75 */ self::YY_NO_ANCHOR,
    /* 76 */ self::YY_NOT_ACCEPT,
    /* 77 */ self::YY_NO_ANCHOR,
    /* 78 */ self::YY_NOT_ACCEPT,
    /* 79 */ self::YY_NO_ANCHOR,
    /* 80 */ self::YY_NOT_ACCEPT,
    /* 81 */ self::YY_NO_ANCHOR,
    /* 82 */ self::YY_NOT_ACCEPT,
    /* 83 */ self::YY_NO_ANCHOR,
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
    /* 94 */ self::YY_NO_ANCHOR,
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
    /* 127 */ self::YY_NO_ANCHOR,
    /* 128 */ self::YY_NO_ANCHOR,
    /* 129 */ self::YY_NO_ANCHOR,
    /* 130 */ self::YY_NO_ANCHOR,
    /* 131 */ self::YY_NO_ANCHOR,
    /* 132 */ self::YY_NO_ANCHOR,
    /* 133 */ self::YY_NO_ANCHOR,
    /* 134 */ self::YY_NO_ANCHOR
  );
    static $yy_cmap = array(
 23, 23, 23, 23, 23, 23, 23, 23, 23, 3, 1, 23, 3, 2, 23, 23, 23, 23, 23, 23,
 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 3, 43, 34, 24, 36, 43, 43, 35,
 43, 43, 22, 40, 43, 30, 29, 21, 31, 28, 28, 28, 28, 28, 28, 28, 28, 28, 43, 43,
 43, 26, 27, 43, 41, 12, 18, 7, 17, 16, 20, 37, 37, 15, 37, 37, 6, 37, 4, 8,
 14, 37, 13, 9, 10, 5, 11, 37, 32, 19, 37, 25, 44, 42, 43, 37, 23, 12, 18, 7,
 17, 16, 20, 37, 37, 15, 37, 37, 6, 37, 4, 8, 14, 37, 13, 9, 10, 5, 11, 37,
 32, 19, 37, 33, 39, 38, 43, 23, 23, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 0, 0,);

    static $yy_rmap = array(
 0, 1, 2, 3, 4, 5, 1, 1, 1, 6, 1, 1, 7, 8, 1, 8, 8, 8, 8, 8,
 8, 8, 8, 8, 8, 8, 9, 1, 1, 1, 1, 1, 1, 1, 10, 1, 1, 1, 1, 11,
 12, 13, 14, 1, 1, 15, 16, 17, 1, 18, 1, 19, 20, 21, 22, 23, 24, 25, 26, 27,
 28, 29, 30, 31, 32, 33, 34, 32, 34, 35, 30, 36, 37, 38, 39, 40, 41, 42, 43, 44,
 45, 46, 47, 48, 19, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63,
 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83,
 84, 85, 86, 8, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97,);

    static $yy_nxt = array(
array(
 1, 2, 2, 2, 3, 123, 123, 128, 123, 130, 131, 94, 132, 123, 133, 123, 123, 123, 123, 123,
 134, 4, -1, -1, 46, 48, 56, 48, 5, 61, -1, 49, 123, 6, 7, 8, 66, 123, 48, 48,
 48, 48, 48, 48, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, 2, 2, 2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 95, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 9, 54, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 59, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, 5, 57, -1, 5, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9,
 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9,
 9, 9, 9, 9, 9,
),
array(
 -1, -1, -1, -1, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12,
 12, -1, -1, -1, -1, -1, -1, -1, 12, -1, -1, 12, 12, -1, -1, -1, -1, 12, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, 26, 26, 26, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, 51, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 35, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 33, -1, -1, -1,
),
array(
 1, -1, -1, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52,
 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, -1,
 52, 52, 52, 52, 52,
),
array(
 1, -1, -1, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53,
 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53,
 53, 53, 53, 53, 53,
),
array(
 -1, -1, -1, 41, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42,
 42, -1, -1, -1, -1, -1, -1, -1, 42, -1, -1, 42, 42, -1, -1, -1, -1, 42, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45,
 45, -1, -1, -1, -1, -1, -1, -1, 45, -1, -1, 45, 45, -1, -1, -1, -1, 45, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, 10, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 13, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 59, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, 5, 57, -1, 5, 64, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, 84, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 33, -1, -1, -1,
),
array(
 -1, -1, -1, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52,
 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, -1,
 52, 52, 52, 52, 52,
),
array(
 -1, -1, -1, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53,
 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53, 53,
 53, 53, 53, 53, 53,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, 14, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 15, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, 11, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 59, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, 57, -1, -1, 57, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 28, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, 70, 62, -1, -1, -1, -1, -1, -1, -1, -1,
 70, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 16, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, 57, -1, -1, 57, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, 62, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 30, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, 67, -1, -1, -1, -1, 67, -1, -1, -1, 67, 67, 67, -1,
 67, -1, -1, -1, -1, -1, -1, -1, 67, -1, -1, 67, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 17, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12,
 12, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 12, -1, -1, -1, 68, 12, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 18,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 19, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 1, 26, 26, 26, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50,
 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 27, 50, 50, 50, 50,
 50, 50, 50, 50, 58,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 20, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 1, 26, 26, 26, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50,
 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 29, 50, 50, 50, 50, 50,
 50, 50, 50, 50, 63,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 21, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 1, 26, 26, 26, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50,
 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 31, 50, 50, 50, 50, 32, 50,
 50, 50, 50, 50, 50,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 22, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 1, 80, 33, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 23, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, 33, 82, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 24, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, 82, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, 34, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 25, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 1, 86, 36, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, 36, 87, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, 87, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, 88, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, 89, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 37, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 36, -1, -1, -1,
),
array(
 -1, -1, -1, 89, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 36, -1, -1, -1,
),
array(
 1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, 91, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, 38, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 1, -1, -1, 41, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42,
 42, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 42, -1, -1, 43, -1, 42, -1, -1,
 -1, 93, 44, -1, -1,
),
array(
 -1, -1, -1, -1, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45,
 45, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 45, -1, -1, -1, -1, 45, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 47, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 55, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 104, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 105, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 60, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 106, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 126, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 125, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 129, 123, 123, 123, 123, 123, 123, 107, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 109, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 65, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 110, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 69, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 114, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 115, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 71, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 73, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 127, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 75, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 116, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 117, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 118, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 120, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 77, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 121, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 79, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 122, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 81, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 83, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 108, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 112, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 111, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 119, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 96, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 113, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 97, 123, 123, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 98, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 123, 123, 123, 123, 123, 123, 123, 123, 99, 123, 123, 123, 123, 100, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 101, 123, 123, 123, 123, 123, 123, 123, 102, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
),
array(
 -1, -1, -1, -1, 123, 124, 123, 123, 123, 123, 123, 123, 103, 123, 123, 123, 123, 123, 123, 123,
 123, -1, -1, -1, -1, -1, -1, -1, 123, -1, -1, 123, 123, -1, -1, -1, -1, 123, -1, -1,
 -1, -1, -1, -1, -1,
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
              { $this->pushState(self::S_METHOD_CONTENT); $this->cnt= 0; return $this->createToken(ord($this->yytext())); }
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
              {}
            case -10:
              break;
            case 10:
              { $this->pushState(self::S_ANNOTATION); return $this->createToken(xp·ide·source·parser·ClassParser::T_START_ANNOTATION); }
            case -11:
              break;
            case 11:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_DOUBLE_ARROW); }
            case -12:
              break;
            case 12:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_VARIABLE); }
            case -13:
              break;
            case 13:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_VAR); }
            case -14:
              break;
            case 14:
              { $this->pushState(self::S_APIDOC); return $this->createToken(xp·ide·source·parser·ClassParser::T_OPEN_APIDOC); }
            case -15:
              break;
            case 15:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NULL); }
            case -16:
              break;
            case 16:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_BOOLEAN); }
            case -17:
              break;
            case 17:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_CONST); }
            case -18:
              break;
            case 18:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_ARRAY); }
            case -19:
              break;
            case 19:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_BOOLEAN); }
            case -20:
              break;
            case 20:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STATIC); }
            case -21:
              break;
            case 21:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_PUBLIC); }
            case -22:
              break;
            case 22:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_PRIVATE); }
            case -23:
              break;
            case 23:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_ABSTRACT); }
            case -24:
              break;
            case 24:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_FUNCTION); }
            case -25:
              break;
            case 25:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_PROTECTED); }
            case -26:
              break;
            case 26:
              {  $this->addBuffer($this->yytext()); }
            case -27:
              break;
            case 27:
              {
  $this->popState();
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassParser::T_ENCAPSED_STRING, $this->getBuffer());
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
              {
  $this->popState();
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -30:
              break;
            case 30:
              { $this->addBuffer($this->yytext()); }
            case -31:
              break;
            case 31:
              { $this->addBuffer($this->yytext()); $this->cnt++; }
            case -32:
              break;
            case 32:
              {
  if (--$this->cnt < 0) {
    $this->yy_buffer_index--;
    $this->popState();
    $this->createToken(xp·ide·source·parser·ClassParser::T_FUNCTION_BODY, $this->getBuffer());
    $this->resetBuffer();
    return;
  } else {
    $this->addBuffer($this->yytext());
  }
}
            case -33:
              break;
            case 33:
              {
  $this->yypushback($this->yylength());
  $this->yybegin(self::S_APIDOC_DIRECTIVE);
  $this->createToken(xp·ide·source·parser·ClassParser::T_CONTENT_APIDOC, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -34:
              break;
            case 34:
              {
  $this->addBuffer(PHP_EOL);
  $this->yybegin(self::S_APIDOC_TEXT);
}
            case -35:
              break;
            case 35:
              {
  $this->yypushback(2);
  $this->yybegin(self::S_APIDOC_END);
  $this->createToken(xp·ide·source·parser·ClassParser::T_CONTENT_APIDOC, $this->getBuffer());
  $this->resetBuffer();
  return;
}
            case -36:
              break;
            case 36:
              {
  $this->yybegin(self::S_APIDOC_DIRECTIVE_TEXT);
  $this->yypushback(1);
}
            case -37:
              break;
            case 37:
              {
  $this->yypushback(2);
  $this->yybegin(self::S_APIDOC_END);
}
            case -38:
              break;
            case 38:
              {
  $this->popState(self::YYINITIAL);
  return $this->createToken(xp·ide·source·parser·ClassParser::T_CLOSE_APIDOC);
}
            case -39:
              break;
            case 39:
              {
  $this->addBuffer($this->yytext());
  $this->yybegin(self::S_APIDOC);
}
            case -40:
              break;
            case 40:
              {
  $this->yybegin(self::S_APIDOC_DIRECTIVE);
  return $this->createToken(xp·ide·source·parser·ClassParser::T_DIRECTIVE_APIDOC, $this->yytext());
}
            case -41:
              break;
            case 41:
              {}
            case -42:
              break;
            case 42:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -43:
              break;
            case 43:
              { $this->pushState(self::S_ENCAPSED_S); $this->addBuffer($this->yytext()); }
            case -44:
              break;
            case 44:
              {
  $this->popState();
  return $this->createToken(xp·ide·source·parser·ClassParser::T_CLOSE_ANNOTATION);
}
            case -45:
              break;
            case 45:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_ANNOTATION); }
            case -46:
              break;
            case 47:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -47:
              break;
            case 48:
              { return $this->createToken(ord($this->yytext())); }
            case -48:
              break;
            case 49:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -49:
              break;
            case 50:
              {  $this->addBuffer($this->yytext()); }
            case -50:
              break;
            case 51:
              {
  $this->addBuffer(PHP_EOL);
  $this->yybegin(self::S_APIDOC_TEXT);
}
            case -51:
              break;
            case 52:
              {
  $this->addBuffer($this->yytext());
  $this->yybegin(self::S_APIDOC);
}
            case -52:
              break;
            case 53:
              {
  $this->yybegin(self::S_APIDOC_DIRECTIVE);
  return $this->createToken(xp·ide·source·parser·ClassParser::T_DIRECTIVE_APIDOC, $this->yytext());
}
            case -53:
              break;
            case 55:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -54:
              break;
            case 56:
              { return $this->createToken(ord($this->yytext())); }
            case -55:
              break;
            case 57:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -56:
              break;
            case 58:
              {  $this->addBuffer($this->yytext()); }
            case -57:
              break;
            case 60:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -58:
              break;
            case 61:
              { return $this->createToken(ord($this->yytext())); }
            case -59:
              break;
            case 62:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -60:
              break;
            case 63:
              {  $this->addBuffer($this->yytext()); }
            case -61:
              break;
            case 65:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -62:
              break;
            case 66:
              { return $this->createToken(ord($this->yytext())); }
            case -63:
              break;
            case 67:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
            case -64:
              break;
            case 69:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -65:
              break;
            case 71:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -66:
              break;
            case 73:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -67:
              break;
            case 75:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -68:
              break;
            case 77:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -69:
              break;
            case 79:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -70:
              break;
            case 81:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -71:
              break;
            case 83:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -72:
              break;
            case 94:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -73:
              break;
            case 95:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -74:
              break;
            case 96:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -75:
              break;
            case 97:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -76:
              break;
            case 98:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -77:
              break;
            case 99:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -78:
              break;
            case 100:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -79:
              break;
            case 101:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -80:
              break;
            case 102:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -81:
              break;
            case 103:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -82:
              break;
            case 104:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -83:
              break;
            case 105:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -84:
              break;
            case 106:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -85:
              break;
            case 107:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -86:
              break;
            case 108:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -87:
              break;
            case 109:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -88:
              break;
            case 110:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -89:
              break;
            case 111:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -90:
              break;
            case 112:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -91:
              break;
            case 113:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -92:
              break;
            case 114:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -93:
              break;
            case 115:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -94:
              break;
            case 116:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -95:
              break;
            case 117:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -96:
              break;
            case 118:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -97:
              break;
            case 119:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -98:
              break;
            case 120:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -99:
              break;
            case 121:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -100:
              break;
            case 122:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -101:
              break;
            case 123:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -102:
              break;
            case 124:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -103:
              break;
            case 125:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -104:
              break;
            case 126:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -105:
              break;
            case 127:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -106:
              break;
            case 128:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -107:
              break;
            case 129:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -108:
              break;
            case 130:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -109:
              break;
            case 131:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -110:
              break;
            case 132:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -111:
              break;
            case 133:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -112:
              break;
            case 134:
              { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }
            case -113:
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
