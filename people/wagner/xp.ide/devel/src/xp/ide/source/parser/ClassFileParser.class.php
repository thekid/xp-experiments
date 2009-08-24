<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  $package= 'xp.ide.source.parser';

#line 2 "grammar/ClassFile.jay"

  uses(
    'xp.ide.source.Scope',
    'xp.ide.source.element.Package',
    'xp.ide.source.element.Uses',
    'xp.ide.source.element.Classdef',
    'xp.ide.source.element.ClassFile',
    'xp.ide.source.element.BlockComment',
    'xp.ide.source.element.Apidoc'
  );

#line 21 "-"

  uses('xp.ide.source.parser.Parser');

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class xp·ide·source·parser·ClassFileParser extends xp·ide·source·parser·Parser {
    const T_CLASS= 257;
    const T_CLOSE_BCOMMENT= 258;
    const T_CLOSE_TAG= 259;
    const T_CONTENT_BCOMMENT= 260;
    const T_ENCAPSED_STRING= 261;
    const T_EXTENDS= 262;
    const T_IMPLEMENTS= 263;
    const T_OPEN_BCOMMENT= 264;
    const T_OPEN_TAG= 265;
    const T_USES= 266;
    const T_CONTENT_INNERBLOCK= 267;
    const T_VARIABLE= 268;
    const T_STRING= 269;
    const T_OPEN_APIDOC= 270;
    const T_CONTENT_APIDOC= 271;
    const T_CLOSE_APIDOC= 272;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     2,     2,     5,     5,     4,     1,     1,     1, 
          1,     1,     1,     1,     7,     8,     9,     9,     6,     3, 
    );
    protected static $yyLen= array(2,
          4,     3,     6,     8,     3,     1,     3,     3,     2,     2, 
          2,     1,     1,     1,     4,     5,     3,     1,     3,     3, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    14,     0,     0,     0,     0,     0,     2,     0,     0, 
         10,    11,    19,    18,     0,     0,    20,     1,     0,     8, 
          0,     0,    15,     0,    17,    16,     0,     0,     0,     3, 
          6,     0,     0,     0,     4,     7,     5, 
    );
    protected static $yyDgoto= array(2,
          7,     8,     9,    40,    42,    10,    11,    12,    25, 
    );
    protected static $yySindex = array(         -256,
       -260,     0,  -247,   -25,   -45,  -254,  -252,  -240,  -237,  -261, 
       -245,     0,  -236,  -238,  -235,  -248,  -234,     0,  -242,  -245, 
          0,     0,     0,     0,   -30,   -31,     0,     0,  -233,     0, 
       -231,   -28,     0,  -232,     0,     0,  -123,  -230,  -229,     0, 
          0,   -43,   -93,  -228,     0,     0,     0, 
    );
    protected static $yyRindex= array(            0,
          0,     0,     0,     0,     0,     0,     0,     0,     0,  -227, 
       -226,     0,     0,     0,     0,     0,     0,     0,     0,  -225, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,    26,     0,    -7,     0,     0,    24,    -8,     0, 
    );
    protected static $yyTable = array(39,
         44,    21,    22,     3,     4,     4,     5,     5,     1,     6, 
         32,    30,    13,    31,    14,    15,    16,     6,    18,    19, 
          4,    23,    24,    27,    28,    26,    29,    33,    34,    35, 
         36,    46,    17,    20,    45,     0,    37,    43,    41,     0, 
         47,     0,    12,    13,     9,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    39, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    38, 
    );
    protected static $yyCheck = array(123,
         44,    10,    11,   264,   266,   266,   268,   268,   265,   270, 
         41,    20,   260,    44,    40,    61,   271,   270,   259,   257, 
        266,   258,   261,   272,   259,   261,   269,    59,   262,   261, 
         59,   125,     7,    10,    42,    -1,   269,   267,   269,    -1, 
        269,    -1,   270,   270,   270,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   123, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   263, 
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
      'T_ENCAPSED_STRING', 'T_EXTENDS', 'T_IMPLEMENTS', 'T_OPEN_BCOMMENT', 
      'T_OPEN_TAG', 'T_USES', 'T_CONTENT_INNERBLOCK', 'T_VARIABLE', 'T_STRING', 
      'T_OPEN_APIDOC', 'T_CONTENT_APIDOC', 'T_CLOSE_APIDOC', 
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

    case 1:  #line 23 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal->setClassdef($yyVals[-1+$yyTop]); } break;

    case 2:  #line 24 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setClassdef($yyVals[-1+$yyTop]); } break;

    case 3:  #line 28 "grammar/ClassFile.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-5+$yyTop]);
    $yyVal->setName($yyVals[-3+$yyTop]->getValue());
    $yyVal->setParent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 4:  #line 34 "grammar/ClassFile.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-7+$yyTop]);
    $yyVal->setName($yyVals[-5+$yyTop]->getValue());
    $yyVal->setParent($yyVals[-3+$yyTop]->getValue());
    $yyVal->setInterfaces($yyVals[-1+$yyTop]);
  } break;

    case 5:  #line 43 "grammar/ClassFile.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]->getValue(); $yyVal= $yyVals[-2+$yyTop]; } break;

    case 6:  #line 44 "grammar/ClassFile.jay"
    { $yyVal= array($yyVals[0+$yyTop]->getValue()); } break;

    case 7:  #line 48 "grammar/ClassFile.jay"
    {
    $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setContent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 8:  #line 54 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-2+$yyTop]); $yyVal->setPackage($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 9:  #line 55 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-1+$yyTop]); $yyVal->setPackage($yyVals[0+$yyTop]); } break;

    case 10:  #line 56 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 11:  #line 57 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setPackage($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 12:  #line 58 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[0+$yyTop]); } break;

    case 13:  #line 59 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setPackage($yyVals[0+$yyTop]); } break;

    case 14:  #line 60 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 15:  #line 64 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Package(); $yyVal->setPathname($this->unquote($yyVals[-1+$yyTop]->getValue())); } break;

    case 16:  #line 68 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Uses(); $yyVal->setClassnames($yyVals[-2+$yyTop]); } break;

    case 17:  #line 71 "grammar/ClassFile.jay"
    { $yyVals[-2+$yyTop][]= $this->unquote($yyVals[0+$yyTop]->getValue()); $yyVal= $yyVals[-2+$yyTop]; } break;

    case 18:  #line 72 "grammar/ClassFile.jay"
    { $yyVal= array($this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 19:  #line 76 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·BlockComment(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 20:  #line 80 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;
#line 367 "-"
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
