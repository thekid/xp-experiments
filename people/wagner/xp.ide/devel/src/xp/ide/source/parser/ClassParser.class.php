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
    'xp.ide.source.element.BlockComment'
  );

#line 22 "-"

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
          4,     4,     7,     7,     8,     8,     6,     6,     9,     9, 
         10,    10,    10,    10,    11,    11,     5,     5,    13,    13, 
          1,     1,    15,    15,     2,     2,     2,     2,    17,    17, 
         18,    18,    16,    16,    14,    14,    19,    19,    19,    20, 
         20,    20,    20,    12,    12,    12,    12,    21,    21,    21, 
         21, 
    );
    protected static $yyLen= array(2,
          3,     2,     1,     1,     1,     0,     2,     1,     7,     6, 
          8,     7,     4,     3,     2,     1,     3,     2,     3,     1, 
          4,     2,     3,     1,     1,     1,     2,     1,     1,     1, 
          4,     3,     5,     3,     4,     3,     3,     2,     3,     1, 
          3,     1,     2,     1,     1,     1,     1,     1,     1,     1, 
          1,     1,     1,     5,     4,     3,     1,     5,     3,     3, 
          1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,    47,    48,    49,     0,    46,    30,     0, 
          0,     0,     0,     8,     0,     0,    28,     0,     0,     0, 
         40,    45,     0,     0,     0,     0,     0,     0,     0,    44, 
          0,     0,     7,    29,     0,    27,     0,     0,    43,     0, 
          0,    38,    50,    52,     0,    51,    53,    41,    57,     0, 
          0,    14,    16,     0,     0,     0,    32,     0,     0,     0, 
         36,     0,     0,     0,    37,    39,     0,    25,     0,    26, 
         18,     0,    20,     0,     0,    13,    15,    34,     0,    31, 
         35,     0,     0,     0,    56,    61,     0,     0,     0,    17, 
          0,     0,     0,     0,     0,     0,     0,     0,    55,     0, 
         23,    19,     0,    10,    33,     0,     0,     0,    60,    54, 
         59,     0,    21,     9,    12,     0,     0,    11,    58, 
    );
    protected static $yyDgoto= array(10,
         11,    12,    13,    14,    15,    51,    16,    54,    72,    73, 
         74,    48,    17,    34,    27,    19,    20,    21,    22,    49, 
         88, 
    );
    protected static $yySindex = array(         -222,
        -55,  -235,  -238,     0,     0,     0,  -225,     0,     0,     0, 
       -189,  -184,  -162,     0,  -156,  -150,     0,     0,  -184,   -30, 
          0,     0,  -121,     2,  -253,    -1,   -26,  -225,  -201,     0, 
       -184,   -18,     0,     0,  -208,     0,  -197,  -144,     0,    23, 
       -192,     0,     0,     0,    61,     0,     0,     0,     0,   -29, 
        -21,     0,     0,  -171,  -121,  -155,     0,    49,  -162,    51, 
          0,     2,     2,  -153,     0,     0,   -41,     0,    46,     0, 
          0,   -19,     0,  -133,  -128,     0,     0,     0,    72,     0, 
          0,    16,    24,     2,     0,     0,  -118,     6,  -121,     0, 
       -116,    87,    25,  -121,  -117,  -115,    29,  -121,     0,   -34, 
          0,     0,  -121,     0,     0,    30,    31,  -113,     0,     0, 
          0,  -110,     0,     0,     0,    32,  -121,     0,     0, 
    );
    protected static $yyRindex= array(          158,
         52,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
        159,   160,   161,     0,     0,     0,     0,  -195,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,   162,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,   163,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,    17,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,    28,     0,     0,     0, 
          0,    56,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    28,     0,     0,     0,     0,     0,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,   153,   136,   -11,   150,   -53,     0,     0,     0,    76, 
          0,   -54,   -10,     8,   140,     3,    -8,   128,     0,   -64, 
          0, 
    );
    protected static $yyTable = array(85,
         78,    33,    87,    32,    36,    23,   110,    18,    82,    83, 
         40,    71,    86,    41,    31,    52,    53,    56,    30,    30, 
         32,    90,    60,    24,    91,    41,    39,    36,    42,    25, 
         97,    31,    57,    26,   101,   112,    18,     1,    39,   105, 
         61,    50,     2,   109,     3,   111,    99,    33,   113,   100, 
         62,     4,     5,     6,     7,     8,     9,    24,     1,    55, 
         24,    63,   119,     2,    44,     3,    41,     1,    57,    29, 
          1,    57,     4,     5,     6,     1,     8,     9,    29,    29, 
         29,    65,    29,    29,     4,     5,     6,    28,     8,     4, 
          5,     6,    56,     8,    41,    42,    22,    76,    77,    22, 
         67,    75,     2,    79,     3,    84,    89,    80,    35,    81, 
         42,     4,     5,     6,    37,     8,     9,     4,     5,     6, 
         64,     8,     9,     4,     5,     6,    92,     8,     9,     4, 
          5,     6,    94,     8,     9,    43,    44,    93,    95,    45, 
         46,    47,    68,    69,    70,    98,    96,   103,   106,   104, 
        107,   108,   116,   117,   114,   115,   118,     6,     3,     4, 
          5,     2,     1,    29,    59,    38,   102,    58,    66,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,    43,    44,     0,     0,    45, 
         46,    47,    43,    44,     0,     0,    45,    46,    47,    68, 
         69,    70, 
    );
    protected static $yyCheck = array(41,
         55,    13,    67,    12,    15,    61,    41,     0,    62,    63, 
         19,    41,    67,    44,    12,   269,   270,    44,    11,    12, 
         29,    41,    31,   259,    44,    44,    19,    38,    59,   268, 
         84,    29,    59,   259,    89,   100,    29,   260,    31,    94, 
         59,    40,   265,    98,   267,   100,    41,    59,   103,    44, 
        259,   274,   275,   276,   277,   278,   279,    41,   260,    61, 
         44,   259,   117,   265,   260,   267,    44,   260,    41,   265, 
        260,    44,   274,   275,   276,   260,   278,   279,   274,   275, 
        276,    59,   278,   279,   274,   275,   276,   277,   278,   274, 
        275,   276,    44,   278,    44,    44,    41,   269,   270,    44, 
         40,   123,   265,   259,   267,   259,    61,    59,   265,    59, 
         59,   274,   275,   276,   265,   278,   279,   274,   275,   276, 
        265,   278,   279,   274,   275,   276,   260,   278,   279,   274, 
        275,   276,    61,   278,   279,   257,   258,   266,   123,   261, 
        262,   263,   259,   260,   261,   264,   123,    61,   266,   125, 
        266,   123,   266,   264,   125,   125,   125,     0,     0,     0, 
          0,     0,     0,    11,    29,    16,    91,    28,    41,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,   257,   258,    -1,    -1,   261, 
        262,   263,   257,   258,    -1,    -1,   261,   262,   263,   259, 
        260,   261, 
    );
    protected static $yyFinal= 10;
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

    case 1:  #line 29 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setConstants($yyVals[-2+$yyTop]); $yyVal->setMembers($yyVals[-1+$yyTop]); $yyVal->setMethods($yyVals[0+$yyTop]); } break;

    case 2:  #line 30 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setConstants($yyVals[-1+$yyTop]); $yyVal->setMembers($yyVals[0+$yyTop]); } break;

    case 3:  #line 31 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setConstants($yyVals[0+$yyTop]); } break;

    case 4:  #line 32 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setMembers($yyVals[0+$yyTop]); } break;

    case 5:  #line 33 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setMethods($yyVals[0+$yyTop]); } break;

    case 6:  #line 34 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); } break;

    case 7:  #line 38 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 8:  #line 39 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 9:  #line 43 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmethod($yyVals[-4+$yyTop]->getValue());
    isset($yyVals[-6+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-6+$yyTop]['abstract']);
    isset($yyVals[-6+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-6+$yyTop]['scope']);
    isset($yyVals[-6+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-6+$yyTop]['static']);
    $yyVal->setParams($yyVals[-3+$yyTop]);
    $yyVal->setContent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 10:  #line 51 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmethod($yyVals[-4+$yyTop]->getValue());
    $yyVal->setParams($yyVals[-3+$yyTop]);
    $yyVal->setContent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 11:  #line 56 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmethod($yyVals[-4+$yyTop]->getValue());
    $yyVal->setApidoc($yyVals[-7+$yyTop]);
    isset($yyVals[-6+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-6+$yyTop]['abstract']);
    isset($yyVals[-6+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-6+$yyTop]['scope']);
    isset($yyVals[-6+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-6+$yyTop]['static']);
    $yyVal->setParams($yyVals[-3+$yyTop]);
    $yyVal->setContent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 12:  #line 65 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmethod($yyVals[-4+$yyTop]->getValue());
    $yyVal->setApidoc($yyVals[-6+$yyTop]);
    $yyVal->setParams($yyVals[-3+$yyTop]);
    $yyVal->setContent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 13:  #line 74 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-2+$yyTop]->getValue()); $yyVal->setDirectives($yyVals[-1+$yyTop]); } break;

    case 14:  #line 75 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 15:  #line 79 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue()); } break;

    case 16:  #line 80 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue())); } break;

    case 17:  #line 84 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 18:  #line 85 "grammar/Class.jay"
    { $yyVal= array(); } break;

    case 19:  #line 89 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 20:  #line 90 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 21:  #line 94 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1), $yyVals[-3+$yyTop]); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 22:  #line 95 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 23:  #line 96 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1)); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 24:  #line 97 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 25:  #line 101 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 26:  #line 102 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 27:  #line 106 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 28:  #line 107 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 29:  #line 111 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 30:  #line 112 "grammar/Class.jay"
    { $yyVal= array('abstract' => TRUE); } break;

    case 31:  #line 116 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-3+$yyTop], $yyVals[-1+$yyTop]); } break;

    case 32:  #line 117 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 33:  #line 121 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][]= new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue()); $yyVal= $yyVals[-4+$yyTop]; } break;

    case 34:  #line 122 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue())); } break;

    case 35:  #line 126 "grammar/Class.jay"
    { foreach($yyVals[-1+$yyTop] as $m) { isset($yyVals[-2+$yyTop]['static']) && $m->setStatic($yyVals[-2+$yyTop]['static']); isset($yyVals[-2+$yyTop]['scope']) && $m->setScope($yyVals[-2+$yyTop]['scope']); } $yyVal= array_merge($yyVals[-3+$yyTop],$yyVals[-1+$yyTop]); } break;

    case 36:  #line 127 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-2+$yyTop], $yyVals[-1+$yyTop]); } break;

    case 37:  #line 128 "grammar/Class.jay"
    { foreach($yyVals[-1+$yyTop] as $m) { isset($yyVals[-2+$yyTop]['static']) && $m->setStatic($yyVals[-2+$yyTop]['static']); isset($yyVals[-2+$yyTop]['scope']) && $m->setScope($yyVals[-2+$yyTop]['scope']); } $yyVal= $yyVals[-1+$yyTop]; } break;

    case 38:  #line 129 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 39:  #line 133 "grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop];} break;

    case 40:  #line 134 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 41:  #line 138 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[-2+$yyTop]->getValue(), 1), NULL, $yyVals[0+$yyTop]); } break;

    case 42:  #line 139 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 43:  #line 143 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 44:  #line 144 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 45:  #line 148 "grammar/Class.jay"
    { $yyVal= array('scope' => $yyVals[0+$yyTop]); } break;

    case 46:  #line 149 "grammar/Class.jay"
    { $yyVal= array('static' => TRUE); } break;

    case 47:  #line 153 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PUBLIC; } break;

    case 48:  #line 154 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PRIVATE; } break;

    case 49:  #line 155 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PROTECTED; } break;

    case 50:  #line 159 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 51:  #line 160 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 52:  #line 161 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 53:  #line 162 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 54:  #line 166 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-2+$yyTop]); } break;

    case 55:  #line 167 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-1+$yyTop]); } break;

    case 56:  #line 168 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array(); } break;

    case 57:  #line 169 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 58:  #line 173 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][$yyVals[-2+$yyTop]]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-4+$yyTop]; } break;

    case 59:  #line 174 "grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 60:  #line 175 "grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 61:  #line 176 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;
#line 565 "-"
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
