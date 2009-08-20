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
    const T_DOUBLE_ARROW= 269;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     0,     0,     1,     1,     3,     3,     2,     2, 
          6,     6,     7,     7,     5,     5,     5,     5,     5,     8, 
          8,     8,     9,     9,     9,     9,     4,     4,     4,     4, 
         10,    10,    10,    10, 
    );
    protected static $yyLen= array(2,
          2,     1,     1,     0,     4,     3,     5,     3,     4,     3, 
          3,     1,     3,     1,     2,     2,     1,     1,     0,     1, 
          1,     1,     1,     1,     1,     1,     5,     4,     3,     1, 
          5,     3,     3,     1, 
    );
    protected static $yyDefRed= array(0,
         20,    21,    22,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    16,     0,     0,     0,     0,     0,    12,    15, 
          0,     6,     0,     0,     0,     0,    10,     0,    23,    25, 
          0,    24,    26,     8,    30,     0,     5,     9,    13,    11, 
          0,     0,    29,    34,     0,     0,     7,     0,     0,    28, 
         33,    27,    32,     0,     0,    31, 
    );
    protected static $yyDgoto= array(6,
          7,     8,    12,    34,     9,    18,    19,    10,    35,    46, 
    );
    protected static $yySindex = array(         -224,
          0,     0,     0,  -253,  -209,     0,  -219,  -214,  -249,  -248, 
        -24,   -37,     0,  -253,  -214,  -249,    -4,   -35,     0,     0, 
       -245,     0,  -207,   -34,   -30,  -245,     0,  -249,     0,     0, 
         18,     0,     0,     0,     0,    -2,     0,     0,     0,     0, 
        -41,  -245,     0,     0,  -208,    -9,     0,  -245,   -33,     0, 
          0,     0,     0,  -206,  -245,     0, 
    );
    protected static $yyRindex= array(            1,
          0,     0,     0,     0,  -249,     0,     2,     3,     0,  -200, 
          0,     0,     0,     0,     4,     0,   -29,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,    -8,     0,     0,     0,     0,     0, 
          0,     0,     0,    -8,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,    55,    50,   -21,    23,    49,    38,    62,   -23,     0, 
    );
    protected static $yyTable = array(43,
          4,     2,     3,     1,    39,    11,    23,    52,    28,    23, 
         17,    29,    30,    28,    14,    31,    32,    45,    20,    44, 
         47,    22,    33,    27,    37,    54,    51,    53,    38,    14, 
         16,    50,    30,    56,    49,    30,    21,    16,     1,     2, 
          3,     4,     5,     1,     2,     3,    14,     5,     1,     2, 
          3,    36,     5,     1,     2,     3,    26,    41,    42,    18, 
         48,    15,    55,    24,    25,    40,    13,     0,     0,     0, 
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
         32,     0,     0,    29,    30,     0,    33,    31,    32,     0, 
          0,     0,     0,     0,    33,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
         19,    19,    19,    19, 
    );
    protected static $yyCheck = array(41,
          0,     0,     0,     0,    26,   259,    44,    41,    44,    44, 
        260,   257,   258,    44,    44,   261,   262,    41,   267,    41, 
         42,    59,   268,    59,    59,    49,    48,    49,    59,    59, 
          8,    41,    41,    55,    44,    44,    61,    15,   263,   264, 
        265,   266,   267,   263,   264,   265,   266,   267,   263,   264, 
        265,   259,   267,   263,   264,   265,    61,    40,    61,   260, 
        269,     7,   269,    14,    16,    28,     5,    -1,    -1,    -1, 
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
        262,    -1,    -1,   257,   258,    -1,   268,   261,   262,    -1, 
         -1,    -1,    -1,    -1,   268,    -1,    -1,    -1,    -1,    -1, 
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
      'T_DOUBLE_ARROW', 
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
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 24:  #line 67 "./grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 25:  #line 68 "./grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 26:  #line 69 "./grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]->getValue(); } break;

    case 27:  #line 73 "./grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-2+$yyTop]); } break;

    case 28:  #line 74 "./grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array($yyVals[-1+$yyTop]); } break;

    case 29:  #line 75 "./grammar/Class.jay"
    { $yyVal= new xp·ide·source·element·Array(); } break;

    case 30:  #line 76 "./grammar/Class.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 31:  #line 80 "./grammar/Class.jay"
    { $yyVals[-4+$yyTop][$yyVals[-2+$yyTop]]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-4+$yyTop]; } break;

    case 32:  #line 81 "./grammar/Class.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 33:  #line 82 "./grammar/Class.jay"
    { $yyVal= array($yyVals[-2+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 34:  #line 83 "./grammar/Class.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;
#line 424 "-"
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
