<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses('text.parser.generic.AbstractParser');

#line 2 "./grammar/oelcalc.jay"

  $package= "oel";

  uses(
    'oel.InstructionTreeRoot',
    'oel.InstructionTree'
  );

#line 18 "-"

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class oel텾arser extends AbstractParser {
    const T_INTEGER= 257;
    const T_DOUBLE= 258;
    const T_PI= 259;
    const T_E= 260;
    const T_EULER= 261;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          2,     0,     1,     1,     1,     1,     1,     1,     1,     3, 
          3,     3,     3,     3, 
    );
    protected static $yyLen= array(2,
          0,     2,     1,     3,     3,     3,     3,     3,     3,     1, 
          1,     1,     1,     1, 
    );
    protected static $yyDefRed= array(1,
          0,     0,    10,    11,    12,    13,    14,     0,     0,     3, 
          0,     0,     0,     0,     0,     0,     9,     0,     0,     6, 
          7,     8, 
    );
    protected static $yyDgoto= array(1,
          9,     2,    10, 
    );
    protected static $yySindex = array(            0,
          0,   -40,     0,     0,     0,     0,     0,   -40,   -27,     0, 
        -34,   -40,   -40,   -40,   -40,   -40,     0,   -25,   -25,     0, 
          0,     0, 
    );
    protected static $yyRindex= array(            0,
          0,     0,     0,     0,     0,     0,     0,     0,     4,     0, 
          0,     0,     0,     0,     0,     0,     0,     1,     2,     0, 
          0,     0, 
    );
    protected static $yyGindex= array(0,
         13,     0,     0, 
    );
    protected static $yyTable = array(8,
          4,     5,    16,     2,     0,     0,    17,    14,    12,    16, 
         13,    16,     0,     0,    14,    12,    14,    13,     0,     0, 
         11,     0,     0,    15,    18,    19,    20,    21,    22,     0, 
         15,     0,    15,     0,     0,     0,     0,     0,     0,     0, 
          0,     4,     5,     4,     5,     4,     5,     0,     0,     0, 
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
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     3,     4,     5,     6, 
          7, 
    );
    protected static $yyCheck = array(40,
          0,     0,    37,     0,    -1,    -1,    41,    42,    43,    37, 
         45,    37,    -1,    -1,    42,    43,    42,    45,    -1,    -1, 
          8,    -1,    -1,    58,    12,    13,    14,    15,    16,    -1, 
         58,    -1,    58,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    41,    41,    43,    43,    45,    45,    -1,    -1,    -1, 
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
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,   257,   258,   259,   260, 
        261, 
    );
    protected static $yyFinal= 1;
    protected static $yyName= array(    
      'end-of-file', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, "'%'", NULL, 
      NULL, "'('", "')'", "'*'", "'+'", NULL, "'-'", NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, "':'", NULL, NULL, NULL, NULL, NULL, NULL, 
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
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_INTEGER', 
      'T_DOUBLE', 'T_PI', 'T_E', 'T_EULER', 
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

    case 1:  #line 19 "./grammar/oelcalc.jay"
    { $this->op_array= oel_new_op_array(); } break;

    case 2:  #line 21 "./grammar/oelcalc.jay"
    { 
      $yyVal= new oel텶nstructionTreeRoot($this->op_array, array());
      $yyVal->addPreInstruction($yyVals[-1+$yyTop]= new oel텶nstructionTree("oel_add_return", array($this->op_array)));
      $yyVals[-1+$yyTop]->addPreInstruction($yyVals[0+$yyTop]);
    } break;

    case 3:  #line 29 "./grammar/oelcalc.jay"
    { $yyVal= new oel텶nstructionTree("oel_push_value", array($this->op_array, $yyVals[0+$yyTop])); } break;

    case 4:  #line 30 "./grammar/oelcalc.jay"
    { $yyVal= new oel텶nstructionTree("oel_add_binary_op", array($this->op_array, OEL_BINARY_OP_ADD)); $yyVal->addPreInstruction($yyVals[0+$yyTop]); $yyVal->addPreInstruction($yyVals[-2+$yyTop]); } break;

    case 5:  #line 31 "./grammar/oelcalc.jay"
    { $yyVal= new oel텶nstructionTree("oel_add_binary_op", array($this->op_array, OEL_BINARY_OP_SUB)); $yyVal->addPreInstruction($yyVals[0+$yyTop]); $yyVal->addPreInstruction($yyVals[-2+$yyTop]); } break;

    case 6:  #line 32 "./grammar/oelcalc.jay"
    { $yyVal= new oel텶nstructionTree("oel_add_binary_op", array($this->op_array, OEL_BINARY_OP_MUL)); $yyVal->addPreInstruction($yyVals[0+$yyTop]); $yyVal->addPreInstruction($yyVals[-2+$yyTop]); } break;

    case 7:  #line 33 "./grammar/oelcalc.jay"
    { $yyVal= new oel텶nstructionTree("oel_add_binary_op", array($this->op_array, OEL_BINARY_OP_DIV)); $yyVal->addPreInstruction($yyVals[0+$yyTop]); $yyVal->addPreInstruction($yyVals[-2+$yyTop]); } break;

    case 8:  #line 34 "./grammar/oelcalc.jay"
    { $yyVal= new oel텶nstructionTree("oel_add_binary_op", array($this->op_array, OEL_BINARY_OP_MOD)); $yyVal->addPreInstruction($yyVals[0+$yyTop]); $yyVal->addPreInstruction($yyVals[-2+$yyTop]); } break;

    case 9:  #line 35 "./grammar/oelcalc.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 10:  #line 39 "./grammar/oelcalc.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 11:  #line 40 "./grammar/oelcalc.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 12:  #line 41 "./grammar/oelcalc.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 13:  #line 42 "./grammar/oelcalc.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 14:  #line 43 "./grammar/oelcalc.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;
#line 333 "-"
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
