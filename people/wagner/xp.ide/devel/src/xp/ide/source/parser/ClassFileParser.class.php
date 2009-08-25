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
    'xp.ide.source.element.Annotation',
    'xp.ide.source.element.Apidoc'
  );

#line 22 "-"

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
    const T_DIRECTIVE_APIDOC= 273;
    const T_START_ANNOTATION= 274;
    const T_CLOSE_ANNOTATION= 275;
    const T_ANNOTATION= 276;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     2,     2,     6,     6,     5,     4,     4,     7, 
          7,     8,     8,     8,     9,     9,    10,    10,     1,     1, 
          1,     1,     1,     1,     1,    12,    13,    14,    14,    11, 
          3,     3,    15,    15, 
    );
    protected static $yyLen= array(2,
          4,     3,     7,     9,     3,     1,     3,     3,     0,     3, 
          1,     4,     3,     1,     3,     1,     3,     1,     3,     2, 
          2,     2,     1,     1,     1,     4,     5,     3,     1,     3, 
          4,     3,     2,     1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    25,     0,     0,     0,     0,     0,     2,     0,     0, 
          0,    21,    22,    30,    29,     0,     0,    32,    34,     0, 
          1,     0,     0,    11,     0,    19,     0,     0,    26,    31, 
         33,     0,     8,     0,     0,    28,    27,    18,     0,    13, 
          0,    16,    10,     0,     0,     0,    12,     0,    17,    15, 
          0,     0,     3,     6,     0,     0,     0,     4,     7,     5, 
    );
    protected static $yyDgoto= array(2,
          7,     8,     9,    20,    63,    65,    33,    34,    51,    52, 
         10,    11,    12,    26,    30, 
    );
    protected static $yySindex = array(         -252,
       -256,     0,  -241,   -14,   -34,  -243,  -240,  -230,  -242,  -257, 
       -235,     0,  -225,  -227,  -226,  -250,  -223,     0,  -239,  -219, 
       -235,     0,     0,     0,     0,   -24,   -20,     0,     0,  -248, 
          0,     1,   -44,     0,  -229,     0,  -218,   -17,     0,     0, 
          0,   -39,     0,  -239,  -217,     0,     0,     0,   -15,     0, 
        -23,     0,     0,  -222,  -213,  -254,     0,  -120,     0,     0, 
       -220,  -216,     0,     0,   -40,   -81,  -215,     0,     0,     0, 
    );
    protected static $yyRindex= array(            0,
          0,     0,     0,     0,     0,     0,     0,     0,  -207,  -214, 
       -212,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
       -211,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,   -43,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,    45,     0,     0,   -12,     0,     0,    11,     0,     4, 
          0,    47,    -5,     0,     0, 
    );
    protected static $yyTable = array(44,
         14,    50,    62,    67,    22,    23,    48,     3,     4,     4, 
          5,     5,     1,     6,    49,    36,    38,    57,    13,    37, 
         56,    28,    29,    40,    41,    14,    15,    16,    18,     6, 
          4,    19,    24,    25,    27,    31,    32,    35,    39,    45, 
         42,    47,    46,    69,    54,    55,    58,    59,    64,     9, 
         66,    17,    68,    70,    53,    23,    21,    24,    20,    60, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    62,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    61,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    48,     0,     0,     0,     0,     0,     0,     0,    49, 
         43,    14, 
    );
    protected static $yyCheck = array(44,
         44,    41,   123,    44,    10,    11,   261,   264,   266,   266, 
        268,   268,   265,   270,   269,    21,    41,    41,   260,    44, 
         44,   272,   273,   272,   273,    40,    61,   271,   259,   270, 
        266,   274,   258,   261,   261,   259,   276,   257,    59,   269, 
         40,    59,   261,   125,   262,    61,   269,   261,   269,   257, 
        267,     7,    65,   269,    44,   270,    10,   270,   270,    56, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,   123,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,   263,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,   261,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   269, 
        275,   275, 
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
      'T_DIRECTIVE_APIDOC', 'T_START_ANNOTATION', 'T_CLOSE_ANNOTATION', 
      'T_ANNOTATION', 
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

    case 1:  #line 25 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal->setClassdef($yyVals[-1+$yyTop]); } break;

    case 2:  #line 26 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setClassdef($yyVals[-1+$yyTop]); } break;

    case 3:  #line 30 "grammar/ClassFile.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-6+$yyTop]);
    $yyVal->setAnnotations($yyVals[-5+$yyTop]);
    $yyVal->setName($yyVals[-3+$yyTop]->getValue());
    $yyVal->setParent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 4:  #line 37 "grammar/ClassFile.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-8+$yyTop]);
    $yyVal->setAnnotations($yyVals[-7+$yyTop]);
    $yyVal->setName($yyVals[-5+$yyTop]->getValue());
    $yyVal->setParent($yyVals[-3+$yyTop]->getValue());
    $yyVal->setInterfaces($yyVals[-1+$yyTop]);
  } break;

    case 5:  #line 47 "grammar/ClassFile.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]->getValue(); $yyVal= $yyVals[-2+$yyTop]; } break;

    case 6:  #line 48 "grammar/ClassFile.jay"
    { $yyVal= array($yyVals[0+$yyTop]->getValue()); } break;

    case 7:  #line 52 "grammar/ClassFile.jay"
    {
    $yyVal= new xp·ide·source·element·Classdef(); $yyVal->setContent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 8:  #line 58 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-1+$yyTop];} break;

    case 9:  #line 59 "grammar/ClassFile.jay"
    { $yyVal= array(); } break;

    case 10:  #line 62 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 11:  #line 63 "grammar/ClassFile.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 12:  #line 66 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-3+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 13:  #line 67 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-2+$yyTop]->getValue(), 1)); } break;

    case 14:  #line 68 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 15:  #line 71 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-2+$yyTop]; list($k, $v)= each($yyVals[0+$yyTop]); $yyVal[$k]= $v; } break;

    case 16:  #line 72 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 17:  #line 75 "grammar/ClassFile.jay"
    { $yyVal= array($yyVals[-2+$yyTop]->getValue() => $this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 18:  #line 76 "grammar/ClassFile.jay"
    { $yyVal= array($this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 19:  #line 80 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-2+$yyTop]); $yyVal->setPackage($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 20:  #line 81 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-1+$yyTop]); $yyVal->setPackage($yyVals[0+$yyTop]); } break;

    case 21:  #line 82 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 22:  #line 83 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setPackage($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 23:  #line 84 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[0+$yyTop]); } break;

    case 24:  #line 85 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setPackage($yyVals[0+$yyTop]); } break;

    case 25:  #line 86 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 26:  #line 90 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Package(); $yyVal->setPathname($this->unquote($yyVals[-1+$yyTop]->getValue())); } break;

    case 27:  #line 94 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Uses(); $yyVal->setClassnames($yyVals[-2+$yyTop]); } break;

    case 28:  #line 97 "grammar/ClassFile.jay"
    { $yyVals[-2+$yyTop][]= $this->unquote($yyVals[0+$yyTop]->getValue()); $yyVal= $yyVals[-2+$yyTop]; } break;

    case 29:  #line 98 "grammar/ClassFile.jay"
    { $yyVal= array($this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 30:  #line 102 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·BlockComment(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 31:  #line 106 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-2+$yyTop]->getValue()); $yyVal->setDirectives($yyVals[-1+$yyTop]); } break;

    case 32:  #line 107 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 33:  #line 111 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue()); } break;

    case 34:  #line 112 "grammar/ClassFile.jay"
    { $yyVal= array(new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue())); } break;
#line 450 "-"
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
