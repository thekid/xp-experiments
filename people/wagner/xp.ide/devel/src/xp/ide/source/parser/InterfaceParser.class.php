<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  $package= 'xp.ide.source.parser';

#line 2 "grammar/Interface.jay"

  uses(
    'xp.ide.source.Scope',
    'xp.ide.source.element.Classmethod',
    'xp.ide.source.element.Classconstant',
    'xp.ide.source.element.Classmethodparam',
    'xp.ide.source.element.Array',
    'xp.ide.source.element.BlockComment',
    'xp.ide.source.element.Apidoc'
  );

#line 21 "-"

  uses('xp.ide.source.parser.Parser');

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class xp·ide·source·parser·InterfaceParser extends xp·ide·source·parser·Parser {
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
          0,     0,     1,     1,     1,     1,     3,     3,     3,     3, 
          6,     4,     4,     8,     8,     7,     7,     9,     9,    10, 
         10,    11,    11,    11,     2,    13,    13,     5,     5,    14, 
         14,    14,    14,    15,    15,    15,    15,    12,    12,    12, 
         12,    16,    16,    16,    16, 
    );
    protected static $yyLen= array(2,
          0,     1,     2,     2,     1,     1,     3,     2,     2,     1, 
          4,     4,     3,     2,     1,     2,     3,     3,     1,     4, 
          2,     0,     1,     1,     3,     5,     3,     2,     1,     1, 
          1,     1,     1,     1,     1,     1,     1,     5,     4,     3, 
          1,     5,     3,     3,     1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,    32,    33,     0,    31,    30,     0,     0,     5, 
          6,     0,     0,    10,    29,     0,     0,     0,     0,     3, 
          4,     0,     8,     9,    28,     0,     0,    13,    15,     0, 
          0,    25,     0,     7,    23,    24,    16,     0,    19,     0, 
         11,    12,    14,    34,    36,     0,    35,    37,    27,    41, 
          0,    17,     0,     0,     0,     0,    18,     0,    40,    45, 
          0,     0,    26,    20,     0,    39,     0,    44,    38,    43, 
          0,     0,    42, 
    );
    protected static $yyDgoto= array(8,
          9,    10,    11,    12,    13,    14,    27,    30,    38,    39, 
         40,    49,    19,    15,    50,    62, 
    );
    protected static $yySindex = array(         -251,
       -249,  -234,     0,     0,  -208,     0,     0,     0,  -251,     0, 
          0,  -257,  -257,     0,     0,    12,  -222,    -8,   -39,     0, 
          0,  -257,     0,     0,     0,   -29,    -5,     0,     0,  -220, 
       -226,     0,  -204,     0,     0,     0,     0,   -35,     0,  -203, 
          0,     0,     0,     0,     0,    16,     0,     0,     0,     0, 
         -2,     0,  -215,     2,   -41,  -226,     0,  -226,     0,     0, 
       -206,    -3,     0,     0,  -226,     0,   -34,     0,     0,     0, 
       -202,  -226,     0, 
    );
    protected static $yyRindex= array(           60,
          0,     0,     0,     0,     0,     0,     0,     0,    61,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,  -196,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,  -196,    -1,     0,     0,     0,     0,     0,     0, 
          1,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          1,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,    56,    57,     0,    55,    17,     0,     0,     0,    15, 
          0,   -54,     0,    11,   -52,     0, 
    );
    protected static $yyTable = array(59,
         60,    63,    61,    64,    33,    52,    69,     1,    53,    16, 
         68,    37,    70,     1,    71,     2,     3,    73,     4,    32, 
          6,     7,     3,    25,     4,     5,     6,     7,    23,    24, 
         44,    45,    25,    17,    46,    47,    48,    66,    34,    21, 
         67,    41,    21,    35,    41,    36,    28,    29,    42,    43, 
         18,    26,    31,    41,    51,    55,    54,    65,    56,     1, 
          2,    72,    58,    22,    20,    21,    22,    57,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,    44,    45,     0,     0,    46, 
         47,    48,    44,    45,     0,     0,    46,    47,    48,    35, 
          0,    36, 
    );
    protected static $yyCheck = array(41,
         55,    56,    55,    58,    44,    41,    41,   265,    44,   259, 
         65,    41,    67,   265,    67,   267,   274,    72,   276,    59, 
        278,   279,   274,    13,   276,   277,   278,   279,    12,    13, 
        257,   258,    22,   268,   261,   262,   263,    41,    22,    41, 
         44,    41,    44,   259,    44,   261,   269,   270,   269,   270, 
        259,    40,    61,    59,   259,    40,   260,   264,    61,     0, 
          0,   264,    61,   260,     9,     9,    12,    53,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,   257,   258,    -1,    -1,   261, 
        262,   263,   257,   258,    -1,    -1,   261,   262,   263,   259, 
         -1,   261, 
    );
    protected static $yyFinal= 8;
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
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_ENCAPSED_STRING', 
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

    case 1:  #line 26 "grammar/Interface.jay"
    { $yyVal= $this->top_element; } break;

    case 2:  #line 27 "grammar/Interface.jay"
    { $yyVal= $this->top_element; } break;

    case 3:  #line 31 "grammar/Interface.jay"
    { $yyVal= $this->top_element; $t= $yyVal->getConstants(); $yyVal->setConstants(array_merge($t, $yyVals[0+$yyTop])); } break;

    case 4:  #line 32 "grammar/Interface.jay"
    { $yyVal= $this->top_element; $t= $yyVal->getMethods(); $t[]= $yyVals[0+$yyTop]; $yyVal->setMethods($t); } break;

    case 5:  #line 33 "grammar/Interface.jay"
    { $yyVal= $this->top_element; $yyVal->setConstants($yyVals[0+$yyTop]); } break;

    case 6:  #line 34 "grammar/Interface.jay"
    { $yyVal= $this->top_element; $yyVal->setMethods(array($yyVals[0+$yyTop])); } break;

    case 7:  #line 38 "grammar/Interface.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-2+$yyTop]);
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 8:  #line 45 "grammar/Interface.jay"
    { $yyVal= $yyVals[0+$yyTop]; $yyVal->setApidoc($yyVals[-1+$yyTop]); } break;

    case 9:  #line 46 "grammar/Interface.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    isset($yyVals[-1+$yyTop]['abstract']) && $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    isset($yyVals[-1+$yyTop]['scope'])    && $yyVal->setScope($yyVals[-1+$yyTop]['scope']);
    isset($yyVals[-1+$yyTop]['static'])   && $yyVal->setStatic($yyVals[-1+$yyTop]['static']);
  } break;

    case 10:  #line 52 "grammar/Interface.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 11:  #line 56 "grammar/Interface.jay"
    {
    $yyVal= new xp·ide·source·element·Classmethod($yyVals[-2+$yyTop]->getValue());
    $yyVal->setParams($yyVals[-1+$yyTop]);
  } break;

    case 12:  #line 63 "grammar/Interface.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-2+$yyTop]->getValue()); $yyVal->setDirectives($yyVals[-1+$yyTop]); } break;

    case 13:  #line 64 "grammar/Interface.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 14:  #line 67 "grammar/Interface.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue()); } break;

    case 15:  #line 68 "grammar/Interface.jay"
    { $yyVal= array(new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue())); } break;

    case 16:  #line 72 "grammar/Interface.jay"
    { $yyVal= array(); } break;

    case 17:  #line 73 "grammar/Interface.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 18:  #line 76 "grammar/Interface.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 19:  #line 77 "grammar/Interface.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 20:  #line 80 "grammar/Interface.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[-2+$yyTop]->getValue(), 1), $yyVals[-3+$yyTop]); $yyVal->setInit($yyVals[0+$yyTop]); } break;

    case 21:  #line 81 "grammar/Interface.jay"
    { $yyVal= new xp·ide·source·element·Classmethodparam(substr($yyVals[0+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 22:  #line 85 "grammar/Interface.jay"
    { $yyVal= NULL; } break;

    case 23:  #line 86 "grammar/Interface.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 24:  #line 87 "grammar/Interface.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 25:  #line 91 "grammar/Interface.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 26:  #line 94 "grammar/Interface.jay"
    { $yyVals[-4+$yyTop][]= new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue()); $yyVal= $yyVals[-4+$yyTop]; } break;

    case 27:  #line 95 "grammar/Interface.jay"
    { $yyVal= array(new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue())); } break;

    case 28:  #line 99 "grammar/Interface.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 29:  #line 100 "grammar/Interface.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 30:  #line 103 "grammar/Interface.jay"
    { $yyVal= array('abstract' => TRUE); } break;

    case 31:  #line 104 "grammar/Interface.jay"
    { $yyVal= array('static' => TRUE); } break;

    case 32:  #line 105 "grammar/Interface.jay"
    { $yyVal= array('scope' => xp·ide·source·Scope::$PUBLIC); } break;

    case 33:  #line 106 "grammar/Interface.jay"
    { $yyVal= array('scope' => xp·ide·source·Scope::$PROTECTED); } break;

    case 34:  #line 110 "grammar/Interface.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 35:  #line 111 "grammar/Interface.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 36:  #line 112 "grammar/Interface.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 37:  #line 113 "grammar/Interface.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 38:  #line 117 "grammar/Interface.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-2+$yyTop]); } break;

    case 39:  #line 118 "grammar/Interface.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-1+$yyTop]); } break;

    case 40:  #line 119 "grammar/Interface.jay"
    { $yyVal= new xp·ide·source·element·Array(); } break;

    case 41:  #line 120 "grammar/Interface.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 42:  #line 124 "grammar/Interface.jay"
    { $yyVals[-4+$yyTop][$yyVals[-2+$yyTop]]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-4+$yyTop]; } break;

    case 43:  #line 125 "grammar/Interface.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 44:  #line 126 "grammar/Interface.jay"
    { $yyVal= array($yyVals[-2+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 45:  #line 127 "grammar/Interface.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;
#line 491 "-"
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
