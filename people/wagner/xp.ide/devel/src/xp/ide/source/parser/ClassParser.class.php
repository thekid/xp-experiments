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
          0,     0,     0,     0,     0,     0,     0,     0,     3,     3, 
          4,     4,     4,     4,     4,     4,     4,     4,     8,     6, 
         10,    10,    11,    11,    11,    12,    12,    13,    13,     5, 
          5,    14,    14,     9,     9,    15,    15,    16,    16,    16, 
         16,    17,    17,     7,     7,    19,    19,     1,     1,    21, 
         21,     2,     2,     2,     2,    23,    23,    24,    24,    22, 
         22,    20,    20,    25,    25,    25,    26,    26,    26,    26, 
         18,    18,    18,    18,    27,    27,    27,    27, 
    );
    protected static $yyLen= array(2,
          3,     2,     2,     2,     1,     1,     1,     0,     2,     1, 
          4,     3,     3,     3,     2,     2,     2,     1,     6,     3, 
          3,     1,     4,     3,     1,     3,     1,     3,     1,     4, 
          3,     2,     1,     3,     2,     3,     1,     4,     2,     3, 
          1,     1,     1,     2,     1,     1,     1,     4,     3,     5, 
          3,     4,     3,     3,     2,     3,     1,     3,     1,     2, 
          1,     1,     1,     1,     1,     1,     1,     1,     1,     1, 
          5,     4,     3,     1,     5,     3,     3,     1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     0,    64,    65,    66,     0,    63,    46, 
          0,     0,     0,     0,    10,     0,     0,     0,    18,    45, 
          0,     0,     0,    57,    62,     0,     0,     0,     0,     0, 
         22,     0,     0,     0,     0,     0,     0,     0,     0,     9, 
         47,     0,     0,    15,     0,    17,    16,    44,    60,     0, 
          0,    55,    67,    69,     0,    68,    70,    58,    74,     0, 
          0,    31,    33,     0,     0,    20,     0,     0,     0,    49, 
          0,     0,     0,    53,     0,    13,    12,    14,    54,    56, 
          0,    42,     0,    43,    35,     0,    37,     0,     0,    30, 
         32,    29,     0,    24,     0,    27,    21,    51,     0,    48, 
         52,    11,    73,    78,     0,     0,     0,     0,    34,     0, 
          0,     0,     0,    23,     0,     0,     0,    72,    40,    36, 
          0,    19,    28,    26,    50,    77,    71,    76,     0,    38, 
          0,    75, 
    );
    protected static $yyDgoto= array(11,
         12,    13,    14,    15,    16,    17,    18,    19,    61,    30, 
         31,    95,    96,    64,    86,    87,    88,    58,    20,    41, 
         33,    22,    23,    24,    25,    59,   106, 
    );
    protected static $yySindex = array(         -196,
        -48,  -242,  -240,  -227,     0,     0,     0,  -199,     0,     0, 
          0,  -176,  -156,  -133,     0,  -121,  -114,  -114,     0,     0, 
          0,  -202,   -30,     0,     0,   -91,    21,  -261,    47,   -44, 
          0,     6,   -18,  -199,  -156,  -133,  -133,  -202,    33,     0, 
          0,  -114,  -114,     0,  -114,     0,     0,     0,     0,    46, 
       -174,     0,     0,     0,    56,     0,     0,     0,     0,   -26, 
        -16,     0,     0,  -248,   -21,     0,  -227,   -91,  -145,     0, 
         49,  -133,    62,     0,  -114,     0,     0,     0,     0,     0, 
        -39,     0,    63,     0,     0,    13,     0,  -131,  -127,     0, 
          0,     0,    74,     0,    44,     0,     0,     0,    91,     0, 
          0,     0,     0,     0,  -108,    53,   -91,  -112,     0,    98, 
         38,   -89,  -204,     0,   -91,   -91,   -31,     0,     0,     0, 
        -91,     0,     0,     0,     0,     0,     0,     0,   -95,     0, 
        -91,     0, 
    );
    protected static $yyRindex= array(          173,
         66,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,   174,   175,   176,     0,     0,     0,     0,     0,     0, 
       -148,     0,     0,     0,     0,     0,     0,     0,   -43,     0, 
          0,     0,     0,     0,   177,   178,   179,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,   180,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    72,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,    92,     0,     0,     0,     0,    96, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,    92,     0, 
          0,     0, 
    );
    protected static $yyGindex= array(0,
          0,   169,    12,    -2,     0,   166,     2,   -12,     0,     0, 
        116,     0,    71,     0,     0,    77,     0,   -65,    -7,    27, 
        152,    24,    10,   136,     0,   -74,     0, 
    );
    protected static $yyTable = array(67,
         25,   103,    98,    44,    46,    47,   105,    62,    63,   127, 
         48,    40,    26,    51,    85,   104,    27,    43,    45,    94, 
         90,    91,    39,    36,    37,    69,    21,    28,    52,    76, 
         77,    50,    78,    40,    40,    48,    38,    48,    21,    21, 
         70,   119,   129,    75,    39,    29,    72,    73,    49,   125, 
        126,   128,    92,   109,    93,   130,   108,     1,    38,    32, 
         60,    21,   102,     1,    49,   132,    68,    48,     2,    40, 
          3,     5,     6,     7,     4,     9,    51,     5,     6,     7, 
          8,     9,    10,     1,   114,     1,    65,   113,     2,    51, 
          3,    74,    69,   118,     4,    81,   117,     5,     6,     7, 
         34,     9,    10,     1,    79,    51,    89,   100,     2,    59, 
          3,    61,    41,    99,     4,    41,    47,     5,     6,     7, 
        101,     9,    10,   107,    59,    47,    47,    47,   110,    47, 
         47,     2,    74,     3,   112,    74,    39,     4,   111,    39, 
          5,     6,     7,     2,     9,    10,    82,    83,    84,     4, 
          2,   115,     5,     6,     7,   116,     9,    10,   121,     5, 
          6,     7,   122,     9,    10,    53,    54,   123,   131,    55, 
         56,    57,     8,     5,     6,     7,     4,     3,     2,     1, 
         35,    42,    97,   124,   120,    71,    80,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    53,    54,     0, 
          0,    55,    56,    57,     0,    53,    54,    66,    25,    55, 
         56,    57,    82,    83,    84,    92,     0,    93, 
    );
    protected static $yyCheck = array(44,
         44,    41,    68,    16,    17,    18,    81,   269,   270,    41, 
         18,    14,    61,    44,    41,    81,   259,    16,    17,    41, 
        269,   270,    13,    12,    13,    44,     0,   268,    59,    42, 
         43,    22,    45,    36,    37,    43,    13,    45,    12,    13, 
         59,   107,   117,    42,    35,   273,    35,    38,    22,   115, 
        116,   117,   257,    41,   259,   121,    44,   260,    35,   259, 
         40,    35,    75,   260,    38,   131,    61,    75,   265,    72, 
        267,   274,   275,   276,   271,   278,    44,   274,   275,   276, 
        277,   278,   279,   260,    41,   260,    40,    44,   265,    44, 
        267,    59,    44,    41,   271,    40,    44,   274,   275,   276, 
        277,   278,   279,   260,    59,    44,   123,    59,   265,    44, 
        267,   260,    41,   259,   271,    44,   265,   274,   275,   276, 
         59,   278,   279,    61,    59,   274,   275,   276,   260,   278, 
        279,   265,    41,   267,    61,    44,    41,   271,   266,    44, 
        274,   275,   276,   265,   278,   279,   259,   260,   261,   271, 
        265,    61,   274,   275,   276,   264,   278,   279,    61,   274, 
        275,   276,   125,   278,   279,   257,   258,   257,   264,   261, 
        262,   263,     0,     0,     0,     0,     0,     0,     0,     0, 
         12,    16,    67,   113,   108,    34,    51,    -1,    -1,    -1, 
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
    { $yyVal= $this->top_element; $yyVal->setMembergroups($yyVals[-1+$yyTop]); $yyVal->setMethods($yyVals[0+$yyTop]); } break;

    case 3:  #line 33 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setConstants($yyVals[-1+$yyTop]); $yyVal->setMethods($yyVals[0+$yyTop]); } break;

    case 4:  #line 34 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setConstants($yyVals[-1+$yyTop]); $yyVal->setMembergroups($yyVals[0+$yyTop]); } break;

    case 5:  #line 35 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setConstants($yyVals[0+$yyTop]); } break;

    case 6:  #line 36 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setMembergroups($yyVals[0+$yyTop]); } break;

    case 7:  #line 37 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setMethods($yyVals[0+$yyTop]); } break;

    case 8:  #line 38 "grammar/Class.jay"
    { $yyVal= $this->top_element; } break;

    case 9:  #line 42 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 10:  #line 43 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 11:  #line 47 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-3+$yyTop]);
    $yyVal->setAnnotations($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 12:  #line 55 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 13:  #line 62 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; $yyVal->setApidoc($yyVals[-2+$yyTop]); $yyVal->setAnnotations($yyVals[-1+$yyTop]); } break;

    case 14:  #line 63 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setAnnotations($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 15:  #line 70 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; $yyVal->setApidoc($yyVals[-1+$yyTop]); } break;

    case 16:  #line 71 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 17:  #line 77 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop];  $yyVal->setAnnotations($yyVals[-1+$yyTop]); } break;

    case 18:  #line 78 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 19:  #line 82 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmethod($yyVals[-4+$yyTop]->getValue());
    $yyVal->setParams($yyVals[-3+$yyTop]);
    $yyVal->setContent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 20:  #line 90 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop];} break;

    case 21:  #line 93 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 22:  #line 94 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 23:  #line 97 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-3+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 24:  #line 98 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-2+$yyTop]->getValue(), 1)); } break;

    case 25:  #line 99 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 26:  #line 102 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; list($k, $v)= each($yyVals[0+$yyTop]); $yyVal[$k]= $v; } break;

    case 27:  #line 103 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 28:  #line 106 "grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop]->getValue() => $this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 29:  #line 107 "grammar/Class.jay"
    { $yyVal= array($this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 30:  #line 111 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-2+$yyTop]->getValue()); $yyVal->setDirectives($yyVals[-1+$yyTop]); } break;

    case 31:  #line 112 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 32:  #line 116 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue()); } break;

    case 33:  #line 117 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue())); } break;

    case 34:  #line 121 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 35:  #line 122 "grammar/Class.jay"
    { $yyVal= array(); } break;

    case 36:  #line 126 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 37:  #line 127 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 38:  #line 131 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1), $yyVals[-3+$yyTop]); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 39:  #line 132 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 40:  #line 133 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1)); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 41:  #line 134 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 42:  #line 138 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 43:  #line 139 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 44:  #line 143 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 45:  #line 144 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 46:  #line 148 "grammar/Class.jay"
    { $yyVal= array('abstract' => TRUE); } break;

    case 47:  #line 149 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 48:  #line 153 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-3+$yyTop], $yyVals[-1+$yyTop]); } break;

    case 49:  #line 154 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 50:  #line 158 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][]= new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue()); $yyVal= $yyVals[-4+$yyTop]; } break;

    case 51:  #line 159 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue())); } break;

    case 52:  #line 163 "grammar/Class.jay"
    {
    $yyVal= $yyVals[-3+$yyTop];
    $yyVal[]= $cg= new xp·ide·source·element·Classmembergroup();
    $cg->setMembers($yyVals[-1+$yyTop]);
    isset($yyVals[-2+$yyTop]['static']) && $cg->setStatic($yyVals[-2+$yyTop]['static']);
    isset($yyVals[-2+$yyTop]['scope'])  && $cg->setScope($yyVals[-2+$yyTop]['scope']);
  } break;

    case 53:  #line 170 "grammar/Class.jay"
    {
    $yyVal= $yyVals[-2+$yyTop];
    $yyVal[]= $cg= new xp·ide·source·element·Classmembergroup();
    $cg->setMembers($yyVals[-1+$yyTop]);
  } break;

    case 54:  #line 175 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmembergroup();
    isset($yyVals[-2+$yyTop]['static']) && $yyVal->setStatic($yyVals[-2+$yyTop]['static']);
    isset($yyVals[-2+$yyTop]['scope'])  && $yyVal->setScope($yyVals[-2+$yyTop]['scope']);
    $yyVal->setMembers($yyVals[-1+$yyTop]);
    $yyVal= array($yyVal);
  } break;

    case 55:  #line 182 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmembergroup();
    $yyVal->setMembers($yyVals[-1+$yyTop]);
    $yyVal= array($yyVal);
  } break;

    case 56:  #line 190 "grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop];} break;

    case 57:  #line 191 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 58:  #line 195 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[-2+$yyTop]->getValue(), 1), $yyVals[0+$yyTop]); } break;

    case 59:  #line 196 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 60:  #line 200 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 61:  #line 201 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 62:  #line 205 "grammar/Class.jay"
    { $yyVal= array('scope' => $yyVals[0+$yyTop]); } break;

    case 63:  #line 206 "grammar/Class.jay"
    { $yyVal= array('static' => TRUE); } break;

    case 64:  #line 210 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PUBLIC; } break;

    case 65:  #line 211 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PRIVATE; } break;

    case 66:  #line 212 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PROTECTED; } break;

    case 67:  #line 216 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 68:  #line 217 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 69:  #line 218 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 70:  #line 219 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 71:  #line 223 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-2+$yyTop]); } break;

    case 72:  #line 224 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-1+$yyTop]); } break;

    case 73:  #line 225 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array(); } break;

    case 74:  #line 226 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 75:  #line 230 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][$yyVals[-2+$yyTop]]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-4+$yyTop]; } break;

    case 76:  #line 231 "grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 77:  #line 232 "grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 78:  #line 233 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;
#line 650 "-"
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
