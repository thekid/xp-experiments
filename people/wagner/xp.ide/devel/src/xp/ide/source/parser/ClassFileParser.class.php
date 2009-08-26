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
    const T_ABSTRACT= 268;
    const T_VARIABLE= 269;
    const T_STRING= 270;
    const T_OPEN_APIDOC= 271;
    const T_CONTENT_APIDOC= 272;
    const T_CLOSE_APIDOC= 273;
    const T_DIRECTIVE_APIDOC= 274;
    const T_START_ANNOTATION= 275;
    const T_CLOSE_ANNOTATION= 276;
    const T_ANNOTATION= 277;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     2,     2,     5,     5,     6,     6,     7,     7, 
          4,     4,     8,     8,     9,     9,     9,    10,    10,    11, 
         11,     1,     1,     1,     1,     1,     1,     1,    13,    14, 
         15,    15,    12,     3,     3,    16,    16, 
    );
    protected static $yyLen= array(2,
          4,     3,     4,     3,     7,     5,     3,     1,     3,     2, 
          3,     0,     3,     1,     4,     3,     1,     3,     1,     3, 
          1,     3,     2,     2,     2,     1,     1,     1,     4,     5, 
          3,     1,     3,     4,     3,     2,     1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    28,     0,     0,     0,     0,     0,     2,     0,     0, 
          0,    24,    25,    33,    32,     0,     0,    35,    37,     0, 
          1,     0,     0,    14,     0,     0,     4,    22,     0,     0, 
         29,    34,    36,     0,    11,     0,     0,     3,    31,    30, 
         21,     0,    16,     0,    19,    13,     0,     0,     0,    15, 
          0,    20,    18,     0,     0,     6,     8,     0,     0,    10, 
          0,     5,     9,     7, 
    );
    protected static $yyDgoto= array(2,
          7,     8,     9,    20,    37,    68,    66,    33,    34,    54, 
         55,    10,    11,    12,    26,    30, 
    );
    protected static $yySindex = array(         -241,
       -243,     0,  -247,   -23,   -34,  -239,  -237,  -224,  -238,  -255, 
       -230,     0,  -220,  -222,  -221,  -244,  -218,     0,  -235,  -252, 
       -230,     0,     0,     0,     0,   -29,   -16,     0,     0,  -242, 
          0,     4,   -44,     0,  -225,  -211,     0,     0,  -214,   -11, 
          0,     0,     0,   -39,     0,  -235,  -213,     0,     0,     0, 
          0,   -10,     0,   -19,     0,     0,  -217,  -209,  -251,     0, 
       -119,     0,     0,  -216,  -122,     0,     0,   -38,   -75,     0, 
       -215,     0,     0,     0, 
    );
    protected static $yyRindex= array(            0,
          0,     0,     0,     0,     0,     0,     0,     0,  -248,  -212, 
       -210,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
       -208,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,   -43,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,    49,     0,     0,    21,     0,    -8,     0,    12,     0, 
          3,     0,    54,    -3,     0,     0, 
    );
    protected static $yyTable = array(46,
         17,    53,    70,    65,    35,    71,    22,    23,    12,    51, 
          4,    40,    13,     5,    39,    36,    14,    38,    52,    12, 
          3,    60,     4,     1,    59,     5,    15,     6,    28,    29, 
         42,    43,    16,     6,    18,     4,    19,    24,    25,    27, 
         31,    32,    41,    44,    47,    35,    49,    50,    57,    73, 
         58,    62,    61,    67,    74,    17,    48,    56,    26,    72, 
         27,    63,    23,    21,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,    65,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,    64,    69,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    51,     0,     0,     0,     0,     0,     0,     0,     0, 
         52,    45,    17, 
    );
    protected static $yyCheck = array(44,
         44,    41,   125,   123,   257,    44,    10,    11,   257,   261, 
        266,    41,   260,   269,    44,   268,    40,    21,   270,   268, 
        264,    41,   266,   265,    44,   269,    61,   271,   273,   274, 
        273,   274,   272,   271,   259,   266,   275,   258,   261,   261, 
        259,   277,    59,    40,   270,   257,   261,    59,   262,   125, 
         61,   261,   270,   270,   270,     7,    36,    46,   271,    68, 
        271,    59,   271,    10,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,   123,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,   263,   267,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,   261,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
        270,   276,   276, 
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
      'T_OPEN_TAG', 'T_USES', 'T_CONTENT_INNERBLOCK', 'T_ABSTRACT', 
      'T_VARIABLE', 'T_STRING', 'T_OPEN_APIDOC', 'T_CONTENT_APIDOC', 
      'T_CLOSE_APIDOC', 'T_DIRECTIVE_APIDOC', 'T_START_ANNOTATION', 
      'T_CLOSE_ANNOTATION', 'T_ANNOTATION', 
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
    { $yyVal= $this->top_element; $yyVal->setClassdef($yyVals[-1+$yyTop]); } break;

    case 3:  #line 30 "grammar/ClassFile.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-3+$yyTop]);
    $yyVal->setAnnotations($yyVals[-2+$yyTop]);
    $yyVal->setAbstract(TRUE);
  } break;

    case 4:  #line 36 "grammar/ClassFile.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-2+$yyTop]);
    $yyVal->setAnnotations($yyVals[-1+$yyTop]);
  } break;

    case 5:  #line 44 "grammar/ClassFile.jay"
    {
    $yyVal= new xp·ide·source·element·Classdef($yyVals[-5+$yyTop]->getValue(), $yyVals[-3+$yyTop]->getValue());
    $yyVal->setInterfaces($yyVals[-1+$yyTop]);
    $yyVal->setContent($yyVals[0+$yyTop]);
  } break;

    case 6:  #line 49 "grammar/ClassFile.jay"
    {
    $yyVal= new xp·ide·source·element·Classdef($yyVals[-3+$yyTop]->getValue(), $yyVals[-1+$yyTop]->getValue());
    $yyVal->setContent($yyVals[0+$yyTop]);
  } break;

    case 7:  #line 56 "grammar/ClassFile.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]->getValue(); $yyVal= $yyVals[-2+$yyTop]; } break;

    case 8:  #line 57 "grammar/ClassFile.jay"
    { $yyVal= array($yyVals[0+$yyTop]->getValue()); } break;

    case 9:  #line 61 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-1+$yyTop]->getValue(); } break;

    case 10:  #line 62 "grammar/ClassFile.jay"
    { $yyVal= ''; } break;

    case 11:  #line 66 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-1+$yyTop];} break;

    case 12:  #line 67 "grammar/ClassFile.jay"
    { $yyVal= array(); } break;

    case 13:  #line 70 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 14:  #line 71 "grammar/ClassFile.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 15:  #line 74 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-3+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 16:  #line 75 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-2+$yyTop]->getValue(), 1)); } break;

    case 17:  #line 76 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 18:  #line 79 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-2+$yyTop]; list($k, $v)= each($yyVals[0+$yyTop]); $yyVal[$k]= $v; } break;

    case 19:  #line 80 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 20:  #line 83 "grammar/ClassFile.jay"
    { $yyVal= array($yyVals[-2+$yyTop]->getValue() => $this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 21:  #line 84 "grammar/ClassFile.jay"
    { $yyVal= array($this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 22:  #line 88 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-2+$yyTop]); $yyVal->setPackage($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 23:  #line 89 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-1+$yyTop]); $yyVal->setPackage($yyVals[0+$yyTop]); } break;

    case 24:  #line 90 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 25:  #line 91 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setPackage($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 26:  #line 92 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setHeader($yyVals[0+$yyTop]); } break;

    case 27:  #line 93 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setPackage($yyVals[0+$yyTop]); } break;

    case 28:  #line 94 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·ClassFile(); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 29:  #line 98 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Package($this->unquote($yyVals[-1+$yyTop]->getValue())); } break;

    case 30:  #line 102 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Uses(); $yyVal->setClassnames($yyVals[-2+$yyTop]); } break;

    case 31:  #line 105 "grammar/ClassFile.jay"
    { $yyVals[-2+$yyTop][]= $this->unquote($yyVals[0+$yyTop]->getValue()); $yyVal= $yyVals[-2+$yyTop]; } break;

    case 32:  #line 106 "grammar/ClassFile.jay"
    { $yyVal= array($this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 33:  #line 110 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·BlockComment(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 34:  #line 114 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-2+$yyTop]->getValue()); $yyVal->setDirectives($yyVals[-1+$yyTop]); } break;

    case 35:  #line 115 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 36:  #line 119 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue()); } break;

    case 37:  #line 120 "grammar/ClassFile.jay"
    { $yyVal= array(new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue())); } break;
#line 464 "-"
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
