<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses('text.parser.generic.AbstractParser');

#line 2 "grammar/mathematics.jay"
  uses(
    'calc.Addition',
    'calc.Subtraction',
    'calc.Multiplication',
    'calc.Division',
    'calc.Modulo',
    'calc.Power',
    'calc.Value',
    'calc.FunctionFactory',
    'calc.PiFunction',
    'calc.AbsFunction',
    'calc.Negation'
  );
  
#line 24 "-"
  define('TOKEN_T_NUMBER',  260);
  define('TOKEN_T_STRING',  262);
  define('TOKEN_T_WORD',  263);
  define('TOKEN_YY_ERRORCODE', 256);

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class ExpressionParser extends AbstractParser {
    protected static $yyLhs= array(-1,
          0,     1,     1,     1,     1,     1,     1,     1,     1,     1, 
          3,     3,     2,     2, 
    );
    protected static $yyLen= array(2,
          1,     2,     3,     3,     3,     3,     3,     3,     3,     1, 
          0,     2,     1,     4, 
    );
    protected static $yyDefRed= array(0,
          0,    13,     0,     0,     0,     0,    10,     0,    11,     0, 
          0,     0,     0,     0,     0,     0,     0,     3,     0,     0, 
          0,     0,     0,     9,    14,     0, 
    );
    protected static $yyDgoto= array(5,
          6,     7,    17, 
    );
    protected static $yySindex = array(          -40,
        -40,     0,   -36,   -40,     0,   -13,     0,   -11,     0,   -25, 
        -40,   -40,   -40,   -40,   -40,   -40,   -38,     0,   -11,   -11, 
        -88,   -88,   -88,     0,     0,   -13, 
    );
    protected static $yyRindex= array(            0,
          0,     0,     0,     0,     0,    11,     0,    27,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,    33,    39, 
          1,    10,    19,     0,     0,   -32, 
    );
    protected static $yyGindex= array(0,
         84,     0,     0, 
    );
    protected static $yyTable = array(4,
          6,     4,    25,     9,     1,    16,     1,    12,    12,     7, 
          1,    15,     0,     0,     0,    18,    13,    11,     8,    12, 
          0,    14,     0,    15,     0,    15,     2,     0,    13,    11, 
         13,    12,     4,    14,     0,    14,     0,     6,     5,     0, 
          6,     6,     6,     6,     0,     6,     7,     6,     0,     7, 
          7,     7,     7,     0,     7,     8,     7,     0,     8,     8, 
          8,     8,     0,     8,     0,     8,     2,     2,    16,     2, 
          0,     2,     4,     4,     0,     4,     0,     4,     5,     5, 
         16,     5,    16,     5,     8,     0,     0,    10,     0,     0, 
          0,     0,     0,     0,    19,    20,    21,    22,    23,    24, 
         26,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
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
          0,     0,     0,     0,     0,     0,     0,     0,     0,     2, 
          0,     2,     3,     0,     3,     0,     0,    12,     0,     0, 
         12,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          6,     0,     0,     6,     0,     0,     0,     0,     0,     7, 
          0,     0,     7,     0,     0,     0,     0,     0,     8,     0, 
          0,     8,     0,     0,     0,     0,     2,     0,     0,     2, 
          0,     0,     4,     0,     0,     4,     0,     0,     5,     0, 
          0,     5, 
    );
    protected static $yyCheck = array(40,
          0,    40,    41,    40,    45,    94,    45,    40,    41,     0, 
          0,    37,    -1,    -1,    -1,    41,    42,    43,     0,    45, 
         -1,    47,    -1,    37,    -1,    37,     0,    -1,    42,    43, 
         42,    45,     0,    47,    -1,    47,    -1,    37,     0,    -1, 
         40,    41,    42,    43,    -1,    45,    37,    47,    -1,    40, 
         41,    42,    43,    -1,    45,    37,    47,    -1,    40,    41, 
         42,    43,    -1,    45,    -1,    47,    40,    41,    94,    43, 
         -1,    45,    40,    41,    -1,    43,    -1,    45,    40,    41, 
         94,    43,    94,    45,     1,    -1,    -1,     4,    -1,    -1, 
         -1,    -1,    -1,    -1,    11,    12,    13,    14,    15,    16, 
         17,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
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
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   260, 
         -1,   260,   263,    -1,   263,    -1,    -1,   260,    -1,    -1, 
        263,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
        260,    -1,    -1,   263,    -1,    -1,    -1,    -1,    -1,   260, 
         -1,    -1,   263,    -1,    -1,    -1,    -1,    -1,   260,    -1, 
         -1,   263,    -1,    -1,    -1,    -1,   260,    -1,    -1,   263, 
         -1,    -1,   260,    -1,    -1,   263,    -1,    -1,   260,    -1, 
         -1,   263, 
    );
    protected static $yyFinal= 5;
    protected static $yyName= array(    
      'end-of-file', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, "'%'", NULL, 
      NULL, "'('", "')'", "'*'", "'+'", NULL, "'-'", NULL, "'/'", NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, "'^'", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
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
      'T_NUMBER', NULL, 'T_STRING', 'T_WORD', 
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

    case 1:  #line 28 "grammar/mathematics.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 2:  #line 31 "grammar/mathematics.jay"
    { $yyVal= $yyLex->create(Negation::createFor($yyVals[0+$yyTop])); } break;

    case 3:  #line 32 "grammar/mathematics.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 4:  #line 33 "grammar/mathematics.jay"
    { $yyVal= $yyLex->create(new Addition($yyVals[-2+$yyTop], $yyVals[0+$yyTop])); } break;

    case 5:  #line 34 "grammar/mathematics.jay"
    { $yyVal= $yyLex->create(new Subtraction($yyVals[-2+$yyTop], $yyVals[0+$yyTop])); } break;

    case 6:  #line 35 "grammar/mathematics.jay"
    { $yyVal= $yyLex->create(new Multiplication($yyVals[-2+$yyTop], $yyVals[0+$yyTop])); } break;

    case 7:  #line 36 "grammar/mathematics.jay"
    { $yyVal= $yyLex->create(new Division($yyVals[-2+$yyTop], $yyVals[0+$yyTop])); } break;

    case 8:  #line 37 "grammar/mathematics.jay"
    { $yyVal= $yyLex->create(new Modulo($yyVals[-2+$yyTop], $yyVals[0+$yyTop])); } break;

    case 9:  #line 38 "grammar/mathematics.jay"
    { $yyVal= $yyLex->create(new Power($yyVals[-2+$yyTop], $yyVals[0+$yyTop])); } break;

    case 12:  #line 44 "grammar/mathematics.jay"
    { $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 13:  #line 48 "grammar/mathematics.jay"
    { $yyVal= $yyLex->create(new Value($yyVals[0+$yyTop])); } break;

    case 14:  #line 49 "grammar/mathematics.jay"
    { $yyVal= $yyLex->create(FunctionFactory::create($yyVals[-3+$yyTop], $yyVals[-1+$yyTop])); } break;
#line 342 "-"
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
