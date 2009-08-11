<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  
#line 2 "./grammar/php52.jay"

  $package= 'xp.ide.source.parser';

  uses(
    'xp.ide.source.element.Package',
    'xp.ide.source.element.Uses',
    'xp.ide.source.element.ClassFile',
    'xp.ide.source.element.BlockComment'
  );

#line 20 "-"

  uses('text.parser.generic.AbstractParser');

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class xp·ide·source·parser·Php52Parser extends AbstractParser {
    const T_NUMBER= 257;
    const T_STRING= 258;
    const T_OPEN_TAG= 259;
    const T_CLOSE_TAG= 260;
    const T_OPEN_BCOMMENT= 261;
    const T_CLOSE_BCOMMENT= 262;
    const T_CONTENT_BCOMMENT= 263;
    const T_USES= 264;
    const T_ENCAPSE_STRING= 265;
    const T_VARIABLE= 266;
    const T_CLASS= 267;
    const T_EXTENDS= 268;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     2,     1,     1,     1,     1,     1,     1,     1, 
          4,     5,     6,     6,     3, 
    );
    protected static $yyLen= array(2,
          4,     3,     7,     3,     2,     2,     2,     1,     1,     1, 
          4,     5,     3,     1,     3, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     0,     0,     0,     0,     0,     0,    10, 
          0,     0,     0,     0,     0,     2,     0,     0,     7,     6, 
         15,    14,     0,     0,     1,     0,     4,     0,     0,    11, 
          0,    12,    13,     0,     0,     3, 
    );
    protected static $yyDgoto= array(2,
          6,     7,     8,     9,    10,    23, 
    );
    protected static $yySindex = array(         -256,
       -259,     0,  -251,   -36,   -48,  -246,  -244,  -258,  -247,     0, 
       -243,  -245,  -242,  -239,  -249,     0,  -236,  -247,     0,     0, 
          0,     0,   -30,   -35,     0,  -241,     0,   -34,  -237,     0, 
       -232,     0,     0,   -94,   -95,     0, 
    );
    protected static $yyRindex= array(            0,
          0,     0,     0,     0,     0,     0,     0,  -230,  -229,     0, 
          0,     0,     0,     0,     0,     0,     0,  -228,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,    28,    29,    30,    -8,     0, 
    );
    protected static $yyTable = array(19,
         20,     3,     1,    12,     4,     4,     5,     5,    17,    27, 
         28,    11,    13,    29,     3,    16,     4,    17,    21,    22, 
         25,    26,    24,    30,    32,    34,    31,    33,    35,    36, 
          8,     9,     5,    14,    15,     0,     0,    18, 
    );
    protected static $yyCheck = array(8,
          9,   261,   259,    40,   264,   264,   266,   266,   267,    18, 
         41,   263,    61,    44,   261,   260,   264,   267,   262,   265, 
        260,   258,   265,    59,    59,   258,   268,   265,   123,   125, 
        261,   261,   261,     6,     6,    -1,    -1,     8, 
    );
    protected static $yyFinal= 2;
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
      NULL, "'{'", NULL, "'}'", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_NUMBER', 
      'T_STRING', 'T_OPEN_TAG', 'T_CLOSE_TAG', 'T_OPEN_BCOMMENT', 
      'T_CLOSE_BCOMMENT', 'T_CONTENT_BCOMMENT', 'T_USES', 'T_ENCAPSE_STRING', 
      'T_VARIABLE', 'T_CLASS', 'T_EXTENDS', 
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

    case 1:  #line 21 "./grammar/php52.jay"
    {
    $yyVal= new xp·ide·source·element·ClassFile();
    $yyVal->setElements($yyVals[-2+$yyTop]);
  } break;

    case 2:  #line 25 "./grammar/php52.jay"
    {
    $yyVal= new xp·ide·source·element·ClassFile();
  } break;

    case 4:  #line 35 "./grammar/php52.jay"
    { $yyVal= array($yyVals[-2+$yyTop], $yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 5:  #line 36 "./grammar/php52.jay"
    { $yyVal= array($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 6:  #line 37 "./grammar/php52.jay"
    { $yyVal= array($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 7:  #line 38 "./grammar/php52.jay"
    { $yyVal= array($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 8:  #line 39 "./grammar/php52.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 9:  #line 40 "./grammar/php52.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 10:  #line 41 "./grammar/php52.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 11:  #line 44 "./grammar/php52.jay"
    {
    $yyVal= new xp·ide·source·element·Package();
    $yyVal->setPathname($yyVals[-1+$yyTop]);
  } break;

    case 12:  #line 51 "./grammar/php52.jay"
    {
    $yyVal= new xp·ide·source·element·Uses();
    $yyVal->setClassnames($yyVals[-2+$yyTop]);
  } break;

    case 13:  #line 57 "./grammar/php52.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 14:  #line 58 "./grammar/php52.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 15:  #line 62 "./grammar/php52.jay"
    {
    $yyVal= new xp·ide·source·element·BlockComment();
    $yyVal->setText($yyVals[-1+$yyTop]);
  } break;
#line 321 "-"
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
