<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  
#line 2 "./grammar/php52.jay"

  $package= 'xp.ide.source.parser';

  uses(
    'xp.ide.source.parser.ParserHelper',
    'xp.ide.source.Scope',
    'xp.ide.source.element.Package',
    'xp.ide.source.element.Uses',
    'xp.ide.source.element.Classdef',
    'xp.ide.source.element.Classmember',
    'xp.ide.source.element.Classconstant',
    'xp.ide.source.element.ClassFile',
    'xp.ide.source.element.BlockComment'
  );

#line 25 "-"

  uses('text.parser.generic.AbstractParser');

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class xp·ide·source·parser·Php52Parser extends AbstractParser {
    const T_CLASS= 257;
    const T_CLOSE_BCOMMENT= 258;
    const T_CLOSE_TAG= 259;
    const T_CONTENT_BCOMMENT= 260;
    const T_ENCAPSED_STRING= 261;
    const T_EXTENDS= 262;
    const T_IMPLEMENTS= 263;
    const T_NUMBER= 264;
    const T_OPEN_BCOMMENT= 265;
    const T_OPEN_TAG= 266;
    const T_STRING= 267;
    const T_USES= 268;
    const T_VARIABLE= 269;
    const T_ARRAY= 270;
    const T_NULL= 271;
    const T_PUBLIC= 272;
    const T_PRIVATE= 273;
    const T_PROTECTED= 274;
    const T_CONST= 275;
    const T_STATIC= 276;
    const T_OPEN_INNERBLOCK= 277;
    const T_CONTENT_INNERBLOCK= 278;
    const T_CLOSE_INNERBLOCK= 279;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     2,     2,     5,     5,     4,     4,     4,     4, 
          6,     6,     8,     8,     7,     7,    11,    11,    12,    12, 
          1,     1,     1,     1,     1,     1,     1,    13,    14,    15, 
         15,     3,    10,    10,    10,    10,    10,    16,    16,    16, 
          9,     9,     9,     9, 
    );
    protected static $yyLen= array(2,
          4,     3,     6,     8,     3,     1,     4,     3,     3,     2, 
          4,     3,     5,     3,     4,     3,     3,     1,     3,     1, 
          3,     2,     2,     2,     1,     1,     1,     4,     5,     3, 
          1,     3,     2,     2,     1,     1,     0,     1,     1,     1, 
          3,     1,     1,     1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     0,     0,     0,     0,     0,     0,    27, 
          0,     0,     0,     0,     0,     2,     0,     0,    23,    24, 
         32,    31,     0,     0,     1,     0,    21,     0,     0,    28, 
          0,    30,    29,     0,     0,     0,     3,     6,     0,    38, 
         39,    40,     0,     0,    10,     0,     0,     0,     0,     0, 
          4,     0,     0,    34,     0,     8,     0,     9,     0,     0, 
          0,    18,    33,     5,     0,     0,    12,     0,     7,     0, 
          0,     0,    16,    44,    42,     0,    43,    14,     0,    11, 
         15,    19,    17,     0,     0,    41,    13, 
    );
    protected static $yyDgoto= array(2,
          6,     7,     8,    37,    39,    46,    47,    53,    78,    48, 
         61,    62,     9,    10,    23,    49, 
    );
    protected static $yySindex = array(         -240,
       -256,     0,  -228,    -7,   -26,  -229,  -216,  -241,  -224,     0, 
       -213,  -215,  -214,  -211,  -208,     0,  -217,  -224,     0,     0, 
          0,     0,   -24,    -8,     0,  -210,     0,  -207,    -6,     0, 
       -212,     0,     0,  -122,  -209,  -125,     0,     0,   -42,     0, 
          0,     0,  -206,  -232,     0,  -120,  -115,  -205,  -220,  -204, 
          0,    -4,   -41,     0,  -206,     0,  -110,     0,  -205,    -2, 
        -40,     0,     0,     0,  -233,  -202,     0,   -38,     0,   -37, 
       -233,  -205,     0,     0,     0,    20,     0,     0,     1,     0, 
          0,     0,     0,    25,  -233,     0,     0, 
    );
    protected static $yyRindex= array(            0,
          0,     0,     0,     0,     0,     0,     0,  -198,  -197,     0, 
          0,     0,     0,     0,     0,     0,     0,  -196,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,  -199,     0,     0,     0,     0, 
          0,     0,     0,  -195,     0,  -199,  -199,     0,  -194,     0, 
          0,     0,     0,     0,     0,     0,  -199,     0,     0,   -36, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,    65,    66,    34,     0,     0,    30,    22,   -60,   -33, 
         19,     7,    72,    21,     0,    38, 
    );
    protected static $yyTable = array(45,
         36,    50,    66,    72,    56,    66,    72,    20,     3,    58, 
         82,     4,     5,    59,    69,    17,    29,    67,    73,    28, 
         80,    81,    20,    59,    87,     1,     4,     5,    19,    20, 
         74,    11,    12,    75,    13,     3,    76,    77,    27,    40, 
         41,    42,    16,     4,    21,    22,    24,    25,    17,    26, 
         30,    31,    33,    32,    34,    63,    65,    38,    71,    84, 
         52,    85,    64,    60,    79,    86,    25,    26,    22,    37, 
         14,    15,    51,    35,    36,    57,    68,    70,    83,    18, 
         36,    54,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
         35,     0,     0,     0,     0,     0,    40,    41,    42,    43, 
         44,    40,    41,    42,    55,    44,    40,    41,    42,     0, 
         44,    40,    41,    42,     0,    44, 
    );
    protected static $yyCheck = array(125,
        123,    44,    44,    44,   125,    44,    44,    44,   265,   125, 
         71,   268,   269,    47,   125,   257,    41,    59,    59,    44, 
         59,    59,    59,    57,    85,   266,   268,   269,     8,     9, 
        264,   260,    40,   267,    61,   265,   270,   271,    18,   272, 
        273,   274,   259,   268,   258,   261,   261,   259,   257,   267, 
         59,   262,    59,   261,   267,   276,    61,   267,    61,    40, 
        267,    61,   267,   269,   267,    41,   265,   265,   265,   269, 
          6,     6,    39,   269,   269,    46,    55,    59,    72,     8, 
        123,    44,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
        263,    -1,    -1,    -1,    -1,    -1,   272,   273,   274,   275, 
        276,   272,   273,   274,   275,   276,   272,   273,   274,    -1, 
        276,   272,   273,   274,    -1,   276, 
    );
    protected static $yyFinal= 2;
    protected static $yyName= array(    
      'end-of-file', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      "'('", "')'", NULL, NULL, "','", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, "';'", NULL, "'='", NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, "'{'", NULL, "'}'", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_CLASS', 
      'T_CLOSE_BCOMMENT', 'T_CLOSE_TAG', 'T_CONTENT_BCOMMENT', 
      'T_ENCAPSED_STRING', 'T_EXTENDS', 'T_IMPLEMENTS', 'T_NUMBER', 
      'T_OPEN_BCOMMENT', 'T_OPEN_TAG', 'T_STRING', 'T_USES', 'T_VARIABLE', 
      'T_ARRAY', 'T_NULL', 'T_PUBLIC', 'T_PRIVATE', 'T_PROTECTED', 'T_CONST', 
      'T_STATIC', 'T_OPEN_INNERBLOCK', 'T_CONTENT_INNERBLOCK', 
      'T_CLOSE_INNERBLOCK', 
    );

    protected static $yyTableCount= 0, $yyNameCount= 0;

    static function __static() {
      self::$yyTableCount= sizeof(self::$yyTable);
      self::$yyNameCount= sizeof(self::$yyName);
    }

    /**
     * Retrieves name of a given token
     *
     * @param   int token
     * @return  string name
     */
    protected function yyname($token) {
      return isset(self::$yyName[$token]) ? self::$yyName[$token] : '<unknown>';
    }

    /**
     * Helper method for yyexpecting
     *
     * @param   int n
     * @return  string[] list of token names.
     */
    protected function yysearchtab($n) {
      if (0 == $n) return array();

      for (
        $result= array(), $token= $n < 0 ? -$n : 0; 
        $token < self::$yyNameCount && $n+ $token < self::$yyTableCount; 
        $token++
      ) {
        if (@self::$yyCheck[$n+ $token] == $token && !isset($result[$token])) {
          $result[$token]= self::$yyName[$token];
        }
      }
      return array_filter(array_values($result));
    }

    /**
     * Computes list of expected tokens on error by tracing the tables.
     *
     * @param   int state for which to compute the list.
     * @return  string[] list of token names.
     */
    protected function yyexpecting($state) {
      return array_merge($this->yysearchtab(self::$yySindex[$state], self::$yyRindex[$state]));
    }

    /**
     * Parser main method. Maintains a state and a value stack, 
     * currently with fixed maximum size.
     *
     * @param   text.parser.generic.AbstractLexer lexer
.    * @return  mixed result of the last reduction, if any.
     */
    public function yyparse($yyLex) {
      $yyVal= NULL;
      $yyStates= $yyVals= array();
      $yyToken= -1;
      $yyState= $yyErrorFlag= 0;

      while (1) {
        for ($yyTop= 0; ; $yyTop++) {
          $yyStates[$yyTop]= $yyState;
          $yyVals[$yyTop]= $yyVal;

          for (;;) {
            if (($yyN= self::$yyDefRed[$yyState]) == 0) {

              // Check whether it's necessary to fetch the next token
              $yyToken < 0 && $yyToken= $yyLex->advance() ? $yyLex->token : 0;

              if (
                ($yyN= self::$yySindex[$yyState]) != 0 && 
                ($yyN+= $yyToken) >= 0 && 
                $yyN < self::$yyTableCount && 
                self::$yyCheck[$yyN] == $yyToken
              ) {
                $yyState= self::$yyTable[$yyN];       // shift to yyN
                $yyVal= $yyLex->value;
                $yyToken= -1;
                $yyErrorFlag > 0 && $yyErrorFlag--;
                continue 2;
              }
        
              if (
                ($yyN= self::$yyRindex[$yyState]) != 0 && 
                ($yyN+= $yyToken) >= 0 && 
                $yyN < self::$yyTableCount && 
                self::$yyCheck[$yyN] == $yyToken
              ) {
                $yyN= self::$yyTable[$yyN];           // reduce (yyN)
              } else {
                switch ($yyErrorFlag) {
                  case 0: return $this->error(
                    E_PARSE, 
                    sprintf(
                      'Syntax error at %s, line %d (offset %d): Unexpected %s',
                      $yyLex->fileName,
                      $yyLex->position[0],
                      $yyLex->position[1],
                      $this->yyName($yyToken)
                    ), 
                    $this->yyExpecting($yyState)
                  );
                  
                  case 1: case 2: {
                    $yyErrorFlag= 3;
                    do { 
                      if (
                        ($yyN= @self::$yySindex[$yyStates[$yyTop]]) != 0 && 
                        ($yyN+= TOKEN_YY_ERRORCODE) >= 0 && 
                        $yyN < self::$yyTableCount && 
                        self::$yyCheck[$yyN] == TOKEN_YY_ERRORCODE
                      ) {
                        $yyState= self::$yyTable[$yyN];
                        $yyVal= $yyLex->value;
                        break 3;
                      }
                    } while ($yyTop-- >= 0);

                    throw new ParseError(E_ERROR, sprintf(
                      'Irrecoverable syntax error at %s, line %d (offset %d)',
                      $yyLex->fileName,
                      $yyLex->position[0],
                      $yyLex->position[1]
                    ));
                  }

                  case 3: {
                    if (0 == $yyToken) {
                      throw new ParseError(E_ERROR, sprintf(
                        'Irrecoverable syntax error at end-of-file at %s, line %d (offset %d)',
                        $yyLex->fileName,
                        $yyLex->position[0],
                        $yyLex->position[1]
                      ));
                    }

                    $yyToken = -1;
                    break 1;
                  }
                }
              }
            }

            $yyV= $yyTop+ 1 - self::$yyLen[$yyN];
            $yyVal= $yyV > $yyTop ? NULL : $yyVals[$yyV];

            // Actions
            switch ($yyN) {

    case 1:  #line 28 "./grammar/php52.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal->setClassdef($yyVals[-1+$yyTop]); } break;

    case 2:  #line 29 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setClassdef($yyVals[-1+$yyTop]); } break;

    case 3:  #line 33 "./grammar/php52.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setName($yyVals[-3+$yyTop]->getValue());
    $yyVal->setParent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 4:  #line 38 "./grammar/php52.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setName($yyVals[-5+$yyTop]->getValue());
    $yyVal->setParent($yyVals[-3+$yyTop]->getValue());
    $yyVal->setInterfaces($yyVals[-1+$yyTop]);
  } break;

    case 5:  #line 46 "./grammar/php52.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]->getValue(); $yyVal= $yyVals[-2+$yyTop]; } break;

    case 6:  #line 47 "./grammar/php52.jay"
    { $yyVal= array($yyVals[0+$yyTop]->getValue()); } break;

    case 7:  #line 51 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setConstants($yyVals[-2+$yyTop]); $yyVal->setMembers($yyVals[-1+$yyTop]); } break;

    case 8:  #line 52 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setConstants($yyVals[-1+$yyTop]); } break;

    case 9:  #line 53 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setMembers($yyVals[-1+$yyTop]); } break;

    case 10:  #line 54 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); } break;

    case 11:  #line 58 "./grammar/php52.jay"
    { $yyVal= array_merge($yyVals[-3+$yyTop], $yyVals[-1+$yyTop]); } break;

    case 12:  #line 59 "./grammar/php52.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 13:  #line 62 "./grammar/php52.jay"
    { $yyVals[-4+$yyTop][]= new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue()); $yyVal= $yyVals[-4+$yyTop]; } break;

    case 14:  #line 63 "./grammar/php52.jay"
    { $yyVal= array(new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue())); } break;

    case 15:  #line 67 "./grammar/php52.jay"
    { foreach($yyVals[-1+$yyTop] as $m) { $m->setStatic($yyVals[-2+$yyTop]['static']); $m->setScope($yyVals[-2+$yyTop]['scope']); } $yyVal= array_merge($yyVals[-3+$yyTop],$yyVals[-1+$yyTop]); } break;

    case 16:  #line 68 "./grammar/php52.jay"
    { foreach($yyVals[-1+$yyTop] as $m) { $m->setStatic($yyVals[-2+$yyTop]['static']); $m->setScope($yyVals[-2+$yyTop]['scope']); } $yyVal= $yyVals[-1+$yyTop]; } break;

    case 17:  #line 71 "./grammar/php52.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop];} break;

    case 18:  #line 72 "./grammar/php52.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 19:  #line 75 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[-2+$yyTop]->getValue(), 1)); } break;

    case 20:  #line 76 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 21:  #line 79 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-2+$yyTop]); $yyVal->setPackage($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 22:  #line 80 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-1+$yyTop]); $yyVal->setPackage($yyVals[0+$yyTop]); } break;

    case 23:  #line 81 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 24:  #line 82 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setPackage($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 25:  #line 83 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[0+$yyTop]); } break;

    case 26:  #line 84 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setPackage($yyVals[0+$yyTop]); } break;

    case 27:  #line 85 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 28:  #line 89 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Package(); $yyVal->setPathname(xp·ide·source·parser·ParserHelper::unquote($yyVals[-1+$yyTop]->getValue())); } break;

    case 29:  #line 93 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Uses(); $yyVal->setClassnames($yyVals[-2+$yyTop]); } break;

    case 30:  #line 96 "./grammar/php52.jay"
    { $yyVals[-2+$yyTop][]= xp·ide·source·parser·ParserHelper::unquote($yyVals[0+$yyTop]->getValue()); $yyVal= $yyVals[-2+$yyTop]; } break;

    case 31:  #line 97 "./grammar/php52.jay"
    { $yyVal= array(xp·ide·source·parser·ParserHelper::unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 32:  #line 101 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·BlockComment(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 33:  #line 105 "./grammar/php52.jay"
    { $yyVal= array('scope' => $yyVals[-1+$yyTop], 'static' => TRUE); } break;

    case 34:  #line 106 "./grammar/php52.jay"
    { $yyVal= array('scope' => $yyVals[0+$yyTop], 'static' => TRUE); } break;

    case 35:  #line 107 "./grammar/php52.jay"
    { $yyVal= array('scope' => xp·ide·source·Scope::$PUBLIC, 'static' => TRUE); } break;

    case 36:  #line 108 "./grammar/php52.jay"
    { $yyVal= array('scope' => $yyVals[0+$yyTop], 'static' => FALSE); } break;

    case 37:  #line 109 "./grammar/php52.jay"
    { $yyVal= array('scope' => xp·ide·source·Scope::$PUBLIC, 'static' => FALSE); } break;

    case 38:  #line 113 "./grammar/php52.jay"
    { $yyVal= xp·ide·source·Scope::$PUBLIC; } break;

    case 39:  #line 114 "./grammar/php52.jay"
    { $yyVal= xp·ide·source·Scope::$PRIVATE; } break;

    case 40:  #line 115 "./grammar/php52.jay"
    { $yyVal= xp·ide·source·Scope::$PROTECTED; } break;
#line 462 "-"
            }
                   
            $yyTop-= self::$yyLen[$yyN];
            $yyState= $yyStates[$yyTop];
            $yyM= self::$yyLhs[$yyN];

            if (0 == $yyState && 0 == $yyM) {
              $yyState= self::$yyFinal;

              // Check whether it's necessary to fetch the next token
              $yyToken < 0 && $yyToken= $yyLex->advance() ? $yyLex->token : 0;

              // We've reached the final token!
              if (0 == $yyToken) return $yyVal;
              continue 2;
            }

            $yyState= (
              ($yyN= self::$yyGindex[$yyM]) != 0 && 
              ($yyN+= $yyState) >= 0 && 
              $yyN < self::$yyTableCount && 
              self::$yyCheck[$yyN] == $yyState
            ) ? self::$yyTable[$yyN] : self::$yyDgoto[$yyM];
            continue 2;
          }
        }
      }
    }

  }
?>
