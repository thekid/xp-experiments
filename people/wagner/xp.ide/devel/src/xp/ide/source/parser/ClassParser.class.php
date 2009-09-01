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
    const T_FINAL= 281;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     1,     1,     1,     1,     1,     1,     4,     4, 
          4,     4,     4,     4,     4,     4,     8,     6,    10,    10, 
         11,    11,    11,    12,    12,    13,    13,     5,     5,    14, 
         14,     9,     9,    15,    15,    16,    16,    17,    17,    17, 
          2,    19,    19,     3,     3,    20,    20,    21,    21,     7, 
          7,    22,    22,    22,    22,    22,    22,    23,    23,    23, 
         23,    18,    18,    18,    18,    24,    24,    24,    24, 
    );
    protected static $yyLen= array(2,
          0,     1,     2,     2,     2,     1,     1,     1,     4,     3, 
          3,     3,     2,     2,     2,     1,     6,     3,     3,     1, 
          4,     3,     1,     3,     1,     3,     1,     4,     3,     2, 
          1,     2,     3,     3,     1,     4,     2,     0,     1,     1, 
          3,     5,     3,     3,     3,     1,     3,     3,     1,     2, 
          1,     1,     1,     1,     1,     1,     1,     1,     1,     1, 
          1,     5,     4,     3,     1,     5,     3,     3,     1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,    55,    56,    57,     0,    54,    52,     0, 
         53,     0,     0,     6,     7,     8,     0,     0,     0,    16, 
         51,     0,     0,     0,     0,    20,     0,     0,     0,     0, 
         46,     3,     4,     5,     0,     0,    13,     0,    15,    14, 
          0,    50,     0,     0,    29,    31,     0,     0,    18,     0, 
          0,     0,    41,     0,     0,    45,     0,    11,    10,    12, 
         44,    39,    40,    32,     0,    35,     0,     0,    28,    30, 
         27,     0,    22,     0,    25,    19,    58,    60,     0,    59, 
         61,    43,    65,     0,    48,    47,     9,     0,    33,     0, 
          0,     0,     0,    21,     0,     0,    34,     0,    17,    26, 
         24,    64,    69,     0,     0,    42,    36,     0,     0,    63, 
         68,    62,    67,     0,     0,    66, 
    );
    protected static $yyDgoto= array(12,
         13,    14,    15,    16,    17,    18,    19,    20,    44,    25, 
         26,    74,    75,    47,    65,    66,    67,    82,    28,    30, 
         31,    21,    83,   105, 
    );
    protected static $yySindex = array(         -206,
       -254,  -255,  -253,     0,     0,     0,  -228,     0,     0,  -222, 
          0,     0,  -206,     0,     0,     0,  -189,  -226,  -246,     0, 
          0,     3,  -203,    22,   -44,     0,    18,   -33,    34,   -22, 
          0,     0,     0,     0,  -226,  -226,     0,  -226,     0,     0, 
         -8,     0,   -26,   -27,     0,     0,  -186,   -23,     0,  -253, 
       -164,  -155,     0,  -164,  -222,     0,  -226,     0,     0,     0, 
          0,     0,     0,     0,   -32,     0,  -154,  -161,     0,     0, 
          0,    46,     0,    19,     0,     0,     0,     0,    68,     0, 
          0,     0,     0,    48,     0,     0,     0,  -159,     0,    49, 
        -14,  -145,  -156,     0,   -39,  -164,     0,  -164,     0,     0, 
          0,     0,     0,  -151,    36,     0,     0,  -164,   -31,     0, 
          0,     0,     0,  -150,  -164,     0, 
    );
    protected static $yyRindex= array(          115,
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,   116,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,   -43,     0,     0,     0,     0,    -3,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,  -143,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,  -143,     0,    37, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,    47,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,    47,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,   105,   106,   107,     0,   104,    -1,   -11,     0,     0, 
         72,     0,    30,     0,     0,    38,     0,   -51,     0,   108, 
         69,   -15,   -55,     0, 
    );
    protected static $yyTable = array(50,
         23,   102,    85,    42,    22,    37,    39,    40,    89,   112, 
         52,    88,    23,    29,    64,    36,    38,    73,     1,    24, 
         42,    55,    42,    58,    59,    53,    60,     4,     5,     6, 
         27,     8,     9,    57,    11,    55,    56,    29,     1,   104, 
         49,    42,    43,   103,   106,    87,   107,     4,     5,     6, 
         61,     8,     9,   114,    11,    49,   111,   113,     1,    94, 
          2,    48,    93,   116,     3,    45,    46,     4,     5,     6, 
          7,     8,     9,    10,    11,     1,   110,    37,    51,   109, 
         37,     3,    69,    70,     4,     5,     6,    65,     8,     9, 
         65,    11,    77,    78,    54,    68,    79,    80,    81,    62, 
         71,    63,    72,    84,    91,    90,    92,    95,    96,    98, 
         99,   100,   108,   115,     1,     2,    38,    32,    33,    34, 
         35,    76,   101,    86,     0,    97,    41,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    77,    78,     0, 
          0,    79,    80,    81,     0,    77,    78,    49,    23,    79, 
         80,    81,    62,    71,    63,    72, 
    );
    protected static $yyCheck = array(44,
         44,    41,    54,    19,   259,    17,    18,    19,    41,    41, 
         44,    44,   268,   260,    41,    17,    18,    41,   265,   273, 
         36,    44,    38,    35,    36,    59,    38,   274,   275,   276, 
        259,   278,   279,    35,   281,    44,    59,   260,   265,    95, 
         44,    57,    40,    95,    96,    57,    98,   274,   275,   276, 
         59,   278,   279,   109,   281,    59,   108,   109,   265,    41, 
        267,    40,    44,   115,   271,   269,   270,   274,   275,   276, 
        277,   278,   279,   280,   281,   265,    41,    41,    61,    44, 
         44,   271,   269,   270,   274,   275,   276,    41,   278,   279, 
         44,   281,   257,   258,    61,   123,   261,   262,   263,   259, 
        257,   261,   259,   259,   266,   260,    61,    40,    61,    61, 
        125,   257,   264,   264,     0,     0,   260,    13,    13,    13, 
         17,    50,    93,    55,    -1,    88,    19,    -1,    -1,    -1, 
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
    protected static $yyFinal= 12;
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
      'T_FINAL', 
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
    isset($yyVals[-1+$yyTop]['final'])    && $yyVal->setFinal($yyVals[-1+$yyTop]['final']);
  } break;

    case 10:  #line 52 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
    isset($yyVals[-1+$yyTop]['final'])    && $yyVal->setFinal($yyVals[-1+$yyTop]['final']);
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
    isset($yyVals[-1+$yyTop]['final'])    && $yyVal->setFinal($yyVals[-1+$yyTop]['final']);
  } break;

    case 13:  #line 69 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; $yyVal->setApidoc($yyVals[-1+$yyTop]); } break;

    case 14:  #line 70 "grammar/Class.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
    isset($yyVals[-1+$yyTop]['final'])    && $yyVal->setFinal($yyVals[-1+$yyTop]['final']);
  } break;

    case 15:  #line 77 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop];  $yyVal->setAnnotations($yyVals[-1+$yyTop]); } break;

    case 16:  #line 78 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 17:  #line 82 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmethod($yyVals[-4+$yyTop]->getValue());
    $yyVal->setParams($yyVals[-3+$yyTop]);
    $yyVal->setContent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 18:  #line 90 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop];} break;

    case 19:  #line 93 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 20:  #line 94 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 21:  #line 97 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-3+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 22:  #line 98 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-2+$yyTop]->getValue(), 1)); } break;

    case 23:  #line 99 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 24:  #line 102 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; list($k, $v)= each($yyVals[0+$yyTop]); $yyVal[$k]= $v; } break;

    case 25:  #line 103 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 26:  #line 106 "grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop]->getValue() => $this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 27:  #line 107 "grammar/Class.jay"
    { $yyVal= array($this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 28:  #line 111 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-2+$yyTop]->getValue()); $yyVal->setDirectives($yyVals[-1+$yyTop]); } break;

    case 29:  #line 112 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 30:  #line 115 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue()); } break;

    case 31:  #line 116 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue())); } break;

    case 32:  #line 120 "grammar/Class.jay"
    { $yyVal= array(); } break;

    case 33:  #line 121 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 34:  #line 124 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 35:  #line 125 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 36:  #line 128 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1), $yyVals[-3+$yyTop]); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 37:  #line 129 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 38:  #line 133 "grammar/Class.jay"
    { $yyVal= NULL; } break;

    case 39:  #line 134 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 40:  #line 135 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 41:  #line 139 "grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 42:  #line 142 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][]= new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue()); $yyVal= $yyVals[-4+$yyTop]; } break;

    case 43:  #line 143 "grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue())); } break;

    case 44:  #line 147 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmembergroup();
    isset($yyVals[-2+$yyTop]['static']) && $yyVal->setStatic($yyVals[-2+$yyTop]['static']);
    isset($yyVals[-2+$yyTop]['scope'])  && $yyVal->setScope($yyVals[-2+$yyTop]['scope']);
    isset($yyVals[-2+$yyTop]['final'])  && $yyVal->setFinal($yyVals[-2+$yyTop]['final']);
    $yyVal->setMembers($yyVals[-1+$yyTop]);
  } break;

    case 45:  #line 154 "grammar/Class.jay"
    {
    $yyVal= new xp·ide·source·element·Classmembergroup();
    $yyVal->setMembers($yyVals[-1+$yyTop]);
  } break;

    case 46:  #line 160 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 47:  #line 161 "grammar/Class.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop];} break;

    case 48:  #line 164 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[-2+$yyTop]->getValue(), 1), $yyVals[0+$yyTop]); } break;

    case 49:  #line 165 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 50:  #line 169 "grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 51:  #line 170 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 52:  #line 173 "grammar/Class.jay"
    { $yyVal= array('abstract' => TRUE); } break;

    case 53:  #line 174 "grammar/Class.jay"
    { $yyVal= array('final' => TRUE); } break;

    case 54:  #line 175 "grammar/Class.jay"
    { $yyVal= array('static' => TRUE); } break;

    case 55:  #line 176 "grammar/Class.jay"
    { $yyVal= array('scope' => xp·ide·source·Scope::$PUBLIC); } break;

    case 56:  #line 177 "grammar/Class.jay"
    { $yyVal= array('scope' => xp·ide·source·Scope::$PRIVATE); } break;

    case 57:  #line 178 "grammar/Class.jay"
    { $yyVal= array('scope' => xp·ide·source·Scope::$PROTECTED); } break;

    case 58:  #line 182 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 59:  #line 183 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 60:  #line 184 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 61:  #line 185 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 62:  #line 189 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-2+$yyTop]); } break;

    case 63:  #line 190 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-1+$yyTop]); } break;

    case 64:  #line 191 "grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array(); } break;

    case 65:  #line 192 "grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 66:  #line 196 "grammar/Class.jay"
    { $yyVals[-4+$yyTop][$yyVals[-2+$yyTop]]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-4+$yyTop]; } break;

    case 67:  #line 197 "grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 68:  #line 198 "grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 69:  #line 199 "grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;
#line 611 "-"
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
