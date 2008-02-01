<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses('text.parser.generic.AbstractParser');

#line 2 "grammar/sieve.jay"
  uses(
    'peer.sieve.RuleSet',
    'peer.sieve.Rule',
    'peer.sieve.ActionFactory',
    'peer.sieve.AllOfCondition',
    'peer.sieve.NegationOfCondition',
    'peer.sieve.AnyOfCondition',
    'peer.sieve.HeaderCondition',
    'peer.sieve.SizeCondition',
    'peer.sieve.AddressCondition',
    'peer.sieve.BooleanCondition'
  );
#line 22 "-"
  define('TOKEN_T_WORD',  260);
  define('TOKEN_T_STRING',  261);
  define('TOKEN_T_NUMBER',  263);
  define('TOKEN_T_REQUIRE',  270);
  define('TOKEN_T_IF',  280);
  define('TOKEN_T_ELSE',  281);
  define('TOKEN_T_ELSEIF',  282);
  define('TOKEN_T_ALLOF',  290);
  define('TOKEN_T_ANYOF',  291);
  define('TOKEN_T_NOT',  292);
  define('TOKEN_T_HEADER',  300);
  define('TOKEN_T_SIZE',  301);
  define('TOKEN_T_ADDRESS',  302);
  define('TOKEN_T_TRUE',  303);
  define('TOKEN_T_FALSE',  304);
  define('TOKEN_T_COMPARATOR',  305);
  define('TOKEN_YY_ERRORCODE', 256);

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class SieveParser extends AbstractParser {
    protected static $yyLhs= array(-1,
          0,     1,     1,     3,     3,     4,     2,     2,     6,     6, 
          9,     7,     7,    11,    11,    11,    10,    10,    14,    12, 
         16,     8,    18,     8,    19,     8,    21,     8,    23,     8, 
         24,     8,     8,     8,    13,    13,    20,    20,    25,    25, 
         25,    17,    17,    15,    15,    22,    22,    26,    26,    26, 
          5,     5, 
    );
    protected static $yyLen= array(2,
          2,     0,     1,     1,     2,     5,     0,     1,     1,     2, 
          0,     7,     1,     0,     4,     6,     1,     2,     0,     5, 
          0,     5,     0,     5,     0,     3,     0,     4,     0,     5, 
          0,     4,     1,     1,     0,     1,     1,     2,     3,     3, 
          3,     1,     3,     0,     1,     1,     2,     1,     1,     3, 
          1,     3, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     3,     0,     0,    19,    11,     1,     8, 
          0,    13,     0,     5,     0,     0,     0,     0,    10,    18, 
          0,     0,     0,     0,    36,     0,    21,    23,    25,    27, 
          0,    31,    33,    34,     0,    52,     6,     0,     0,    48, 
         49,     0,     0,    45,     0,    38,     0,     0,     0,     0, 
          0,     0,     0,    39,    40,    41,     0,    20,    47,     0, 
          0,    26,     0,    29,     0,     0,    50,     0,     0,     0, 
         28,     0,    32,     0,     0,    22,    24,    30,     0,     0, 
         12,    43,     0,     0,     0,     0,    15,     0,     0,    16, 
    );
    protected static $yyDgoto= array(2,
          3,     9,     4,     5,    16,    10,    11,    68,    18,    12, 
         81,    13,    24,    17,    43,    47,    69,    48,    49,    25, 
         50,    44,    72,    52,    26,    45, 
    );
    protected static $yySindex = array(         -255,
        -71,     0,  -241,     0,  -255,  -239,     0,     0,     0,     0, 
       -241,     0,  -237,     0,   -23,   -69,   -30,  -240,     0,     0, 
       -239,   -29,  -248,   -84,     0,   -30,     0,     0,     0,     0, 
        -27,     0,     0,     0,   -94,     0,     0,   -58,  -229,     0, 
          0,  -239,   -25,     0,   -84,     0,     6,     7,  -240,   -30, 
       -224,   -30,  -237,     0,     0,     0,   -49,     0,     0,  -240, 
       -240,     0,   -84,     0,   -84,   -77,     0,     9,    13,    14, 
          0,  -207,     0,  -264,  -240,     0,     0,     0,   -65,  -240, 
          0,     0,  -237,   -64,   -60,  -237,     0,   -59,  -264,     0, 
    );
    protected static $yyRindex= array(            1,
          0,     0,    67,     0,     2,     0,     0,     0,     0,     0, 
         68,     0,     3,     0,   -24,     0,   -54,     0,     0,     0, 
          0,     0,     0,    11,     0,   -53,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,   -33,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    30,     0,     0, 
          0,     0,     0,     4,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     4,     0, 
    );
    protected static $yyGindex= array(0,
          0,     0,    69,     0,    -7,    62,     0,    -8,     0,    -4, 
        -14,     0,     0,     0,     0,     0,   -48,     0,     0,   -10, 
          0,   -20,     0,     0,    38,    39, 
    );
    protected static $yyTable = array(23,
          2,     4,    17,    14,    35,    37,    42,    46,    20,    35, 
         46,    38,    70,    36,     1,    46,    79,    80,     7,     6, 
         21,    15,     7,    22,    59,    46,    82,    23,    53,    37, 
         51,    56,    42,    58,    57,    64,    35,    37,     8,    63, 
         62,    65,    71,    67,    73,    60,    61,    74,    66,    27, 
         28,    29,    75,    76,    77,    78,    39,    83,    86,    30, 
         31,    32,    33,    34,    87,    89,     7,     9,    51,    44, 
         42,    84,    19,    14,    90,    54,    55,     0,    85,     0, 
          0,    88,     0,     0,     0,     0,     0,     0,     0,    46, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    17,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,    40,     0,    41,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    40,     0,    41,     0,    35,    37,    35,    37, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          2,     4,     0,    14,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          2,     4,    17,    14, 
    );
    protected static $yyCheck = array(58,
          0,     0,     0,     0,    59,    59,    91,    41,    13,    18, 
         44,   260,    61,    21,   270,    26,   281,   282,   260,    91, 
         44,   261,   260,    93,    45,    59,    75,    58,   123,    59, 
         58,   261,    91,    59,    42,   260,    91,    91,   280,    50, 
         49,    52,    63,    93,    65,    40,    40,   125,    53,   290, 
        291,   292,    44,    41,    41,   263,   305,   123,   123,   300, 
        301,   302,   303,   304,   125,   125,     0,     0,    93,    59, 
         41,    80,    11,     5,    89,    38,    38,    -1,    83,    -1, 
         -1,    86,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   123, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,   125,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,   261,    -1,   263,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,   261,    -1,   263,    -1,   261,   261,   263,   263, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
        260,   260,    -1,   260,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
        280,   280,   280,   280, 
    );
    protected static $yyFinal= 2;
    protected static $yyName= array(    
      'end-of-file', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      "'('", "')'", NULL, NULL, "','", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, "':'", "';'", NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, "'['", NULL, 
      "']'", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, "'{'", NULL, "'}'", NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, 'T_WORD', 'T_STRING', NULL, 'T_NUMBER', NULL, NULL, NULL, NULL, NULL, 
      NULL, 'T_REQUIRE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_IF', 
      'T_ELSE', 'T_ELSEIF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_ALLOF', 
      'T_ANYOF', 'T_NOT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_HEADER', 
      'T_SIZE', 'T_ADDRESS', 'T_TRUE', 'T_FALSE', 'T_COMPARATOR', 
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

    case 1:  #line 40 "grammar/sieve.jay"
    {
      $yyVal= new peer新ieve愛uleSet();
      $yyVal->required= $yyVals[-1+$yyTop];
      $yyVal->rules= $yyVals[0+$yyTop];
    } break;

    case 2:  #line 49 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 4:  #line 54 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 5:  #line 55 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 6:  #line 59 "grammar/sieve.jay"
    { $yyVal= $yyVals[-2+$yyTop]; } break;

    case 7:  #line 65 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 9:  #line 70 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 10:  #line 71 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 11:  #line 75 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new peer新ieve愛ule()); } break;

    case 12:  #line 75 "grammar/sieve.jay"
    {
      $yyVals[-6+$yyTop]->condition= $yyVals[-4+$yyTop];
      $yyVals[-6+$yyTop]->actions= $yyVals[-2+$yyTop];
    } break;

    case 13:  #line 79 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new peer新ieve愛ule());
      $yyVal->condition= NULL;
      $yyVal->actions= $yyVals[0+$yyTop];
    } break;

    case 14:  #line 88 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 17:  #line 95 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 18:  #line 96 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 19:  #line 100 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(ActionFactory::newAction($yyVals[0+$yyTop])); } break;

    case 20:  #line 100 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->tags= $yyVals[-2+$yyTop];
      $yyVals[-4+$yyTop]->arguments= $yyVals[-1+$yyTop];
    } break;

    case 21:  #line 109 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AllOfCondition()); } break;

    case 22:  #line 109 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->conditions= $yyVals[-1+$yyTop];
    } break;

    case 23:  #line 112 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AnyOfCondition()); } break;

    case 24:  #line 112 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->conditions= $yyVals[-1+$yyTop];
    } break;

    case 25:  #line 115 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new NegationOfCondition()); } break;

    case 26:  #line 115 "grammar/sieve.jay"
    {
      $yyVals[-2+$yyTop]->condition= $yyVals[-1+$yyTop];
    } break;

    case 27:  #line 118 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new HeaderCondition()); } break;

    case 28:  #line 118 "grammar/sieve.jay"
    { 
      $yyVals[-3+$yyTop]->tags= $yyVals[-1+$yyTop];
      $yyVals[-3+$yyTop]->arguments= $yyVals[0+$yyTop];
    } break;

    case 29:  #line 122 "grammar/sieve.jay"
    { 
      try { 
        $yyVals[-2+$yyTop]= $yyLex->create(SizeCondition::forName($yyVals[0+$yyTop])); 
      } catch (IllegalArgumentException $e) { 
        $this->error(E_ERROR, $e->getMessage().' at '.$yyLex->fileName.', line '.$yyLex->position[0]); 
        $yyVals[-2+$yyTop]= NULL;
      }
    } break;

    case 30:  #line 129 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop] && $yyVals[-4+$yyTop]->value= intval($yyVals[0+$yyTop]);
    } break;

    case 31:  #line 132 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AddressCondition()); } break;

    case 32:  #line 132 "grammar/sieve.jay"
    {
      $yyVals[-3+$yyTop]->tags= $yyVals[-1+$yyTop];
      $yyVals[-3+$yyTop]->arguments= $yyVals[0+$yyTop];
    } break;

    case 33:  #line 136 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new BooleanCondition(TRUE));
    } break;

    case 34:  #line 139 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new BooleanCondition(FALSE));
    } break;

    case 35:  #line 145 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 37:  #line 150 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 38:  #line 151 "grammar/sieve.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 39:  #line 155 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop] => NULL), $yyVals[0+$yyTop]); } break;

    case 40:  #line 156 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 41:  #line 157 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 42:  #line 161 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 43:  #line 162 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 44:  #line 166 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 46:  #line 171 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 47:  #line 172 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 50:  #line 178 "grammar/sieve.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 51:  #line 186 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 52:  #line 187 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;
#line 518 "-"
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
