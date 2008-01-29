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
  define('TOKEN_T_NOT',  271);
  define('TOKEN_T_IF',  280);
  define('TOKEN_T_ELSEIF',  281);
  define('TOKEN_T_ALLOF',  282);
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
          8,    14,    14,    15,    15,     5,     5, 
    );
    protected static $yyLen= array(2,
          2,     0,     1,     1,     2,     5,     0,     1,     1,     2, 
          0,     7,     0,     6,     1,     2,     2,     3,     0,     8, 
          2,     1,     2,     1,     3,     1,     3, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     3,     0,     0,    11,     1,     8,     0, 
          5,     0,     0,     0,    10,     0,     0,     0,    19,     0, 
         27,     6,    21,     0,     0,     0,     0,     0,     0,     0, 
          0,    17,     0,    16,     0,    18,     0,    12,     0,     0, 
         24,     0,     0,     0,     0,     0,    20,    23,     0,    25, 
          0,    14, 
    );
    protected static $yyDgoto= array(2,
          3,     8,     4,     5,    13,     9,    10,    20,    14,    28, 
         38,    29,    24,    43,    44, 
    );
    protected static $yySindex = array(         -261,
        -81,     0,  -269,     0,  -261,  -249,     0,     0,     0,  -269, 
          0,   -31,   -79,  -263,     0,  -249,   -44,  -263,     0,  -107, 
          0,     0,     0,   -23,  -242,  -240,   -59,  -104,  -242,   -36, 
        -35,     0,  -255,     0,  -233,     0,  -263,     0,   -87,   -95, 
          0,  -249,    -9,   -87,  -242,   -64,     0,     0,   -92,     0, 
       -255,     0, 
    );
    protected static $yyRindex= array(            1,
          0,     0,    30,     0,     2,     0,     0,     0,     0,    34, 
          0,   -58,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,   -89,     0, 
          0,     0,     3,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,    -4,     0,     0,     0,     0,     0,     0, 
          3,     0, 
    );
    protected static $yyGindex= array(0,
          0,     0,    33,     0,   -11,    29,     0,   -12,     0,   -22, 
        -10,     0,     0,    -2,     0, 
    );
    protected static $yyTable = array(32,
          2,     4,    13,    42,    21,    23,    34,    18,     1,     6, 
          7,    12,    16,    17,    22,    25,    26,    27,    19,    30, 
         33,    35,    49,    36,    40,    37,    39,    45,    50,     7, 
         46,    47,    51,     9,    26,    15,    22,    11,    15,     0, 
         52,    48,     0,     0,     0,     0,     0,     0,     0,     0, 
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
          0,     0,     0,    41,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    31,     0,     0,     0,     0,     0,     0,     0,     0, 
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
          0,     0,     0,    91,    16,    18,    29,   271,   270,    91, 
        280,   261,    44,    93,    59,   123,    40,   260,   282,   260, 
        125,    58,    45,    59,    37,   281,   260,   123,    93,     0, 
         42,    41,   125,     0,    93,   125,    41,     5,    10,    -1, 
         51,    44,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
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
      'T_REQUIRE', 'T_NOT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_IF', 
      'T_ELSEIF', 'T_ALLOF', 
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

    case 1:  #line 23 "grammar/sieve.jay"
    {
      $yyVal= new peer新ieve愛uleSet();
      $yyVal->required= $yyVals[-1+$yyTop];
      $yyVal->rules= $yyVals[0+$yyTop];
    } break;

    case 2:  #line 32 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 4:  #line 37 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 5:  #line 38 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 6:  #line 42 "grammar/sieve.jay"
    { $yyVal= $yyVals[-2+$yyTop]; } break;

    case 7:  #line 48 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 9:  #line 53 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 10:  #line 54 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 11:  #line 58 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= new peer新ieve愛ule(); } break;

    case 12:  #line 58 "grammar/sieve.jay"
    {
      $yyVal->condition= $yyVals[-4+$yyTop];
      $yyVal->statements= $yyVals[-2+$yyTop];
    } break;

    case 13:  #line 65 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 15:  #line 71 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 16:  #line 72 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 19:  #line 83 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AllOfCondition()); } break;

    case 20:  #line 83 "grammar/sieve.jay"
    {
    
    } break;

    case 21:  #line 86 "grammar/sieve.jay"
    {
  
    } break;

    case 22:  #line 92 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 23:  #line 93 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 26:  #line 106 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 27:  #line 107 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;
#line 383 "-"
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
