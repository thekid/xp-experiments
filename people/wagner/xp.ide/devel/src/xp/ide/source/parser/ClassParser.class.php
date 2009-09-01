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
    const T_VAR= 280;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     1,     1,     1,     1,     1,     1,     4,     4, 
          4,     4,     4,     4,     4,     4,     8,     6,    10,    10, 
         11,    11,    11,    12,    12,    13,    13,     5,     5,    14, 
         14,     9,     9,    15,    15,    16,    16,    17,    17,    17, 
          2,    19,    19,     3,     3,    20,    20,    21,    21,     7, 
          7,    22,    22,    22,    22,    22,    23,    23,    23,    23, 
         18,    18,    18,    18,    24,    24,    24,    24, 
    );
    protected static $yyLen= array(2,
          0,     1,     2,     2,     2,     1,     1,     1,     4,     3, 
          3,     3,     2,     2,     2,     1,     6,     3,     3,     1, 
          4,     3,     1,     3,     1,     3,     1,     4,     3,     2, 
          1,     2,     3,     3,     1,     4,     2,     0,     1,     1, 
          3,     5,     3,     3,     3,     1,     3,     3,     1,     2, 
          1,     1,     1,     1,     1,     1,     1,     1,     1,     1, 
          5,     4,     3,     1,     5,     3,     3,     1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,    54,    55,    56,     0,    53,    52,     0, 
          0,     0,     6,     7,     8,     0,     0,     0,    16,    51, 
          0,     0,     0,     0,    20,     0,     0,     0,     0,    46, 
          3,     4,     5,     0,     0,    13,     0,    15,    14,     0, 
         50,     0,     0,    29,    31,     0,     0,    18,     0,     0, 
          0,    41,     0,     0,    45,     0,    11,    10,    12,    44, 
         39,    40,    32,     0,    35,     0,     0,    28,    30,    27, 
          0,    22,     0,    25,    19,    57,    59,     0,    58,    60, 
         43,    64,     0,    48,    47,     9,     0,    33,     0,     0, 
          0,     0,    21,     0,     0,    34,     0,    17,    26,    24, 
         63,    68,     0,     0,    42,    36,     0,     0,    62,    67, 
         61,    66,     0,     0,    65, 
    );
    protected static $yyDgoto= array(11,
         12,    13,    14,    15,    16,    17,    18,    19,    43,    24, 
         25,    73,    74,    46,    64,    65,    66,    81,    27,    29, 
         30,    20,    82,   104, 
    );
    protected static $yySindex = array(         -206,
       -254,  -255,  -224,     0,     0,     0,  -204,     0,     0,  -198, 
          0,  -206,     0,     0,     0,  -190,  -183,  -246,     0,     0, 
         26,  -193,    27,   -44,     0,    22,   -33,    29,   -28,     0, 
          0,     0,     0,  -183,  -183,     0,  -183,     0,     0,   -22, 
          0,   -26,   -36,     0,     0,  -191,   -23,     0,  -224,  -160, 
       -179,     0,  -160,  -198,     0,  -183,     0,     0,     0,     0, 
          0,     0,     0,   -32,     0,  -166,  -167,     0,     0,     0, 
         39,     0,   -24,     0,     0,     0,     0,    64,     0,     0, 
          0,     0,    44,     0,     0,     0,  -211,     0,    45,   -18, 
       -149,  -203,     0,   -39,  -160,     0,  -160,     0,     0,     0, 
          0,     0,  -155,    -3,     0,     0,  -160,   -31,     0,     0, 
          0,     0,  -154,  -160,     0, 
    );
    protected static $yyRindex= array(          111,
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,   112,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,   -43,     0,     0,     0,     0,    -8,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,  -147,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,  -147,     0,    -1,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    19,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    19,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,   102,   103,   104,     0,   101,    18,   -10,     0,     0, 
         69,     0,    28,     0,     0,    32,     0,   -50,     0,   105, 
         67,   -14,   -55,     0, 
    );
    protected static $yyTable = array(49,
         23,   101,    84,    41,    21,    36,    38,    39,    88,   111, 
         51,    87,    22,    28,    63,    54,    93,    72,     1,    92, 
         41,    54,    41,    57,    58,    52,    59,     4,     5,     6, 
         55,     8,     9,    35,    37,    49,    60,   109,   103,    37, 
        108,    41,    37,   102,   105,    86,   106,    61,    23,    62, 
         49,    56,   113,    70,    26,    71,   110,   112,     1,    64, 
          2,    28,    64,   115,     3,    42,    47,     4,     5,     6, 
          7,     8,     9,    10,     1,    44,    45,    68,    69,    83, 
          3,     1,    50,     4,     5,     6,    67,     8,     9,    53, 
          4,     5,     6,    89,     8,     9,    76,    77,    90,    91, 
         78,    79,    80,    94,    95,    97,    98,    99,   107,   114, 
          1,     2,    38,    31,    32,    33,    34,    75,    96,   100, 
         85,     0,    40,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    76,    77,     0, 
          0,    78,    79,    80,     0,    76,    77,    48,    23,    78, 
         79,    80,    61,    70,    62,    71, 
    );
    protected static $yyCheck = array(44,
         44,    41,    53,    18,   259,    16,    17,    18,    41,    41, 
         44,    44,   268,   260,    41,    44,    41,    41,   265,    44, 
         35,    44,    37,    34,    35,    59,    37,   274,   275,   276, 
         59,   278,   279,    16,    17,    44,    59,    41,    94,    41, 
         44,    56,    44,    94,    95,    56,    97,   259,   273,   261, 
         59,    34,   108,   257,   259,   259,   107,   108,   265,    41, 
        267,   260,    44,   114,   271,    40,    40,   274,   275,   276, 
        277,   278,   279,   280,   265,   269,   270,   269,   270,   259, 
        271,   265,    61,   274,   275,   276,   123,   278,   279,    61, 
        274,   275,   276,   260,   278,   279,   257,   258,   266,    61, 
        261,   262,   263,    40,    61,    61,   125,   257,   264,   264, 
          0,     0,   260,    12,    12,    12,    16,    49,    87,    92, 
         54,    -1,    18,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,   257,   258,    -1, 
         -1,   261,   262,   263,    -1,   257,   258,   272,   272,   261, 
        262,   263,   259,   257,   261,   259, 
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
      'T_PRIVATE', 'T_PROTECTED', 'T_CONST', 'T_STATIC', 'T_ABSTRACT', 'T_VAR', 
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
    { $yyVal= $this->top_element; } break;

    case 2:  #line 30 "grammar/Class.jay"
    { $yyVal= $this->top_element; } break;

    case 3:  #line 34 "grammar/Class.jay"
    { $yyVal= $this->top_element; $t= $yyVal->getConstants(); $yyVal->setConstants(array_merge($t, $yyVals[0+$yyTop])); } break;

    case 4:  #line 35 "grammar/Class.jay"
    { $yyVal= $this->top_element; $t= $yyVal->getMembergroups(); $t[]= $yyVals[0+$yyTop]; $yyVal->setMembergroups($t); } break;

    case 5:  #line 36 "grammar/Class.jay"
    { $yyVal= $this->top_element; $t= $yyVal->getMethods(); $t[]= $yyVals[0+$yyTop]; $yyVal->setMethods($t); } break;

    case 6:  #line 37 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setConstants($yyVals[0+$yyTop]); } break;

    case 7:  #line 38 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setMembergroups(array($yyVals[0+$yyTop])); } break;

    case 8:  #line 39 "grammar/Class.jay"
    { $yyVal= $this->top_element; $yyVal->setMethods(array($yyVals[0+$yyTop])); } break;

    case 9:  #line 43 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-3+$yyTop]);
    $yyVal->setAnnotations($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 10:  #line 51 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 11:  #line 58 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; $yyVal->setApidoc($yyVals[-2+$yyTop]); $yyVal->setAnnotations($yyVals[-1+$yyTop]); } break;

    case 12:  #line 59 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setAnnotations($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 13:  #line 66 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; $yyVal->setApidoc($yyVals[-1+$yyTop]); } break;

    case 14:  #line 67 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 15:  #line 73 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop];  $yyVal->setAnnotations($yyVals[-1+$yyTop]); } break;

    case 16:  #line 74 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 17:  #line 78 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmethod($yyVals[-4+$yyTop]->getValue());
    $yyVal->setParams($yyVals[-3+$yyTop]);
    $yyVal->setContent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 18:  #line 86 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop];} break;

    case 19:  #line 89 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 20:  #line 90 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 21:  #line 93 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-3+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 22:  #line 94 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-2+$yyTop]->getValue(), 1)); } break;

    case 23:  #line 95 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 24:  #line 98 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; list($k, $v)= each($yyVals[0+$yyTop]); $yyVal[$k]= $v; } break;

    case 25:  #line 99 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 26:  #line 102 "grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop]->getValue() => $this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 27:  #line 103 "grammar/Class.jay"
    { $yyVal= array($this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 28:  #line 107 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-2+$yyTop]->getValue()); $yyVal->setDirectives($yyVals[-1+$yyTop]); } break;

    case 29:  #line 108 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 30:  #line 111 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue()); } break;

    case 31:  #line 112 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue())); } break;

    case 32:  #line 116 "grammar/Class.jay"
    { $yyVal= array(); } break;

    case 33:  #line 117 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 34:  #line 120 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 35:  #line 121 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 36:  #line 124 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1), $yyVals[-3+$yyTop]); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 37:  #line 125 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 38:  #line 129 "grammar/Class.jay"
    { $yyVal= NULL; } break;

    case 39:  #line 130 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 40:  #line 131 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 41:  #line 135 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 42:  #line 138 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][]= new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue()); $yyVal= $yyVals[-4+$yyTop]; } break;

    case 43:  #line 139 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue())); } break;

    case 44:  #line 143 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmembergroup();
    isset($yyVals[-2+$yyTop]['static']) && $yyVal->setStatic($yyVals[-2+$yyTop]['static']);
    isset($yyVals[-2+$yyTop]['scope'])  && $yyVal->setScope($yyVals[-2+$yyTop]['scope']);
    $yyVal->setMembers($yyVals[-1+$yyTop]);
  } break;

    case 45:  #line 149 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmembergroup();
    $yyVal->setMembers($yyVals[-1+$yyTop]);
  } break;

    case 46:  #line 155 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 47:  #line 156 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop];} break;

    case 48:  #line 159 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[-2+$yyTop]->getValue(), 1), $yyVals[0+$yyTop]); } break;

    case 49:  #line 160 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 50:  #line 164 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 51:  #line 165 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 52:  #line 168 "grammar/Class.jay"
    { $yyVal= array('abstract' => TRUE); } break;

    case 53:  #line 169 "grammar/Class.jay"
    { $yyVal= array('static' => TRUE); } break;

    case 54:  #line 170 "grammar/Class.jay"
    { $yyVal= array('scope' => xp·ide·source·Scope::$PUBLIC); } break;

    case 55:  #line 171 "grammar/Class.jay"
    { $yyVal= array('scope' => xp·ide·source·Scope::$PRIVATE); } break;

    case 56:  #line 172 "grammar/Class.jay"
    { $yyVal= array('scope' => xp·ide·source·Scope::$PROTECTED); } break;

    case 57:  #line 176 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 58:  #line 177 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 59:  #line 178 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 60:  #line 179 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 61:  #line 183 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-2+$yyTop]); } break;

    case 62:  #line 184 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-1+$yyTop]); } break;

    case 63:  #line 185 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array(); } break;

    case 64:  #line 186 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 65:  #line 190 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][$yyVals[-2+$yyTop]]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-4+$yyTop]; } break;

    case 66:  #line 191 "grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 67:  #line 192 "grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 68:  #line 193 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;
#line 601 "-"
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
