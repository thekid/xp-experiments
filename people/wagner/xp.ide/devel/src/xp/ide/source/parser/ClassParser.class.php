<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  $package= 'xp.ide.source.parser';

#line 2 "./grammar/Class.jay"

  uses(
    'xp.ide.source.Scope',
    'xp.ide.source.element.Classdef',
    'xp.ide.source.element.Classmember',
    'xp.ide.source.element.Classconstant',
    'xp.ide.source.element.Array',
    'xp.ide.source.element.BlockComment'
  );

#line 20 "-"

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
    const T_PUBLIC= 263;
    const T_PRIVATE= 264;
    const T_PROTECTED= 265;
    const T_CONST= 266;
    const T_STATIC= 267;
    const T_BOOLEAN= 268;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     0,     0,     1,     1,     3,     3,     2,     2, 
          6,     6,     7,     7,     5,     5,     5,     5,     5,     8, 
          8,     8,     4,     4,     4,     4,     4,     4,     9,     9, 
    );
    protected static $yyLen= array(2,
          2,     1,     1,     0,     4,     3,     5,     3,     4,     3, 
          3,     1,     3,     1,     2,     2,     1,     1,     0,     1, 
          1,     1,     4,     3,     1,     1,     1,     1,     3,     1, 
    );
    protected static $yyDefRed= array(0,
         20,    21,    22,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    16,     0,     0,     0,     0,     0,    12,    15, 
          0,     6,     0,     0,     0,     0,    10,     0,    25,    27, 
          0,    26,    28,     8,     0,     5,     9,    13,    11,     0, 
          0,    24,    30,     0,     7,     0,    23,    29, 
    );
    protected static $yyDgoto= array(6,
          7,     8,    12,    34,     9,    18,    19,    10,    44, 
    );
    protected static $yySindex = array(         -251,
          0,     0,     0,  -249,  -214,     0,  -224,  -219,  -243,  -233, 
        -43,   -38,     0,  -249,  -219,  -243,   -26,   -37,     0,     0, 
       -230,     0,  -222,   -36,   -35,  -230,     0,  -243,     0,     0, 
          7,     0,     0,     0,    -9,     0,     0,     0,     0,   -41, 
       -230,     0,     0,   -11,     0,  -230,     0,     0, 
    );
    protected static $yyRindex= array(            1,
          0,     0,     0,     0,  -243,     0,     2,     3,     0,  -207, 
          0,     0,     0,     0,     4,     0,   -33,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,    47,    41,   -21,    21,    40,    29,    53,     0, 
    );
    protected static $yyTable = array(42,
          4,     2,     3,     1,    38,    23,    28,    23,    28,    11, 
         14,     1,     2,     3,     4,     5,    17,    21,    43,    45, 
         22,    27,    36,    37,    48,    14,    29,    30,    16,    47, 
         31,    32,    46,    20,    26,    16,    35,    33,     1,     2, 
          3,    14,     5,     1,     2,     3,    40,     5,     1,     2, 
          3,    41,    18,    15,    24,    25,    39,    13,     0,     0, 
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
          0,     0,     0,     0,     0,    29,    30,     0,     0,    31, 
         32,     0,     0,     0,     0,     0,    33,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
         19,    19,    19,    19, 
    );
    protected static $yyCheck = array(41,
          0,     0,     0,     0,    26,    44,    44,    44,    44,   259, 
         44,   263,   264,   265,   266,   267,   260,    61,    40,    41, 
         59,    59,    59,    59,    46,    59,   257,   258,     8,    41, 
        261,   262,    44,   267,    61,    15,   259,   268,   263,   264, 
        265,   266,   267,   263,   264,   265,    40,   267,   263,   264, 
        265,    61,   260,     7,    14,    16,    28,     5,    -1,    -1, 
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
         -1,    -1,    -1,    -1,    -1,   257,   258,    -1,    -1,   261, 
        262,    -1,    -1,    -1,    -1,    -1,   268,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
        260,   260,   260,   260, 
    );
    protected static $yyFinal= 6;
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
      'T_NUMBER', 'T_STRING', 'T_VARIABLE', 'T_ARRAY', 'T_NULL', 'T_PUBLIC', 
      'T_PRIVATE', 'T_PROTECTED', 'T_CONST', 'T_STATIC', 'T_BOOLEAN', 
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

    case 1:  #line 23 "./grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setConstants($yyVals[-1+$yyTop]); $yyVal->setMembers($yyVals[0+$yyTop]); } break;

    case 2:  #line 24 "./grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setConstants($yyVals[0+$yyTop]); } break;

    case 3:  #line 25 "./grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setMembers($yyVals[0+$yyTop]); } break;

    case 4:  #line 26 "./grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); } break;

    case 5:  #line 30 "./grammar/Class.jay"
    { $yyVal= array_merge($yyVals[-3+$yyTop], $yyVals[-1+$yyTop]); } break;

    case 6:  #line 31 "./grammar/Class.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 7:  #line 34 "./grammar/Class.jay"
    { $yyVals[-4+$yyTop][]= new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue()); $yyVal= $yyVals[-4+$yyTop]; } break;

    case 8:  #line 35 "./grammar/Class.jay"
    { $yyVal= array(new xp·ide·source·element·Classconstant($yyVals[-2+$yyTop]->getValue())); } break;

    case 9:  #line 39 "./grammar/Class.jay"
    { foreach($yyVals[-1+$yyTop] as $m) { $m->setStatic($yyVals[-2+$yyTop]['static']); $m->setScope($yyVals[-2+$yyTop]['scope']); } $yyVal= array_merge($yyVals[-3+$yyTop],$yyVals[-1+$yyTop]); } break;

    case 10:  #line 40 "./grammar/Class.jay"
    { foreach($yyVals[-1+$yyTop] as $m) { $m->setStatic($yyVals[-2+$yyTop]['static']); $m->setScope($yyVals[-2+$yyTop]['scope']); } $yyVal= $yyVals[-1+$yyTop]; } break;

    case 11:  #line 43 "./grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop];} break;

    case 12:  #line 44 "./grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 13:  #line 47 "./grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[-2+$yyTop]->getValue(), 1), NULL, $yyVals[0+$yyTop]); } break;

    case 14:  #line 48 "./grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 15:  #line 52 "./grammar/Class.jay"
    { $yyVal= array('scope' => $yyVals[-1+$yyTop], 'static' => TRUE); } break;

    case 16:  #line 53 "./grammar/Class.jay"
    { $yyVal= array('scope' => $yyVals[0+$yyTop], 'static' => TRUE); } break;

    case 17:  #line 54 "./grammar/Class.jay"
    { $yyVal= array('scope' => xp·ide·source·Scope::$PUBLIC, 'static' => TRUE); } break;

    case 18:  #line 55 "./grammar/Class.jay"
    { $yyVal= array('scope' => $yyVals[0+$yyTop], 'static' => FALSE); } break;

    case 19:  #line 56 "./grammar/Class.jay"
    { $yyVal= array('scope' => xp·ide·source·Scope::$PUBLIC, 'static' => FALSE); } break;

    case 20:  #line 60 "./grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PUBLIC; } break;

    case 21:  #line 61 "./grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PRIVATE; } break;

    case 22:  #line 62 "./grammar/Class.jay"
    { $yyVal= xp·ide·source·Scope::$PROTECTED; } break;

    case 23:  #line 66 "./grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-1+$yyTop]); } break;

    case 24:  #line 67 "./grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array(); } break;

    case 25:  #line 68 "./grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 26:  #line 69 "./grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 27:  #line 70 "./grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 28:  #line 71 "./grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 29:  #line 75 "./grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 30:  #line 76 "./grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;
#line 405 "-"
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
