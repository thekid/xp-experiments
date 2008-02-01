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
    'peer.sieve.AllOfCondition',
    'peer.sieve.NegationOfCondition',
    'peer.sieve.AnyOfCondition',
    'peer.sieve.BooleanCondition'
  );
#line 18 "-"
  define('TOKEN_T_WORD',  260);
  define('TOKEN_T_STRING',  261);
  define('TOKEN_T_REQUIRE',  270);
  define('TOKEN_T_IF',  280);
  define('TOKEN_T_ELSEIF',  281);
  define('TOKEN_T_ALLOF',  290);
  define('TOKEN_T_ANYOF',  291);
  define('TOKEN_T_NOT',  292);
  define('TOKEN_T_HEADER',  300);
  define('TOKEN_T_SIZE',  301);
  define('TOKEN_T_ADDRESS',  302);
  define('TOKEN_T_TRUE',  303);
  define('TOKEN_T_FALSE',  304);
  define('TOKEN_YY_ERRORCODE', 256);

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class SieveParser extends AbstractParser {
    protected static $yyLhs= array(-1,
          0,     1,     1,     3,     3,     4,     2,     2,     6,     6, 
          9,     7,    11,    11,    10,    10,    12,    12,    13,     8, 
         15,     8,    16,     8,     8,     8,     8,     8,     8,    14, 
         14,    17,    17,    18,    18,     5,     5, 
    );
    protected static $yyLen= array(2,
          2,     0,     1,     1,     2,     5,     0,     1,     1,     2, 
          0,     7,     0,     6,     1,     2,     2,     3,     0,     5, 
          0,     5,     0,     3,     4,     4,     4,     1,     1,     1, 
          3,     1,     2,     1,     3,     1,     3, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     3,     0,     0,    11,     1,     8,     0, 
          5,     0,     0,     0,    10,     0,     0,    19,    21,    23, 
          0,     0,     0,    28,    29,     0,    37,     6,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    24,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    34,     0,    25, 
          0,    26,    27,     0,    17,     0,    16,     0,    20,    22, 
          0,    33,    18,     0,    12,    31,    35,     0,     0,     0, 
          0,    14, 
    );
    protected static $yyDgoto= array(2,
          3,     8,     4,     5,    13,     9,    10,    45,    14,    43, 
         65,    44,    29,    46,    30,    31,    50,    51, 
    );
    protected static $yySindex = array(         -257,
        -74,     0,  -262,     0,  -257,  -242,     0,     0,     0,  -262, 
          0,   -24,   -72,  -276,     0,  -242,   -30,     0,     0,     0, 
        -28,   -26,   -25,     0,     0,   -88,     0,     0,    -4,    -3, 
       -276,  -222,  -221,  -219,  -218,  -276,  -276,     0,   -87,   -87, 
        -87,   -59,   -82,  -218,     4,     5,     6,     0,  -242,     0, 
        -87,     0,     0,   -15,     0,  -236,     0,  -276,     0,     0, 
        -44,     0,     0,  -276,     0,     0,     0,   -73,  -218,   -71, 
       -236,     0, 
    );
    protected static $yyRindex= array(            1,
          0,     0,    51,     0,     2,     0,     0,     0,     0,    52, 
          0,   -40,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,   -70,    16,     0,     0,     0,     0,     0, 
        -36,     0,     0,     0,     0,     3,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          3,     0, 
    );
    protected static $yyGindex= array(0,
          0,     0,    53,     0,    -9,    49,     0,    -8,     0,   -35, 
        -11,     0,     0,   -27,     0,     0,   -29,     0, 
    );
    protected static $yyTable = array(55,
          2,     4,    13,    49,    32,    26,    27,    32,    57,    47, 
         52,    53,     1,    18,    19,    20,     6,     7,    12,    16, 
         17,    62,    38,    21,    22,    23,    24,    25,    28,    32, 
         66,    33,    34,    70,    35,    36,    37,    39,    40,    61, 
         41,    42,    56,    63,    64,    59,    60,    58,    67,    69, 
          7,     9,    36,    71,    15,    68,    30,    11,    15,    72, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,    32,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,    48,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    54,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          2,     4,    13, 
    );
    protected static $yyCheck = array(59,
          0,     0,     0,    91,    41,    14,    16,    44,    44,    37, 
         40,    41,   270,   290,   291,   292,    91,   280,   261,    44, 
         93,    51,    31,   300,   301,   302,   303,   304,    59,    58, 
         58,    58,    58,    69,   123,    40,    40,   260,   260,    49, 
        260,   260,   125,    59,   281,    41,    41,    44,    93,   123, 
          0,     0,    93,   125,   125,    64,    41,     5,    10,    71, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,   123,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,   261,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,   261,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
        280,   280,   280, 
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
      NULL, 'T_WORD', 'T_STRING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      'T_REQUIRE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_IF', 
      'T_ELSEIF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_ALLOF', 
      'T_ANYOF', 'T_NOT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_HEADER', 
      'T_SIZE', 'T_ADDRESS', 'T_TRUE', 'T_FALSE', 
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

    case 1:  #line 33 "grammar/sieve.jay"
    {
      $yyVal= new peer新ieve愛uleSet();
      $yyVal->required= $yyVals[-1+$yyTop];
      $yyVal->rules= $yyVals[0+$yyTop];
    } break;

    case 2:  #line 42 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 4:  #line 47 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 5:  #line 48 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 6:  #line 52 "grammar/sieve.jay"
    { $yyVal= $yyVals[-2+$yyTop]; } break;

    case 7:  #line 58 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 9:  #line 63 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 10:  #line 64 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 11:  #line 68 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= new peer新ieve愛ule(); } break;

    case 12:  #line 68 "grammar/sieve.jay"
    {
      $yyVal->condition= $yyVals[-4+$yyTop];
      $yyVal->statements= $yyVals[-2+$yyTop];
    } break;

    case 13:  #line 75 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 15:  #line 81 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 16:  #line 82 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 19:  #line 93 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AllOfCondition()); } break;

    case 20:  #line 93 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->expressions= $yyVals[-1+$yyTop];
    } break;

    case 21:  #line 96 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AnyOfCondition()); } break;

    case 22:  #line 96 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->expressions= $yyVals[-1+$yyTop];
    } break;

    case 23:  #line 99 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new NegationOfCondition()); } break;

    case 24:  #line 99 "grammar/sieve.jay"
    {
      $yyVals[-2+$yyTop]->condition= $yyVals[-1+$yyTop];
    } break;

    case 25:  #line 102 "grammar/sieve.jay"
    { 
      $yyVal= array($yyVals[-3+$yyTop] => array($yyVals[-1+$yyTop], $yyVals[0+$yyTop])); 
    } break;

    case 26:  #line 105 "grammar/sieve.jay"
    {
      $yyVal= array($yyVals[-3+$yyTop] => array($yyVals[-1+$yyTop], $yyVals[0+$yyTop])); 
    } break;

    case 27:  #line 108 "grammar/sieve.jay"
    {
      $yyVal= array($yyVals[-3+$yyTop] => array($yyVals[-1+$yyTop], $yyVals[0+$yyTop])); 
    } break;

    case 28:  #line 111 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new BooleanCondition(TRUE));
    } break;

    case 29:  #line 114 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new BooleanCondition(FALSE));
    } break;

    case 30:  #line 120 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 31:  #line 121 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 32:  #line 125 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 33:  #line 126 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 36:  #line 140 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 37:  #line 141 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;
#line 444 "-"
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
