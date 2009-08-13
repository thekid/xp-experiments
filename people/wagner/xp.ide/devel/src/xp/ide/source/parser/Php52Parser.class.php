<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  
#line 2 "./grammar/php52.jay"

  $package= 'xp.ide.source.parser';

  uses(
    'xp.ide.source.Scope',
    'xp.ide.source.element.Package',
    'xp.ide.source.element.Uses',
    'xp.ide.source.element.Classdef',
    'xp.ide.source.element.Classmember',
    'xp.ide.source.element.ClassFile',
    'xp.ide.source.element.BlockComment'
  );

#line 23 "-"

  uses('text.parser.generic.AbstractParser');

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class xp·ide·source·parser·Php52Parser extends AbstractParser {
    const T_CLASS= 257;
    const T_CLOSE_BCOMMENT= 258;
    const T_CLOSE_TAG= 259;
    const T_CONTENT_BCOMMENT= 260;
    const T_ENCAPSE_STRING= 261;
    const T_EXTENDS= 262;
    const T_IMPLEMENTS= 263;
    const T_NUMBER= 264;
    const T_OPEN_BCOMMENT= 265;
    const T_OPEN_TAG= 266;
    const T_STRING= 267;
    const T_USES= 268;
    const T_VARIABLE= 269;
    const T_ARRAY= 270;
    const T_NULL= 271;
    const T_PUBLIC= 272;
    const T_PRIVATE= 273;
    const T_PROTECTED= 274;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     2,     2,     5,     5,     4,     4,     6,     6, 
          8,     8,     9,     9,     1,     1,     1,     1,     1,     1, 
          1,    11,    12,    13,    13,     3,     7,     7,     7,    10, 
         10,    10,    10, 
    );
    protected static $yyLen= array(2,
          4,     3,     6,     8,     3,     1,     3,     2,     4,     3, 
          3,     1,     3,     1,     3,     2,     2,     2,     1,     1, 
          1,     4,     5,     3,     1,     3,     1,     1,     1,     3, 
          1,     1,     1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     0,     0,     0,     0,     0,     0,    21, 
          0,     0,     0,     0,     0,     2,     0,     0,    17,    18, 
         26,    25,     0,     0,     1,     0,    15,     0,     0,    22, 
          0,    24,    23,     0,     0,     0,     3,     6,     0,    27, 
         28,    29,     8,     0,     0,     0,     4,     7,     0,     0, 
          0,    12,     5,     0,     0,     0,    10,     9,    33,    31, 
          0,    32,    13,    11,     0,    30, 
    );
    protected static $yyDgoto= array(2,
          6,     7,     8,    37,    39,    44,    45,    51,    52,    63, 
          9,    10,    23, 
    );
    protected static $yySindex = array(         -252,
       -241,     0,  -242,   -15,   -35,  -236,  -229,  -246,  -237,     0, 
       -226,  -228,  -227,  -224,  -221,     0,  -230,  -237,     0,     0, 
          0,     0,   -31,   -21,     0,  -223,     0,  -220,   -19,     0, 
       -225,     0,     0,  -121,  -222,  -125,     0,     0,   -43,     0, 
          0,     0,     0,  -122,  -219,  -218,     0,     0,  -219,   -18, 
        -40,     0,     0,   -39,  -255,  -219,     0,     0,     0,     0, 
          4,     0,     0,     0,     5,     0, 
    );
    protected static $yyRindex= array(            0,
          0,     0,     0,     0,     0,     0,     0,  -217,  -214,     0, 
          0,     0,     0,     0,     0,     0,     0,  -213,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,   -38, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,    41,    47,    15,     0,     0,    11,     7,     1,     0, 
         50,    -1,     0, 
    );
    protected static $yyTable = array(43,
         46,    36,    48,    56,    56,    14,    19,    20,    59,    29, 
         17,    60,    28,     1,    61,    62,    27,    11,    57,    58, 
         14,     4,     5,     3,    12,    13,     4,     5,     3,    16, 
          4,    21,    22,    24,    25,    17,    26,    30,    31,    33, 
         32,    34,    55,    65,    38,    66,    14,    19,    53,    50, 
         20,    16,    15,    47,    49,    54,    64,    18,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    36, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    35,     0,     0,     0,     0,    40,    41,    42,    40, 
         41,    42, 
    );
    protected static $yyCheck = array(125,
         44,   123,   125,    44,    44,    44,     8,     9,   264,    41, 
        257,   267,    44,   266,   270,   271,    18,   260,    59,    59, 
         59,   268,   269,   265,    40,    61,   268,   269,   265,   259, 
        268,   258,   261,   261,   259,   257,   267,    59,   262,    59, 
        261,   267,    61,    40,   267,    41,     6,   265,   267,   269, 
        265,   265,     6,    39,    44,    49,    56,     8,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   123, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,   263,    -1,    -1,    -1,    -1,   272,   273,   274,   272, 
        273,   274, 
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
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_CLASS', 
      'T_CLOSE_BCOMMENT', 'T_CLOSE_TAG', 'T_CONTENT_BCOMMENT', 
      'T_ENCAPSE_STRING', 'T_EXTENDS', 'T_IMPLEMENTS', 'T_NUMBER', 
      'T_OPEN_BCOMMENT', 'T_OPEN_TAG', 'T_STRING', 'T_USES', 'T_VARIABLE', 
      'T_ARRAY', 'T_NULL', 'T_PUBLIC', 'T_PRIVATE', 'T_PROTECTED', 
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

    case 1:  #line 25 "./grammar/php52.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal->setClassdef($yyVals[-1+$yyTop]); } break;

    case 2:  #line 26 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setClassdef($yyVals[-1+$yyTop]); } break;

    case 3:  #line 30 "./grammar/php52.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setName($yyVals[-3+$yyTop]);
    $yyVal->setParent($yyVals[-1+$yyTop]);
  } break;

    case 4:  #line 35 "./grammar/php52.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setName($yyVals[-5+$yyTop]);
    $yyVal->setParent($yyVals[-3+$yyTop]);
    $yyVal->setInterfaces($yyVals[-1+$yyTop]);
  } break;

    case 5:  #line 43 "./grammar/php52.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 6:  #line 44 "./grammar/php52.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 7:  #line 48 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setMembers($yyVals[-1+$yyTop]); } break;

    case 8:  #line 49 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Classdef(); } break;

    case 9:  #line 52 "./grammar/php52.jay"
    { foreach($yyVals[-1+$yyTop] as $m) $m->setScope($yyVals[-2+$yyTop]); $yyVal= array_merge($yyVals[-3+$yyTop],$yyVals[-1+$yyTop]); } break;

    case 10:  #line 53 "./grammar/php52.jay"
    { foreach($yyVals[-1+$yyTop] as $m) $m->setScope($yyVals[-2+$yyTop]); $yyVal= $yyVals[-1+$yyTop]; } break;

    case 11:  #line 56 "./grammar/php52.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop];} break;

    case 12:  #line 57 "./grammar/php52.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 13:  #line 60 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[-2+$yyTop], 1)); } break;

    case 14:  #line 61 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Classmember(substr($yyVals[0+$yyTop], 1)); } break;

    case 15:  #line 64 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-2+$yyTop]); $yyVal->setPackage($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 16:  #line 65 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-1+$yyTop]); $yyVal->setPackage($yyVals[0+$yyTop]); } break;

    case 17:  #line 66 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 18:  #line 67 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setPackage($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 19:  #line 68 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[0+$yyTop]); } break;

    case 20:  #line 69 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setPackage($yyVals[0+$yyTop]); } break;

    case 21:  #line 70 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 22:  #line 74 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Package(); $yyVal->setPathname($yyVals[-1+$yyTop]); } break;

    case 23:  #line 78 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·Uses(); $yyVal->setClassnames($yyVals[-2+$yyTop]); } break;

    case 24:  #line 81 "./grammar/php52.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]; $yyVal= $yyVals[-2+$yyTop]; } break;

    case 25:  #line 82 "./grammar/php52.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 26:  #line 86 "./grammar/php52.jay"
    { $yyVal= new xp·ide·source·element·BlockComment(); $yyVal->setText($yyVals[-1+$yyTop]); } break;

    case 27:  #line 90 "./grammar/php52.jay"
    { $yyVal= xp·ide·source·Scope::$PUBLIC; } break;

    case 28:  #line 91 "./grammar/php52.jay"
    { $yyVal= xp·ide·source·Scope::$PRIVATE; } break;

    case 29:  #line 92 "./grammar/php52.jay"
    { $yyVal= xp·ide·source·Scope::$PROTECTED; } break;
#line 410 "-"
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
