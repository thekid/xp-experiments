<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses('text.parser.generic.AbstractParser');

#line 2 "grammar/calculator.jay"
  $package= 'math';

  uses(
    'math.functions.Factory',
    'math.functions.Call',
    'math.functions.Fac',
    'math.Constant',
    'math.Value',
    'math.Addition',
    'math.Subtraction',
    'math.Multiplication',
    'math.Division',
    'math.Power',
    'math.Modulo'
  );
#line 25 "-"

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class math·Parser extends AbstractParser {
    const T_INTEGER= 257;
    const T_DOUBLE= 258;
    const T_WORD= 259;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     1,     1, 
    );
    protected static $yyLen= array(2,
          1,     3,     1,     4,     2,     1,     2,     3,     3,     3, 
          3,     3,     2,     2,     3,     3,     1,     3, 
    );
    protected static $yyDefRed= array(0,
          0,     3,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,    13,    14,     0,     5,     2, 
          0,     0,    16,     0,     0,     0,     0,     0,    12,     4, 
          0,     0, 
    );
    protected static $yyDgoto= array(6,
         22, 
    );
    protected static $yySindex = array(          -40,
        -45,     0,   -37,   -40,   -40,   -22,  -250,   -40,   -11,   -29, 
        -40,   -40,   -40,   -40,   -40,     0,     0,   -40,     0,     0, 
        -22,   -17,     0,   -11,   -11,   -27,   -27,   -27,     0,     0, 
        -40,   -22, 
    );
    protected static $yyRindex= array(            0,
          1,     0,    19,     0,     0,     0,     0,     0,    10,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
        -16,     0,     0,    30,    35,    48,    57,    66,     0,     0, 
          0,    -4, 
    );
    protected static $yyGindex= array(114,
          0, 
    );
    protected static $yyTable = array(5,
          1,     7,     8,    19,     4,    19,    20,    15,     0,     7, 
         19,    23,    13,    11,    15,    12,     0,     0,     6,    13, 
         11,    19,    12,    30,    17,    15,    31,    17,    14,     8, 
         13,     0,     0,     1,     9,    14,    18,     1,     0,    18, 
          0,     1,     1,     1,     1,     1,    14,    10,     0,     0, 
          7,     6,     7,     7,     7,     6,    11,     0,     1,     6, 
          6,     6,     6,     6,    18,    15,    18,     0,     0,     0, 
          8,    18,     8,     8,     8,     9,     6,     9,     9,     9, 
          0,     0,    18,     0,    10,     0,     0,     0,    10,    10, 
         10,    10,    10,    11,     1,     0,     0,    11,    11,    11, 
         11,    11,    15,     0,     0,    10,    15,    15,    15,    15, 
         15,     0,     6,     0,    11,     0,     0,     9,    10,     0, 
          0,    21,     0,    15,    24,    25,    26,    27,    28,     0, 
          0,    29,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,    32,     0,     0,     0,    16,    17, 
         16,    17,     0,     0,     0,    16,    17,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,    16,    17,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     1,     1, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     6,     6,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     1,     2,     3, 
    );
    protected static $yyCheck = array(40,
          0,    47,    40,    33,    45,    33,   257,    37,    -1,     0, 
         33,    41,    42,    43,    37,    45,    -1,    -1,     0,    42, 
         43,    33,    45,    41,    41,    37,    44,    44,    58,     0, 
         42,    -1,    -1,    33,     0,    58,    41,    37,    -1,    44, 
         -1,    41,    42,    43,    44,    45,    58,     0,    -1,    -1, 
         41,    33,    43,    44,    45,    37,     0,    -1,    58,    41, 
         42,    43,    44,    45,    94,     0,    94,    -1,    -1,    -1, 
         41,    94,    43,    44,    45,    41,    58,    43,    44,    45, 
         -1,    -1,    94,    -1,    37,    -1,    -1,    -1,    41,    42, 
         43,    44,    45,    37,    94,    -1,    -1,    41,    42,    43, 
         44,    45,    37,    -1,    -1,    58,    41,    42,    43,    44, 
         45,    -1,    94,    -1,    58,    -1,    -1,     4,     5,    -1, 
         -1,     8,    -1,    58,    11,    12,    13,    14,    15,    -1, 
         -1,    18,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    31,    -1,    -1,    -1,   178,   179, 
        178,   179,    -1,    -1,    -1,   178,   179,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,   178,   179,    -1,    -1, 
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

    case 1:  #line 28 "grammar/calculator.jay"
    { $yyVal= new math·Value(new Rational($yyVals[0+$yyTop])); } break;

    case 2:  #line 29 "grammar/calculator.jay"
    { $yyVal= new math·Value(new Rational($yyVals[-2+$yyTop].'/'.$yyVals[0+$yyTop]));} break;

    case 3:  #line 30 "grammar/calculator.jay"
    { $yyVal= new math·Value(new Real($yyVals[0+$yyTop])); } break;

    case 4:  #line 31 "grammar/calculator.jay"
    { $yyVal= new math·functions·Call(math·functions·Factory::forName($yyVals[-3+$yyTop]), $yyVals[-1+$yyTop]); } break;

    case 5:  #line 32 "grammar/calculator.jay"
    { $yyVal= new math·functions·Call(new math·functions·Fac(), array($yyVals[-1+$yyTop])); } break;

    case 6:  #line 33 "grammar/calculator.jay"
    { $yyVal= Enum::valueOf(XPClass::forName('math.Constant'), $yyVals[0+$yyTop]); } break;

    case 7:  #line 34 "grammar/calculator.jay"
    { $yyVal= new math·Multiplication(new math·Value(new Rational(-1)), $yyVals[0+$yyTop]); } break;

    case 8:  #line 35 "grammar/calculator.jay"
    { $yyVal= new math·Addition($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 9:  #line 36 "grammar/calculator.jay"
    { $yyVal= new math·Subtraction($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 10:  #line 37 "grammar/calculator.jay"
    { $yyVal= new math·Multiplication($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 11:  #line 38 "grammar/calculator.jay"
    { $yyVal= new math·Division($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 12:  #line 39 "grammar/calculator.jay"
    { $yyVal= new math·Power($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 13:  #line 40 "grammar/calculator.jay"
    { $yyVal= new math·Power($yyVals[-1+$yyTop], new math·Value(new Rational(2))); } break;

    case 14:  #line 41 "grammar/calculator.jay"
    { $yyVal= new math·Power($yyVals[-1+$yyTop], new math·Value(new Rational(3))); } break;

    case 15:  #line 42 "grammar/calculator.jay"
    { $yyVal= new math·Modulo($yyVals[-2+$yyTop], $yyVals[0+$yyTop]); } break;

    case 16:  #line 43 "grammar/calculator.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 17:  #line 47 "grammar/calculator.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 18:  #line 48 "grammar/calculator.jay"
    { $yyVal= array_merge($yyVals[-2+$yyTop], array($yyVals[0+$yyTop])); } break;
#line 347 "-"
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
