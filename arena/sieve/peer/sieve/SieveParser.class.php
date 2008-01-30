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
    'peer.sieve.AllOfCondition'
  );
#line 15 "-"
  define('TOKEN_T_WORD',  260);
  define('TOKEN_T_STRING',  261);
  define('TOKEN_T_REQUIRE',  270);
  define('TOKEN_T_IF',  280);
  define('TOKEN_T_ELSEIF',  281);
  define('TOKEN_T_ALLOF',  290);
  define('TOKEN_T_ANYOF',  291);
  define('TOKEN_T_NOT',  272);
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
          8,    14,    14,    15,    16,    16,    17,    17,     5,     5, 
    );
    protected static $yyLen= array(2,
          2,     0,     1,     1,     2,     5,     0,     1,     1,     2, 
          0,     7,     0,     6,     1,     2,     2,     3,     0,     5, 
          2,     1,     3,     4,     1,     2,     1,     3,     1,     3, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     3,     0,     0,    11,     1,     8,     0, 
          5,     0,     0,     0,    10,     0,     0,    19,     0,     0, 
         30,     6,     0,    21,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,    17,     0,    16,     0,    20,     0,    18, 
          0,    12,     0,    23,     0,    27,     0,    24,     0,     0, 
          0,    26,     0,    28,     0,    14, 
    );
    protected static $yyDgoto= array(2,
          3,     8,     4,     5,    13,     9,    10,    20,    14,    28, 
         42,    29,    23,    31,    32,    48,    49, 
    );
    protected static $yySindex = array(         -260,
        -80,     0,  -267,     0,  -260,  -247,     0,     0,     0,  -267, 
          0,   -29,   -77,  -265,     0,  -247,   -42,     0,  -265,  -105, 
          0,     0,   -20,     0,  -241,  -239,   -59,  -103,  -241,   -35, 
        -17,   -18,   -28,     0,  -254,     0,  -230,     0,  -239,     0, 
       -265,     0,   -87,     0,   -91,     0,  -247,     0,   -87,  -241, 
        -60,     0,   -90,     0,  -254,     0, 
    );
    protected static $yyRindex= array(            1,
          0,     0,    34,     0,     2,     0,     0,     0,     0,    37, 
          0,   -55,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,   -86,     0, 
          0,    -1,     0,     0,     3,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,   -32,     0, 
          0,     0,     0,     0,     3,     0, 
    );
    protected static $yyGindex= array(0,
          0,     0,    36,     0,   -11,    32,     0,   -13,     0,   -21, 
        -12,     0,     0,     5,     0,    -4,     0, 
    );
    protected static $yyTable = array(34,
          2,     4,    13,    47,    21,    24,    19,    36,    25,     1, 
          6,    25,     7,    12,    16,    17,    22,    25,    27,    26, 
         30,    35,    37,    38,    18,    39,    41,    45,    53,    43, 
         40,    50,    54,     7,    55,    51,     9,    29,    15,    22, 
         11,    15,    56,    44,    52,     0,     0,     0,     0,     0, 
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
          0,     0,     0,    46,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    33,     0,     0,     0,     0,     0,     0,     0,     0, 
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
          0,     0,     0,    91,    16,    19,   272,    29,    41,   270, 
         91,    44,   280,   261,    44,    93,    59,   123,   260,    40, 
        260,   125,    58,    41,   290,    44,   281,    41,    50,   260, 
         59,   123,    93,     0,   125,    47,     0,    93,   125,    41, 
          5,    10,    55,    39,    49,    -1,    -1,    -1,    -1,    -1, 
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
      'T_REQUIRE', NULL, 'T_NOT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_IF', 
      'T_ELSEIF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_ALLOF', 
      'T_ANYOF', 
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

    case 1:  #line 24 "grammar/sieve.jay"
    {
      $yyVal= new peer新ieve愛uleSet();
      $yyVal->required= $yyVals[-1+$yyTop];
      $yyVal->rules= $yyVals[0+$yyTop];
    } break;

    case 2:  #line 33 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 4:  #line 38 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 5:  #line 39 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 6:  #line 43 "grammar/sieve.jay"
    { $yyVal= $yyVals[-2+$yyTop]; } break;

    case 7:  #line 49 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 9:  #line 54 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 10:  #line 55 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 11:  #line 59 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= new peer新ieve愛ule(); } break;

    case 12:  #line 59 "grammar/sieve.jay"
    {
      $yyVal->condition= $yyVals[-4+$yyTop];
      $yyVal->statements= $yyVals[-2+$yyTop];
    } break;

    case 13:  #line 66 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 15:  #line 72 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 16:  #line 73 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 19:  #line 84 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AllOfCondition()); } break;

    case 20:  #line 84 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->args= $yyVals[-1+$yyTop];
    } break;

    case 21:  #line 87 "grammar/sieve.jay"
    {
  
    } break;

    case 22:  #line 93 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 23:  #line 94 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 24:  #line 98 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-3+$yyTop] => array($yyVals[-1+$yyTop], $yyVals[0+$yyTop])); } break;

    case 25:  #line 102 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 26:  #line 103 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 29:  #line 116 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 30:  #line 117 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;
#line 394 "-"
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
