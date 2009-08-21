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
    const T_PUBLIC= 267;
    const T_PRIVATE= 268;
    const T_PROTECTED= 269;
    const T_CONST= 270;
    const T_STATIC= 271;
    const T_ABSTRACT= 272;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     0,     0,     0,     0,     3,     3,     4,     4, 
          6,     6,     7,     7,     8,     8,     8,     8,     9,     9, 
          5,     5,    11,    11,     1,     1,    13,    13,     2,     2, 
          2,     2,    15,    15,    16,    16,    14,    14,    12,    12, 
         17,    17,    17,    18,    18,    18,    18,    10,    10,    10, 
         10,    19,    19,    19,    19, 
    );
    protected static $yyLen= array(2,
          3,     2,     1,     1,     1,     0,     2,     1,     7,     6, 
          3,     2,     3,     1,     4,     2,     3,     1,     1,     1, 
          2,     1,     1,     1,     4,     3,     5,     3,     4,     3, 
          3,     2,     3,     1,     3,     1,     2,     1,     1,     1, 
          1,     1,     1,     1,     1,     1,     1,     5,     4,     3, 
          1,     5,     3,     3,     1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,    41,    42,    43,     0,    40,    24,     0,     0, 
          0,     0,     8,     0,    22,     0,     0,     0,    34,    39, 
          0,     0,     0,     0,     0,     0,    38,     0,     0,     7, 
         23,     0,    21,    37,     0,     0,    32,    44,    46,     0, 
         45,    47,    35,    51,     0,     0,     0,     0,    26,     0, 
          0,     0,    30,     0,    31,    33,     0,    19,     0,    20, 
         12,     0,    14,     0,     0,    28,     0,    25,    29,     0, 
         50,    55,     0,     0,     0,    11,     0,     0,     0,     0, 
          0,     0,    49,     0,    17,    13,     0,    10,    27,     0, 
         54,    48,    53,     0,    15,     9,     0,    52, 
    );
    protected static $yyDgoto= array(9,
         10,    11,    12,    13,    14,    46,    62,    63,    64,    43, 
         15,    31,    24,    17,    18,    19,    20,    44,    74, 
    );
    protected static $yySindex = array(         -213,
        -43,  -240,     0,     0,     0,  -233,     0,     0,     0,  -184, 
       -172,  -167,     0,  -159,     0,     0,  -172,   -42,     0,     0, 
       -218,     8,   -12,   -39,  -233,  -200,     0,  -172,   -36,     0, 
          0,  -206,     0,     0,   -35,  -198,     0,     0,     0,    33, 
          0,     0,     0,     0,   -29,   -49,  -218,  -179,     0,   -31, 
       -167,   -22,     0,     8,     0,     0,   -41,     0,    42,     0, 
          0,    20,     0,  -153,  -155,     0,    56,     0,     0,    -5, 
          0,     0,  -144,    22,  -218,     0,  -145,    58,    -4,  -218, 
       -143,  -218,     0,   -34,     0,     0,  -218,     0,     0,    -3, 
          0,     0,     0,  -140,     0,     0,  -218,     0, 
    );
    protected static $yyRindex= array(          125,
        -13,     0,     0,     0,     0,     0,     0,     0,     0,   126, 
        127,   128,     0,     0,     0,  -190,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,   129,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
        130,     0,     0,     0,     0,     0,     0,     0,    48,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    49,     0,     0,     0,     0,    50,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,    49,     0,     0,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,   121,   106,    -9,     0,    79,     0,    57,     0,   -46, 
        122,     4,   110,    24,    -1,   101,     0,   -51,     0, 
    );
    protected static $yyTable = array(71,
         66,    36,    30,    16,    48,    73,    92,    36,    36,    29, 
         72,    61,    48,    27,    27,    35,    37,    21,    22,    49, 
         34,    36,    53,    55,    29,    23,    52,    68,    85,    16, 
         36,    34,    94,    89,    28,    91,    69,    93,    38,    39, 
         95,    30,    40,    41,    42,    36,     1,    45,    47,    28, 
         98,     2,    54,     3,     4,     5,     6,     7,     8,     1, 
         76,     1,    83,    77,     2,    84,     3,     4,     5,    38, 
          7,     8,    57,    65,    23,     1,    23,    23,    23,    67, 
         23,    23,     3,     4,     5,    25,     7,     1,    18,    51, 
         16,    18,    51,    16,     3,     4,     5,     2,     7,     3, 
          4,     5,    75,     7,     8,    32,    78,     3,     4,     5, 
         79,     7,     8,    58,    59,    60,    80,    81,    87,    82, 
         88,    96,    90,    97,     6,     3,     4,     5,     2,     1, 
         26,    51,    70,    86,    50,    33,    56,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,    38,    39,     0,     0,    40, 
         41,    42,    38,    39,     0,     0,    40,    41,    42,    58, 
         59,    60, 
    );
    protected static $yyCheck = array(41,
         47,    44,    12,     0,    44,    57,    41,    44,    44,    11, 
         57,    41,    44,    10,    11,    17,    59,    61,   259,    59, 
         17,    44,    59,    59,    26,   259,    28,    59,    75,    26, 
         44,    28,    84,    80,    11,    82,    59,    84,   257,   258, 
         87,    51,   261,   262,   263,    59,   260,    40,    61,    26, 
         97,   265,   259,   267,   268,   269,   270,   271,   272,   260, 
         41,   260,    41,    44,   265,    44,   267,   268,   269,   260, 
        271,   272,    40,   123,   265,   260,   267,   268,   269,   259, 
        271,   272,   267,   268,   269,   270,   271,   260,    41,    41, 
         41,    44,    44,    44,   267,   268,   269,   265,   271,   267, 
        268,   269,    61,   271,   272,   265,   260,   267,   268,   269, 
        266,   271,   272,   259,   260,   261,    61,   123,    61,   264, 
        125,   125,   266,   264,     0,     0,     0,     0,     0,     0, 
         10,    26,    54,    77,    25,    14,    36,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,   257,   258,    -1,    -1,   261, 
        262,   263,   257,   258,    -1,    -1,   261,   262,   263,   259, 
        260,   261, 
    );
    protected static $yyFinal= 9;
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
      'T_DOUBLE_ARROW', 'T_FUNCTION', 'T_FUNCTION_BODY', 'T_PUBLIC', 
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

    case 1:  #line 27 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setConstants($yyVals[-2+$yyTop]); $yyVal->setMembers($yyVals[-1+$yyTop]); $yyVal->setMethods($yyVals[0+$yyTop]); } break;

    case 2:  #line 28 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setConstants($yyVals[-1+$yyTop]); $yyVal->setMembers($yyVals[0+$yyTop]); } break;

    case 3:  #line 29 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setConstants($yyVals[0+$yyTop]); } break;

    case 4:  #line 30 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setMembers($yyVals[0+$yyTop]); } break;

    case 5:  #line 31 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setMethods($yyVals[0+$yyTop]); } break;

    case 6:  #line 32 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); } break;

    case 7:  #line 36 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 8:  #line 37 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 9:  #line 41 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethod($yyVals[-4+$yyTop]->getValue()); isset($yyVals[-6+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-6+$yyTop]['abstract']); isset($yyVals[-6+$yyTop]['scope']) && $yyVal->setScope($yyVals[-6+$yyTop]['scope']); isset($yyVals[-6+$yyTop]['static']) && $yyVal->setStatic($yyVals[-6+$yyTop]['static']);  $yyVal->setParams($yyVals[-3+$yyTop]);  $yyVal->setContent($yyVals[-1+$yyTop]->getValue());  } break;

    case 10:  #line 42 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethod($yyVals[-4+$yyTop]->getValue()); $yyVal->setParams($yyVals[-3+$yyTop]);  $yyVal->setContent($yyVals[-1+$yyTop]->getValue()); } break;

    case 11:  #line 46 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 12:  #line 47 "grammar/Class.jay"
    { $yyVal= array(); } break;

    case 13:  #line 51 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 14:  #line 52 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 15:  #line 56 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1), $yyVals[-3+$yyTop]); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 16:  #line 57 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 17:  #line 58 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1)); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 18:  #line 59 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 19:  #line 63 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 20:  #line 64 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 21:  #line 68 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 22:  #line 69 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 23:  #line 73 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 24:  #line 74 "grammar/Class.jay"
    { $yyVal= array('abstract' => TRUE); } break;

    case 25:  #line 78 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-3+$yyTop], $yyVals[-1+$yyTop]); } break;

    case 26:  #line 79 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 27:  #line 83 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][]= new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue()); $yyVal= $yyVals[-4+$yyTop]; } break;

    case 28:  #line 84 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue())); } break;

    case 29:  #line 88 "grammar/Class.jay"
    { foreach($yyVals[-1+$yyTop] as $m) { isset($yyVals[-2+$yyTop]['static']) && $m->setStatic($yyVals[-2+$yyTop]['static']); isset($yyVals[-2+$yyTop]['scope']) && $m->setScope($yyVals[-2+$yyTop]['scope']); } $yyVal= array_merge($yyVals[-3+$yyTop],$yyVals[-1+$yyTop]); } break;

    case 30:  #line 89 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-2+$yyTop], $yyVals[-1+$yyTop]); } break;

    case 31:  #line 90 "grammar/Class.jay"
    { foreach($yyVals[-1+$yyTop] as $m) { isset($yyVals[-2+$yyTop]['static']) && $m->setStatic($yyVals[-2+$yyTop]['static']); isset($yyVals[-2+$yyTop]['scope']) && $m->setScope($yyVals[-2+$yyTop]['scope']); } $yyVal= $yyVals[-1+$yyTop]; } break;

    case 32:  #line 91 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 33:  #line 95 "grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop];} break;

    case 34:  #line 96 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 35:  #line 100 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[-2+$yyTop]->getValue(), 1), NULL, $yyVals[0+$yyTop]); } break;

    case 36:  #line 101 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 37:  #line 105 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 38:  #line 106 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 39:  #line 110 "grammar/Class.jay"
    { $yyVal= array('scope' => $yyVals[0+$yyTop]); } break;

    case 40:  #line 111 "grammar/Class.jay"
    { $yyVal= array('static' => TRUE); } break;

    case 41:  #line 115 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PUBLIC; } break;

    case 42:  #line 116 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PRIVATE; } break;

    case 43:  #line 117 "grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PROTECTED; } break;

    case 44:  #line 121 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 45:  #line 122 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 46:  #line 123 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 47:  #line 124 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 48:  #line 128 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-2+$yyTop]); } break;

    case 49:  #line 129 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-1+$yyTop]); } break;

    case 50:  #line 130 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array(); } break;

    case 51:  #line 131 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 52:  #line 135 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][$yyVals[-2+$yyTop]]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-4+$yyTop]; } break;

    case 53:  #line 136 "grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 54:  #line 137 "grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 55:  #line 138 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;
#line 504 "-"
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
