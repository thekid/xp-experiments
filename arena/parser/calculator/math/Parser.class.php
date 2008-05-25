<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses('text.parser.generic.AbstractParser');

#line 2 "grammar/calculator.jay"
  $package= 'math';

  uses(
    'lang.types.Integer',
    'lang.types.Double',
    'math.functions.Factory',
    'math.functions.Call',
    'math.functions.Fac',
    'math.Fraction',
    'math.Constant',
    'math.Value',
    'math.Addition',
    'math.Subtraction',
    'math.Multiplication',
    'math.Division',
    'math.Power',
    'math.Modulo'
  );
#line 28 "-"

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class math�Parser extends AbstractParser {
    const T_INTEGER= 257;
    const T_DOUBLE= 258;
    const T_WORD= 259;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     1,     1, 
    );
    protected static $yyLen= array(2,
          1,     1,     4,     2,     1,     2,     3,     3,     3,     3, 
          3,     3,     2,     2,     3,     3,     1,     3, 
    );
    protected static $yyDefRed= array(0,
          1,     2,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,    13,    14,     0,     4,     0,     0, 
          0,    16,     0,     0,     0,     0,     0,    12,    11,     3, 
          0,     0, 
    );
    protected static $yyDgoto= array(6,
         21, 
    );
    protected static $yySindex = array(          -40,
          0,     0,   -37,   -40,   -40,    19,   -40,   -29,   -31,   -40, 
        -40,   -40,   -40,   -40,     0,     0,   -40,     0,   -40,    19, 
        -24,     0,   -29,   -29,   -26,   -26,   -26,     0,     0,     0, 
        -40,    19, 
    );
    protected static $yyRindex= array(            0,
          0,     0,     1,     0,     0,     0,     0,    55,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,   -22, 
          0,     0,    60,    78,    30,    39,    49,     0,     0,     0, 
          0,   -18, 
    );
    protected static $yyGindex= array(120,
          0, 
    );
    protected static $yyTable = array(5,
          5,    18,     7,    18,     4,    14,    18,    14,     0,    22, 
         12,    10,    12,    11,     0,    19,    30,    19,    17,    31, 
         19,    17,    18,     0,     0,    18,    13,     0,    13,     9, 
          0,     0,     0,     5,     0,     0,     0,     5,    10,     0, 
          0,     5,     5,     5,     5,     5,     0,     5,    15,     0, 
          0,    18,     0,     0,     6,    14,     0,     0,     5,     7, 
         12,    10,    17,    11,    17,    19,     9,    17,     0,     0, 
          9,     9,     9,     9,     9,    10,    13,     8,     0,    10, 
         10,    10,    10,    10,     0,    15,     0,     9,     0,    15, 
         15,    15,    15,    15,     5,     6,    10,     6,     6,     6, 
          7,     0,     7,     7,     7,     0,    15,     0,     0,     0, 
          0,     0,    17,     0,     0,     0,     0,     0,     8,     0, 
          8,     8,     8,     8,     9,     0,    20,     0,     0,    23, 
         24,    25,    26,    27,     0,     0,    28,     0,    29,     0, 
          0,     0,     0,     0,     0,     0,    15,    16,    15,    16, 
         32,    15,    16,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     5,     5, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,    15,    16,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     1,     2,     3, 
    );
    protected static $yyCheck = array(40,
          0,    33,    40,    33,    45,    37,    33,    37,    -1,    41, 
         42,    43,    42,    45,    -1,    47,    41,    47,    41,    44, 
         47,    44,    41,    -1,    -1,    44,    58,    -1,    58,     0, 
         -1,    -1,    -1,    33,    -1,    -1,    -1,    37,     0,    -1, 
         -1,    41,    42,    43,    44,    45,    -1,    47,     0,    -1, 
         -1,    33,    -1,    -1,     0,    37,    -1,    -1,    58,     0, 
         42,    43,    94,    45,    94,    47,    37,    94,    -1,    -1, 
         41,    42,    43,    44,    45,    37,    58,     0,    -1,    41, 
         42,    43,    44,    45,    -1,    37,    -1,    58,    -1,    41, 
         42,    43,    44,    45,    94,    41,    58,    43,    44,    45, 
         41,    -1,    43,    44,    45,    -1,    58,    -1,    -1,    -1, 
         -1,    -1,    94,    -1,    -1,    -1,    -1,    -1,    41,    -1, 
         43,    44,    45,     4,     5,    -1,     7,    -1,    -1,    10, 
         11,    12,    13,    14,    -1,    -1,    17,    -1,    19,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,   178,   179,   178,   179, 
         31,   178,   179,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   178,   179, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,   178,   179,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,   257,   258,   259, 
    );
    protected static $yyFinal= 6;
    protected static $yyName= array(    
      'end-of-file', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, "'!'", NULL, NULL, NULL, "'%'", NULL, 
      NULL, "'('", "')'", "'*'", "'+'", "','", "'-'", NULL, "'/'", NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, "':'", NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, "'^'", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, "'\\262'", "'\\263'", NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      'T_INTEGER', 'T_DOUBLE', 'T_WORD', 
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

    case 1:  #line 31 "grammar/calculator.jay"
    { $yyVal= new math�Value(new Integer($yyVals[0+$yyTop])); } break;

    case 2:  #line 32 "grammar/calculator.jay"
    { $yyVal= new math�Value(new Double($yyVals[0+$yyTop])); } break;

    case 3:  #line 33 "grammar/calculator.jay"
    { $yyVal= new math�functions�Call(math�functions�Factory::forName($yyVals[-3+$yyTop]), $yyVals[-1+$yyTop]); } break;

    case 4:  #line 34 "grammar/calculator.jay"
    { $yyVal= new math�functions�Call(new math�functions�Fac(), array($yyVals[-1+$yyTop])); } break;

    case 5:  #line 35 "grammar/calculator.jay"
    { $yyVal= Enum::valueOf(XPClass::forName('math.Constant'), $yyVals[0+$yyTop]); } break;

    case 6:  #line 36 "grammar/calculator.jay"
    { $yyVal= new math�Multiplication(new math�Value(new Integer(-1)), $yyVals[0+$yyTop]); } break;

    case 7:  #line 37 "grammar/calculator.jay"
    { $yyVal= new math�Addition($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 8:  #line 38 "grammar/calculator.jay"
    { $yyVal= new math�Subtraction($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 9:  #line 39 "grammar/calculator.jay"
    { $yyVal= new math�Multiplication($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 10:  #line 40 "grammar/calculator.jay"
    { $yyVal= new math�Division($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 11:  #line 41 "grammar/calculator.jay"
    { $yyVal= new math�Fraction($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 12:  #line 42 "grammar/calculator.jay"
    { $yyVal= new math�Power($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 13:  #line 43 "grammar/calculator.jay"
    { $yyVal= new math�Power($yyVals[-1+$yyTop], new math�Value(new Integer(2))); } break;

    case 14:  #line 44 "grammar/calculator.jay"
    { $yyVal= new math�Power($yyVals[-1+$yyTop], new math�Value(new Integer(3))); } break;

    case 15:  #line 45 "grammar/calculator.jay"
    { $yyVal= new math�Modulo($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 16:  #line 46 "grammar/calculator.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 17:  #line 50 "grammar/calculator.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 18:  #line 51 "grammar/calculator.jay"
    { $yyVal= array_merge($yyVals[-2+$yyTop], array($yyVals[0+$yyTop])); } break;
#line 350 "-"
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
