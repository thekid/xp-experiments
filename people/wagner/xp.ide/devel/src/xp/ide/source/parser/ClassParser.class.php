<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  $package= 'xp.ide.source.parser';

#line 2 "grammar/Class.jay"

  uses(
    'xp.ide.source.Scope',
    'xp.ide.source.element.Classmembergroup',
    'xp.ide.source.element.Classmember',
    'xp.ide.source.element.Classmethod',
    'xp.ide.source.element.Classconstant',
    'xp.ide.source.element.Classmethodparam',
    'xp.ide.source.element.Array',
    'xp.ide.source.element.BlockComment',
    'xp.ide.source.element.Apidoc',
    'xp.ide.source.element.Annotation'
  );

#line 24 "-"

  uses('xp.ide.source.parser.Parser');

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class xp·ide·source·parser·ClassParser extends xp·ide·source·parser·Parser {
    const T_ENCAPSED_STRING= 257;
    const T_NUMBER= 258;
    const T_STRING= 259;
    const T_VARIABLE= 260;
    const T_ARRAY= 261;
    const T_NULL= 262;
    const T_BOOLEAN= 263;
    const T_DOUBLE_ARROW= 264;
    const T_FUNCTION= 265;
    const T_FUNCTION_BODY= 266;
    const T_OPEN_APIDOC= 267;
    const T_CONTENT_APIDOC= 268;
    const T_CLOSE_APIDOC= 269;
    const T_DIRECTIVE_APIDOC= 270;
    const T_START_ANNOTATION= 271;
    const T_CLOSE_ANNOTATION= 272;
    const T_ANNOTATION= 273;
    const T_PUBLIC= 274;
    const T_PRIVATE= 275;
    const T_PROTECTED= 276;
    const T_CONST= 277;
    const T_STATIC= 278;
    const T_ABSTRACT= 279;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     0,     0,     0,     0,     3,     3,     9,     4, 
          4,     4,     4,     4,     4,     4,     8,     6,    11,    11, 
         12,    12,    12,    13,    13,    14,    14,     5,     5,    15, 
         15,    10,    10,    16,    16,    17,    17,    17,    17,    18, 
         18,     7,     7,    20,    20,     1,     1,    22,    22,     2, 
          2,     2,     2,    24,    24,    25,    25,    23,    23,    21, 
         21,    26,    26,    26,    27,    27,    27,    27,    19,    19, 
         19,    19,    28,    28,    28,    28, 
    );
    protected static $yyLen= array(2,
          3,     2,     1,     1,     1,     0,     2,     1,     0,     8, 
          3,     3,     2,     2,     2,     1,     6,     3,     3,     1, 
          4,     3,     1,     3,     1,     3,     1,     4,     3,     2, 
          1,     3,     2,     3,     1,     4,     2,     3,     1,     1, 
          1,     2,     1,     1,     1,     4,     3,     5,     3,     4, 
          3,     3,     2,     3,     1,     3,     1,     2,     1,     1, 
          1,     1,     1,     1,     1,     1,     1,     1,     5,     4, 
          3,     1,     5,     3,     3,     1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     0,    62,    63,    64,     0,    61,    44, 
          0,     0,     0,     0,     8,     0,     0,     0,    16,    43, 
          0,     0,     0,    55,    60,     0,     0,     0,     0,     0, 
         20,     0,     0,     0,     0,    59,     0,     0,     7,    45, 
          0,    13,     0,    15,    14,    42,    58,     0,     0,    53, 
         65,    67,     0,    66,    68,    56,    72,     0,     0,    29, 
         31,     0,     0,    18,     0,     0,     0,    47,     0,     0, 
          0,    51,     0,    11,    12,    52,    54,     0,    40,     0, 
         41,    33,     0,    35,     0,     0,    28,    30,    27,     0, 
         22,     0,    25,    19,    49,     0,    46,    50,     9,    71, 
         76,     0,     0,     0,     0,    32,     0,     0,     0,     0, 
         21,     0,     0,     0,     0,    70,    38,    34,     0,    17, 
         26,    24,    48,     0,    75,    69,    74,     0,    36,     0, 
          0,    10,    73, 
    );
    protected static $yyDgoto= array(11,
         12,    13,    14,    15,    16,    17,    18,    19,   113,    59, 
         30,    31,    92,    93,    62,    83,    84,    85,    56,    20, 
         40,    33,    22,    23,    24,    25,    57,   103, 
    );
    protected static $yySindex = array(         -196,
        -48,  -200,  -242,  -222,     0,     0,     0,  -174,     0,     0, 
          0,  -233,  -208,  -151,     0,  -236,  -144,  -144,     0,     0, 
          0,  -208,   -25,     0,     0,  -121,    64,  -252,    65,   -44, 
          0,    52,   -22,  -174,  -176,     0,  -208,    -5,     0,     0, 
       -144,     0,  -144,     0,     0,     0,     0,     6,  -127,     0, 
          0,     0,    98,     0,     0,     0,     0,   -26,    16,     0, 
          0,  -193,   -21,     0,  -222,  -121,  -106,     0,    28,  -151, 
         29,     0,  -144,     0,     0,     0,     0,   -39,     0,    93, 
          0,     0,    12,     0,  -105,  -110,     0,     0,     0,    96, 
          0,    49,     0,     0,     0,    97,     0,     0,     0,     0, 
          0,  -104,    68,  -121,  -109,     0,   100,    34,   -95,  -163, 
          0,  -121,  -103,  -121,   -31,     0,     0,     0,  -121,     0, 
          0,     0,     0,  -131,     0,     0,     0,  -101,     0,  -144, 
       -121,     0,     0, 
    );
    protected static $yyRindex= array(          165,
         42,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,   166,   167,   168,     0,     0,     0,     0,     0,     0, 
       -168,     0,     0,     0,     0,     0,     0,     0,   -43,     0, 
          0,     0,     0,     0,   169,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,   170, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    78, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    85,     0,     0,     0,     0,   105,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    85,     0,     0, 
          0,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,   159,   137,    -7,    60,   158,    -9,   -13,     0,     0, 
          0,   110,     0,    66,     0,     0,    72,     0,   -57,   -12, 
         11,   144,     1,     3,   130,     0,   -66,     0, 
    );
    protected static $yyTable = array(65,
         23,   100,    42,    44,    45,    46,    39,    43,    95,   126, 
         21,   102,    26,    37,    82,    38,    60,    61,    49,    91, 
        101,    67,    36,    36,    48,    28,     1,    74,     2,    75, 
         46,    73,    47,    50,     4,    37,    68,    38,    49,    71, 
          5,     6,     7,    34,     9,    21,   117,    47,   128,    49, 
         29,     1,   106,    72,   123,   105,   125,   127,    27,    99, 
         46,   129,    39,     1,    76,     5,     6,     7,     2,     9, 
          3,    67,    49,   133,     4,    87,    88,     5,     6,     7, 
          8,     9,    10,     1,    32,    57,    97,    98,     2,   111, 
          3,    59,   110,    89,     4,    90,    45,     5,     6,     7, 
         57,     9,    10,    58,    63,    45,    45,    45,   116,    45, 
         45,   115,    66,     2,   130,     3,   132,    46,    39,     4, 
          2,    39,     5,     6,     7,    72,     9,    10,    72,     5, 
          6,     7,     1,     9,    10,    51,    52,    78,    86,    53, 
         54,    55,     5,     6,     7,    37,     9,    10,    37,    79, 
         80,    81,    96,   104,   107,   108,   109,   112,   120,   114, 
        119,   121,   131,     3,     6,     3,     4,     5,     2,     1, 
         35,    70,   124,    41,    94,   122,   118,    69,    77,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    51,    52,     0, 
          0,    53,    54,    55,     0,    51,    52,    64,    23,    53, 
         54,    55,    79,    80,    81,    89,     0,    90, 
    );
    protected static $yyCheck = array(44,
         44,    41,    16,    17,    18,    18,    14,    17,    66,    41, 
          0,    78,    61,    13,    41,    13,   269,   270,    44,    41, 
         78,    44,    12,    13,    22,   268,   260,    41,   265,    43, 
         43,    41,    22,    59,   271,    35,    59,    35,    44,    37, 
        274,   275,   276,   277,   278,    35,   104,    37,   115,    44, 
        273,   260,    41,    59,   112,    44,   114,   115,   259,    73, 
         73,   119,    70,   260,    59,   274,   275,   276,   265,   278, 
        267,    44,    44,   131,   271,   269,   270,   274,   275,   276, 
        277,   278,   279,   260,   259,    44,    59,    59,   265,    41, 
        267,   260,    44,   257,   271,   259,   265,   274,   275,   276, 
         59,   278,   279,    40,    40,   274,   275,   276,    41,   278, 
        279,    44,    61,   265,   124,   267,   130,   130,    41,   271, 
        265,    44,   274,   275,   276,    41,   278,   279,    44,   274, 
        275,   276,   260,   278,   279,   257,   258,    40,   123,   261, 
        262,   263,   274,   275,   276,    41,   278,   279,    44,   259, 
        260,   261,   259,    61,   260,   266,    61,    61,   125,   264, 
         61,   257,   264,   267,     0,     0,     0,     0,     0,     0, 
         12,    35,   113,    16,    65,   110,   105,    34,    49,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,   257,   258,    -1, 
         -1,   261,   262,   263,    -1,   257,   258,   272,   272,   261, 
        262,   263,   259,   260,   261,   257,    -1,   259, 
    );
    protected static $yyFinal= 11;
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
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_ENCAPSED_STRING', 
      'T_NUMBER', 'T_STRING', 'T_VARIABLE', 'T_ARRAY', 'T_NULL', 'T_BOOLEAN', 
      'T_DOUBLE_ARROW', 'T_FUNCTION', 'T_FUNCTION_BODY', 'T_OPEN_APIDOC', 
      'T_CONTENT_APIDOC', 'T_CLOSE_APIDOC', 'T_DIRECTIVE_APIDOC', 
      'T_START_ANNOTATION', 'T_CLOSE_ANNOTATION', 'T_ANNOTATION', 'T_PUBLIC', 
      'T_PRIVATE', 'T_PROTECTED', 'T_CONST', 'T_STATIC', 'T_ABSTRACT', 
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

    case 1:  #line 31 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setConstants($yyVals[-2+$yyTop]); $yyVal->setMembergroups($yyVals[-1+$yyTop]); $yyVal->setMethods($yyVals[0+$yyTop]); } break;

    case 2:  #line 32 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setConstants($yyVals[-1+$yyTop]); $yyVal->setMembergroups($yyVals[0+$yyTop]); } break;

    case 3:  #line 33 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setConstants($yyVals[0+$yyTop]); } break;

    case 4:  #line 34 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setMembergroups($yyVals[0+$yyTop]); } break;

    case 5:  #line 35 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setMethods($yyVals[0+$yyTop]); } break;

    case 6:  #line 36 "grammar/Class.jay"
    { $yyVal= $this->top_element; } break;

    case 7:  #line 40 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 8:  #line 41 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 9:  #line 45 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-3+$yyTop]);
    $yyVal->setAnnotations($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 10:  #line 53 "grammar/Class.jay"
    {
    $yyVal= $yyVals[-5+$yyTop];
    $yyVal->setApidoc($yyVals[-7+$yyTop]);
    isset($yyVals[-6+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-6+$yyTop]['abstract']);
    isset($yyVals[-6+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-6+$yyTop]['scope']);
    isset($yyVals[-6+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-6+$yyTop]['static']);
  } break;

    case 11:  #line 60 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; $yyVal->setApidoc($yyVals[-2+$yyTop]); $yyVal->setAnnotations($yyVals[-1+$yyTop]); } break;

    case 12:  #line 61 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setAnnotations($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 13:  #line 68 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; $yyVal->setApidoc($yyVals[-1+$yyTop]); } break;

    case 14:  #line 69 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 15:  #line 75 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop];  $yyVal->setAnnotations($yyVals[-1+$yyTop]); } break;

    case 16:  #line 76 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 17:  #line 80 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmethod($yyVals[-4+$yyTop]->getValue());
    $yyVal->setParams($yyVals[-3+$yyTop]);
    $yyVal->setContent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 18:  #line 88 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop];} break;

    case 19:  #line 91 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 20:  #line 92 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 21:  #line 95 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-3+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 22:  #line 96 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-2+$yyTop]->getValue(), 1)); } break;

    case 23:  #line 97 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 24:  #line 100 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; list($k, $v)= each($yyVals[0+$yyTop]); $yyVal[$k]= $v; } break;

    case 25:  #line 101 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 26:  #line 104 "grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop]->getValue() => $this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 27:  #line 105 "grammar/Class.jay"
    { $yyVal= array($this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 28:  #line 109 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-2+$yyTop]->getValue()); $yyVal->setDirectives($yyVals[-1+$yyTop]); } break;

    case 29:  #line 110 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 30:  #line 114 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue()); } break;

    case 31:  #line 115 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue())); } break;

    case 32:  #line 119 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 33:  #line 120 "grammar/Class.jay"
    { $yyVal= array(); } break;

    case 34:  #line 124 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 35:  #line 125 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 36:  #line 129 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1), $yyVals[-3+$yyTop]); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 37:  #line 130 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 38:  #line 131 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1)); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 39:  #line 132 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 40:  #line 136 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 41:  #line 137 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 42:  #line 141 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 43:  #line 142 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 44:  #line 146 "grammar/Class.jay"
    { $yyVal= array('abstract' => TRUE); } break;

    case 45:  #line 147 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 46:  #line 151 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-3+$yyTop], $yyVals[-1+$yyTop]); } break;

    case 47:  #line 152 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 48:  #line 156 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][]= new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue()); $yyVal= $yyVals[-4+$yyTop]; } break;

    case 49:  #line 157 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue())); } break;

    case 50:  #line 161 "grammar/Class.jay"
    {
    $yyVal= $yyVals[-3+$yyTop];
    $yyVal[]= $cg= new xp·ide·source·element·Classmembergroup();
    $cg->setMembers($yyVals[-1+$yyTop]);
    isset($yyVals[-2+$yyTop]['static']) && $cg->setStatic($yyVals[-2+$yyTop]['static']);
    isset($yyVals[-2+$yyTop]['scope'])  && $cg->setScope($yyVals[-2+$yyTop]['scope']);
  } break;

    case 51:  #line 168 "grammar/Class.jay"
    {
    $yyVal= $yyVals[-2+$yyTop];
    $yyVal[]= $cg= new xp·ide·source·element·Classmembergroup();
    $cg->setMembers($yyVals[-1+$yyTop]);
  } break;

    case 52:  #line 173 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmembergroup();
    isset($yyVals[-2+$yyTop]['static']) && $yyVal->setStatic($yyVals[-2+$yyTop]['static']);
    isset($yyVals[-2+$yyTop]['scope'])  && $yyVal->setScope($yyVals[-2+$yyTop]['scope']);
    $yyVal->setMembers($yyVals[-1+$yyTop]);
    $yyVal= array($yyVal);
  } break;

    case 53:  #line 180 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmembergroup();
    $yyVal->setMembers($yyVals[-1+$yyTop]);
    $yyVal= array($yyVal);
  } break;

    case 54:  #line 188 "grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop];} break;

    case 55:  #line 189 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 56:  #line 193 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[-2+$yyTop]->getValue(), 1), $yyVals[0+$yyTop]); } break;

    case 57:  #line 194 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 58:  #line 198 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 59:  #line 199 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 60:  #line 203 "grammar/Class.jay"
    { $yyVal= array('scope' => $yyVals[0+$yyTop]); } break;

    case 61:  #line 204 "grammar/Class.jay"
    { $yyVal= array('static' => TRUE); } break;

    case 62:  #line 208 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PUBLIC; } break;

    case 63:  #line 209 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PRIVATE; } break;

    case 64:  #line 210 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PROTECTED; } break;

    case 65:  #line 214 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 66:  #line 215 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 67:  #line 216 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 68:  #line 217 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 69:  #line 221 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-2+$yyTop]); } break;

    case 70:  #line 222 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-1+$yyTop]); } break;

    case 71:  #line 223 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array(); } break;

    case 72:  #line 224 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 73:  #line 228 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][$yyVals[-2+$yyTop]]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-4+$yyTop]; } break;

    case 74:  #line 229 "grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 75:  #line 230 "grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 76:  #line 231 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;
#line 644 "-"
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
