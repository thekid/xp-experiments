<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  $package= 'xp.ide.source.parser';

#line 2 "grammar/Class.jay"

  uses(
    'xp.ide.source.Scope',
    'xp.ide.source.element.Classdef',
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
          0,     0,     0,     0,     0,     0,     3,     3,     4,     4, 
          4,     4,     4,     4,     4,     4,     8,     6,     6,    10, 
         10,    11,    11,    11,    12,    12,    13,    13,     5,     5, 
         14,    14,     9,     9,    15,    15,    16,    16,    16,    16, 
         17,    17,     7,     7,    19,    19,     1,     1,    21,    21, 
          2,     2,     2,     2,    23,    23,    24,    24,    22,    22, 
         20,    20,    25,    25,    25,    26,    26,    26,    26,    18, 
         18,    18,    18,    27,    27,    27,    27, 
    );
    protected static $yyLen= array(2,
          3,     2,     1,     1,     1,     0,     2,     1,     4,     3, 
          3,     2,     3,     2,     2,     1,     6,     3,     0,     3, 
          1,     4,     3,     1,     3,     1,     3,     1,     4,     3, 
          2,     1,     3,     2,     3,     1,     4,     2,     3,     1, 
          1,     1,     2,     1,     1,     1,     4,     3,     5,     3, 
          4,     3,     3,     2,     3,     1,     3,     1,     2,     1, 
          1,     1,     1,     1,     1,     1,     1,     1,     1,     5, 
          4,     3,     1,     5,     3,     3,     1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     0,    63,    64,    65,     0,    62,    46, 
          0,     0,     0,     0,     8,     0,     0,     0,    16,    44, 
          0,     0,     0,    56,    61,     0,     0,     0,     0,     0, 
         21,     0,     0,     0,     0,    60,     0,     0,     7,    45, 
          0,     0,    14,     0,     0,    15,    12,    43,    59,     0, 
          0,    54,    66,    68,     0,    67,    69,    57,    73,     0, 
          0,    30,    32,     0,     0,    18,     0,     0,     0,    48, 
          0,     0,     0,    52,     0,    10,    13,    11,    53,    55, 
          0,    41,     0,    42,    34,     0,    36,     0,     0,    29, 
         31,    28,     0,    23,     0,    26,    20,    50,     0,    47, 
         51,     9,    72,    77,     0,     0,     0,     0,    33,     0, 
          0,     0,     0,    22,     0,     0,     0,    71,    39,    35, 
          0,    17,    27,    25,    49,    76,    70,    75,     0,    37, 
          0,    74, 
    );
    protected static $yyDgoto= array(11,
         12,    13,    14,    15,    16,    17,    18,    19,    61,    30, 
         31,    95,    96,    64,    86,    87,    88,    58,    20,    40, 
         33,    22,    23,    24,    25,    59,   106, 
    );
    protected static $yySindex = array(         -203,
        -13,  -242,  -243,  -214,     0,     0,     0,  -192,     0,     0, 
          0,  -166,  -158,  -142,     0,  -130,  -115,  -109,     0,     0, 
          0,  -158,   -36,     0,     0,   -86,    47,  -216,    57,   -44, 
          0,    44,   -10,  -192,  -183,     0,  -158,     1,     0,     0, 
       -148,  -109,     0,  -141,  -109,     0,     0,     0,     0,    11, 
       -122,     0,     0,     0,    79,     0,     0,     0,     0,   -26, 
         20,     0,     0,  -190,   -21,     0,  -214,   -86,  -119,     0, 
         39,  -142,    62,     0,  -109,     0,     0,     0,     0,     0, 
        -39,     0,    86,     0,     0,   -17,     0,  -107,  -112,     0, 
          0,     0,    90,     0,   -15,     0,     0,     0,    94,     0, 
          0,     0,     0,     0,  -106,    17,   -86,  -146,     0,    96, 
         43,   -95,  -222,     0,   -86,   -86,   -31,     0,     0,     0, 
        -86,     0,     0,     0,     0,     0,     0,     0,   -91,     0, 
        -86,     0, 
    );
    protected static $yyRindex= array(          174,
         63,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,   178,   179,   180,     0,     0,     0,     0,     0,     0, 
       -175,     0,     0,     0,     0,     0,     0,     0,   -43,     0, 
          0,     0,     0,     0,   181,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,   182,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    37,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,    45,     0,     0,     0,     0,    98, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,    45,     0, 
          0,     0, 
    );
    protected static $yyGindex= array(0,
          0,   171,   149,    -7,   168,   170,    -3,   -12,     0,     0, 
        120,     0,    75,     0,     0,    81,     0,   -65,    -6,     9, 
        156,     5,     6,   140,     0,   -70,     0, 
    );
    protected static $yyTable = array(67,
         24,   103,    98,    43,    46,    47,    39,    51,    21,   127, 
        105,    48,    42,    45,    85,   104,    27,    37,    38,    94, 
         36,    36,    52,   109,    28,   114,   108,    50,   113,    76, 
         49,    77,    78,    69,    92,    48,    93,    75,    48,    37, 
         38,   119,    73,    21,    51,    49,   129,    26,    70,   125, 
        126,   128,    62,    63,    51,   130,     1,   118,    29,    74, 
        117,     2,   102,     3,    39,   132,    32,     4,    48,    79, 
          5,     6,     7,     8,     9,    10,     1,    40,    90,    91, 
         40,     2,    69,     3,    60,    73,    60,     4,    73,    45, 
          5,     6,     7,     1,     9,    10,    65,   100,    45,    45, 
         45,     1,    45,    45,    68,    51,    58,     5,     6,     7, 
         34,     9,    82,    83,    84,     5,     6,     7,    81,     9, 
        101,    58,     2,     2,     3,     5,     6,     7,     4,     9, 
         10,     5,     6,     7,     2,     9,    10,     1,    38,    99, 
          4,    38,    89,     5,     6,     7,   107,     9,    10,     2, 
        112,     3,   110,   111,   115,     2,   121,   116,     5,     6, 
          7,   123,     9,    10,     5,     6,     7,   122,     9,    10, 
         53,    54,   131,     6,    55,    56,    57,     3,     4,     5, 
          2,     1,    35,    72,    44,    41,    97,   124,   120,    71, 
         80,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    53,    54,     0, 
          0,    55,    56,    57,     0,    53,    54,    66,    24,    55, 
         56,    57,    82,    83,    84,    92,     0,    93, 
    );
    protected static $yyCheck = array(44,
         44,    41,    68,    16,    17,    18,    14,    44,     0,    41, 
         81,    18,    16,    17,    41,    81,   259,    13,    13,    41, 
         12,    13,    59,    41,   268,    41,    44,    22,    44,    42, 
         22,    44,    45,    44,   257,    42,   259,    41,    45,    35, 
         35,   107,    37,    35,    44,    37,   117,    61,    59,   115, 
        116,   117,   269,   270,    44,   121,   260,    41,   273,    59, 
         44,   265,    75,   267,    72,   131,   259,   271,    75,    59, 
        274,   275,   276,   277,   278,   279,   260,    41,   269,   270, 
         44,   265,    44,   267,   260,    41,    40,   271,    44,   265, 
        274,   275,   276,   260,   278,   279,    40,    59,   274,   275, 
        276,   260,   278,   279,    61,    44,    44,   274,   275,   276, 
        277,   278,   259,   260,   261,   274,   275,   276,    40,   278, 
         59,    59,   265,   265,   267,   274,   275,   276,   271,   278, 
        279,   274,   275,   276,   265,   278,   279,   260,    41,   259, 
        271,    44,   123,   274,   275,   276,    61,   278,   279,   265, 
         61,   267,   260,   266,    61,   265,    61,   264,   274,   275, 
        276,   257,   278,   279,   274,   275,   276,   125,   278,   279, 
        257,   258,   264,     0,   261,   262,   263,     0,     0,     0, 
          0,     0,    12,    35,    17,    16,    67,   113,   108,    34, 
         51,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
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
    { $yyVal= $this->top_element; $yyVal->setConstants($yyVals[-2+$yyTop]); $yyVal->setMembers($yyVals[-1+$yyTop]); $yyVal->setMethods($yyVals[0+$yyTop]); } break;

    case 2:  #line 32 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setConstants($yyVals[-1+$yyTop]); $yyVal->setMembers($yyVals[0+$yyTop]); } break;

    case 3:  #line 33 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setConstants($yyVals[0+$yyTop]); } break;

    case 4:  #line 34 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setMembers($yyVals[0+$yyTop]); } break;

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
    $yyVal->setAnnotation($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 10:  #line 53 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 11:  #line 60 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setAnnotation($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 12:  #line 67 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 13:  #line 73 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; $yyVal->setApidoc($yyVals[-2+$yyTop]); $yyVal->setAnnotations($yyVals[-2+$yyTop]); } break;

    case 14:  #line 74 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; $yyVal->setApidoc($yyVals[-1+$yyTop]); } break;

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

    case 19:  #line 89 "grammar/Class.jay"
    { $yyVal= array(); } break;

    case 20:  #line 92 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 21:  #line 93 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 22:  #line 96 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-3+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 23:  #line 97 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-2+$yyTop]->getValue(), 1)); } break;

    case 24:  #line 98 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 25:  #line 101 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; list($k, $v)= each($yyVals[0+$yyTop]); $yyVal[$k]= $v; } break;

    case 26:  #line 102 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 27:  #line 105 "grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop]->getValue() => $this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 28:  #line 106 "grammar/Class.jay"
    { $yyVal= array($this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 29:  #line 110 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-2+$yyTop]->getValue()); $yyVal->setDirectives($yyVals[-1+$yyTop]); } break;

    case 30:  #line 111 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 31:  #line 115 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue()); } break;

    case 32:  #line 116 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue())); } break;

    case 33:  #line 120 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 34:  #line 121 "grammar/Class.jay"
    { $yyVal= array(); } break;

    case 35:  #line 125 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 36:  #line 126 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 37:  #line 130 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1), $yyVals[-3+$yyTop]); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 38:  #line 131 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 39:  #line 132 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1)); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 40:  #line 133 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 41:  #line 137 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 42:  #line 138 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 43:  #line 142 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 44:  #line 143 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 45:  #line 147 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 46:  #line 148 "grammar/Class.jay"
    { $yyVal= array('abstract' => TRUE); } break;

    case 47:  #line 152 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-3+$yyTop], $yyVals[-1+$yyTop]); } break;

    case 48:  #line 153 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 49:  #line 157 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][]= new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue()); $yyVal= $yyVals[-4+$yyTop]; } break;

    case 50:  #line 158 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue())); } break;

    case 51:  #line 162 "grammar/Class.jay"
    { foreach($yyVals[-1+$yyTop] as $m) { isset($yyVals[-2+$yyTop]['static']) && $m->setStatic($yyVals[-2+$yyTop]['static']); isset($yyVals[-2+$yyTop]['scope']) && $m->setScope($yyVals[-2+$yyTop]['scope']); } $yyVal= array_merge($yyVals[-3+$yyTop],$yyVals[-1+$yyTop]); } break;

    case 52:  #line 163 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-2+$yyTop], $yyVals[-1+$yyTop]); } break;

    case 53:  #line 164 "grammar/Class.jay"
    { foreach($yyVals[-1+$yyTop] as $m) { isset($yyVals[-2+$yyTop]['static']) && $m->setStatic($yyVals[-2+$yyTop]['static']); isset($yyVals[-2+$yyTop]['scope']) && $m->setScope($yyVals[-2+$yyTop]['scope']); } $yyVal= $yyVals[-1+$yyTop]; } break;

    case 54:  #line 165 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 55:  #line 169 "grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop];} break;

    case 56:  #line 170 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 57:  #line 174 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[-2+$yyTop]->getValue(), 1), NULL, $yyVals[0+$yyTop]); } break;

    case 58:  #line 175 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 59:  #line 179 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 60:  #line 180 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 61:  #line 184 "grammar/Class.jay"
    { $yyVal= array('scope' => $yyVals[0+$yyTop]); } break;

    case 62:  #line 185 "grammar/Class.jay"
    { $yyVal= array('static' => TRUE); } break;

    case 63:  #line 189 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PUBLIC; } break;

    case 64:  #line 190 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PRIVATE; } break;

    case 65:  #line 191 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PROTECTED; } break;

    case 66:  #line 195 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 67:  #line 196 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 68:  #line 197 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 69:  #line 198 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 70:  #line 202 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-2+$yyTop]); } break;

    case 71:  #line 203 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-1+$yyTop]); } break;

    case 72:  #line 204 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array(); } break;

    case 73:  #line 205 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 74:  #line 209 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][$yyVals[-2+$yyTop]]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-4+$yyTop]; } break;

    case 75:  #line 210 "grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 76:  #line 211 "grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 77:  #line 212 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;
#line 627 "-"
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
