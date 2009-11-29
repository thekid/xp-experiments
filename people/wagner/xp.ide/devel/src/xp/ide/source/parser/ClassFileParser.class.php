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
    'xp.ide.source.element.Define',
    'xp.ide.source.element.Interfacedef',
    'xp.ide.source.element.ClassFile',
    'xp.ide.source.element.BlockComment',
    'xp.ide.source.element.Annotation',
    'xp.ide.source.element.Apidoc',
    'xp.ide.source.element.ApidocDirective'
  );

#line 25 "-"

  uses('xp.ide.source.parser.Parser');

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class xp·ide·source·parser·ClassFileParser extends xp·ide·source·parser·Parser {
    const T_CLASS= 257;
    const T_INTERFACE= 258;
    const T_CLOSE_BCOMMENT= 259;
    const T_CLOSE_TAG= 260;
    const T_CONTENT_BCOMMENT= 261;
    const T_ENCAPSED_STRING= 262;
    const T_EXTENDS= 263;
    const T_IMPLEMENTS= 264;
    const T_OPEN_BCOMMENT= 265;
    const T_OPEN_TAG= 266;
    const T_USES= 267;
    const T_CONTENT_INNERBLOCK= 268;
    const T_VARIABLE= 269;
    const T_STRING= 270;
    const T_OPEN_APIDOC= 271;
    const T_CONTENT_APIDOC= 272;
    const T_CLOSE_APIDOC= 273;
    const T_DIRECTIVE_APIDOC= 274;
    const T_START_ANNOTATION= 275;
    const T_CLOSE_ANNOTATION= 276;
    const T_ANNOTATION= 277;
    const T_FINAL= 278;
    const T_ABSTRACT= 279;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     0,     0,     2,     2,     4,     4,     6,     6,     3, 
          3,     8,     8,    10,    10,     9,     9,    11,    11,    12, 
         12,     7,     7,    13,    13,    14,    14,    14,    15,    15, 
         16,    16,     1,     1,     1,     1,     1,     1,     1,    18, 
         19,    20,    20,    17,     5,     5,    21,    21, 
    );
    protected static $yyLen= array(2,
          0,     4,     3,     1,     1,     6,     8,     3,     1,     4, 
          3,     2,     1,     1,     1,     7,     5,     3,     1,     3, 
          2,     3,     0,     3,     1,     4,     3,     1,     3,     1, 
          3,     1,     3,     2,     2,     2,     1,     1,     1,     4, 
          5,     3,     1,     3,     4,     3,     2,     1, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     0,     0,     0,     0,     0,     4,     5, 
          0,     0,     0,    39,     0,     0,     0,     0,     0,     3, 
          0,     0,     0,     0,    35,    36,    44,    43,     0,     0, 
         46,    48,     0,     2,     0,     0,     0,    25,     0,    15, 
         14,     0,    11,    13,    33,     0,     0,    40,    45,    47, 
          0,     0,     0,    22,     0,     0,    10,    12,    42,    41, 
          9,     0,     0,    32,     0,    27,     0,    30,    24,     0, 
          0,     0,     6,     0,     0,    26,     0,     0,     8,    31, 
         29,     0,     0,    17,     7,    19,     0,     0,    21,     0, 
         16,    20,    18, 
    );
    protected static $yyDgoto= array(2,
          7,     8,     9,    10,    11,    62,    23,    42,    43,    44, 
         87,    84,    37,    38,    67,    68,    12,    13,    14,    29, 
         33, 
    );
    protected static $yySindex = array(         -256,
       -233,     0,  -244,   -18,   -37,  -243,  -238,  -225,     0,     0, 
       -247,  -246,  -230,     0,  -216,  -218,  -217,  -234,  -214,     0, 
       -223,  -229,  -252,  -230,     0,     0,     0,     0,   -26,   -10, 
          0,     0,  -232,     0,  -116,    10,   -44,     0,  -219,     0, 
          0,  -252,     0,     0,     0,  -210,    -6,     0,     0,     0, 
       -215,  -212,   -39,     0,  -229,  -209,     0,     0,     0,     0, 
          0,   -38,   -68,     0,    -3,     0,   -25,     0,     0,  -211, 
       -208,  -207,     0,  -201,  -250,     0,  -119,   -63,     0,     0, 
          0,  -206,  -122,     0,     0,     0,   -36,   -60,     0,  -204, 
          0,     0,     0, 
    );
    protected static $yyRindex= array(           67,
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
       -248,  -203,  -202,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,  -200,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,   -43,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,    63,     0,     0,     0,     0,     0,     0,    30,    31, 
          0,   -13,     0,    20,     0,     2,     0,    64,     1,     0, 
          0, 
    );
    protected static $yyTable = array(55,
         28,    66,    89,    83,    39,    72,    52,    90,    23,     1, 
         21,    64,    25,    26,    47,    76,    15,    46,    75,    65, 
          4,    16,     5,    17,    45,    40,    41,    22,    18,    23, 
         23,     3,     6,     4,    20,     5,     4,     6,    31,    32, 
         49,    50,    27,    28,    30,    34,    35,    36,    48,    53, 
         56,    59,    60,    70,    61,    63,    73,    74,    77,    78, 
         80,    85,    79,    86,    92,    93,     1,    37,    38,    19, 
         34,    57,    58,    91,    69,    24,    81,     0,     0,     0, 
          0,     0,     0,     0,    71,     0,    83,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,    82,    88,    51,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    64,     0,     0,     0,     0,     0,     0,     0, 
         65,    54,    28, 
    );
    protected static $yyCheck = array(44,
         44,    41,   125,   123,   257,    44,   123,    44,   257,   266, 
        258,   262,    12,    13,    41,    41,   261,    44,    44,   270, 
        267,    40,   269,    61,    24,   278,   279,   275,   272,   278, 
        279,   265,   271,   267,   260,   269,   267,   271,   273,   274, 
        273,   274,   259,   262,   262,   260,   270,   277,    59,    40, 
        270,   262,    59,   263,   270,   268,   125,    61,   270,   268, 
        262,   125,   270,   270,   125,   270,     0,   271,   271,     7, 
        271,    42,    42,    87,    55,    12,    75,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,   123,    -1,   123,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,   264,   268,   263,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,   262,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
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
      'T_INTERFACE', 'T_CLOSE_BCOMMENT', 'T_CLOSE_TAG', 'T_CONTENT_BCOMMENT', 
      'T_ENCAPSED_STRING', 'T_EXTENDS', 'T_IMPLEMENTS', 'T_OPEN_BCOMMENT', 
      'T_OPEN_TAG', 'T_USES', 'T_CONTENT_INNERBLOCK', 'T_VARIABLE', 'T_STRING', 
      'T_OPEN_APIDOC', 'T_CONTENT_APIDOC', 'T_CLOSE_APIDOC', 
      'T_DIRECTIVE_APIDOC', 'T_START_ANNOTATION', 'T_CLOSE_ANNOTATION', 
      'T_ANNOTATION', 'T_FINAL', 'T_ABSTRACT', 
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

    case 2:  #line 29 "grammar/ClassFile.jay"
    { $yyVal= $this->top_element; $yyVal->setClassdef($yyVals[-1+$yyTop]); } break;

    case 3:  #line 30 "grammar/ClassFile.jay"
    { $yyVal= $this->top_element; $yyVal->setClassdef($yyVals[-1+$yyTop]); } break;

    case 4:  #line 34 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 5:  #line 35 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 6:  #line 39 "grammar/ClassFile.jay"
    {
    $yyVal= new xp·ide·source·element·Interfacedef($yyVals[-3+$yyTop]->getValue());
    $yyVal->setContent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 7:  #line 43 "grammar/ClassFile.jay"
    {
    $yyVal= new xp·ide·source·element·Interfacedef($yyVals[-5+$yyTop]->getValue(), $yyVals[-3+$yyTop]);
    $yyVal->setContent($yyVals[-1+$yyTop]->getValue());
  } break;

    case 8:  #line 50 "grammar/ClassFile.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]->getValue(); $yyVal= $yyVals[-2+$yyTop]; } break;

    case 9:  #line 51 "grammar/ClassFile.jay"
    { $yyVal= array($yyVals[0+$yyTop]->getValue()); } break;

    case 10:  #line 55 "grammar/ClassFile.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-3+$yyTop]);
    $yyVal->setAnnotations($yyVals[-2+$yyTop]);
    if (isset($yyVals[-1+$yyTop]['abstract'])) $yyVal->setAbstract($yyVals[-1+$yyTop]['abstract']);
    if (isset($yyVals[-1+$yyTop]['final']))    $yyVal->setFinal($yyVals[-1+$yyTop]['final']);
  } break;

    case 11:  #line 62 "grammar/ClassFile.jay"
    {
    $yyVal= $yyVals[0+$yyTop];
    $yyVal->setApidoc($yyVals[-2+$yyTop]);
    $yyVal->setAnnotations($yyVals[-1+$yyTop]);
  } break;

    case 12:  #line 70 "grammar/ClassFile.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 13:  #line 71 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 14:  #line 74 "grammar/ClassFile.jay"
    { $yyVal= array('abstract' => TRUE); } break;

    case 15:  #line 75 "grammar/ClassFile.jay"
    { $yyVal= array('final' => TRUE); } break;

    case 16:  #line 79 "grammar/ClassFile.jay"
    {
    $yyVal= new xp·ide·source·element·Classdef($yyVals[-5+$yyTop]->getValue(), $yyVals[-3+$yyTop]->getValue());
    $yyVal->setInterfaces($yyVals[-1+$yyTop]);
    $yyVal->setContent($yyVals[0+$yyTop]);
  } break;

    case 17:  #line 84 "grammar/ClassFile.jay"
    {
    $yyVal= new xp·ide·source·element·Classdef($yyVals[-3+$yyTop]->getValue(), $yyVals[-1+$yyTop]->getValue());
    $yyVal->setContent($yyVals[0+$yyTop]);
  } break;

    case 18:  #line 91 "grammar/ClassFile.jay"
    { $yyVals[-2+$yyTop][]= $yyVals[0+$yyTop]->getValue(); $yyVal= $yyVals[-2+$yyTop]; } break;

    case 19:  #line 92 "grammar/ClassFile.jay"
    { $yyVal= array($yyVals[0+$yyTop]->getValue()); } break;

    case 20:  #line 96 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-1+$yyTop]->getValue(); } break;

    case 21:  #line 97 "grammar/ClassFile.jay"
    { $yyVal= ''; } break;

    case 22:  #line 101 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-1+$yyTop];} break;

    case 23:  #line 102 "grammar/ClassFile.jay"
    { $yyVal= array(); } break;

    case 24:  #line 105 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-2+$yyTop]; $yyVal[]= $yyVals[0+$yyTop]; } break;

    case 25:  #line 106 "grammar/ClassFile.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 26:  #line 109 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-3+$yyTop]->getValue(), 1), $yyVals[-1+$yyTop]); } break;

    case 27:  #line 110 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[-2+$yyTop]->getValue(), 1)); } break;

    case 28:  #line 111 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Annotation(substr($yyVals[0+$yyTop]->getValue(), 1)); } break;

    case 29:  #line 114 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-2+$yyTop]; list($k, $v)= each($yyVals[0+$yyTop]); $yyVal[$k]= $v; } break;

    case 30:  #line 115 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 31:  #line 118 "grammar/ClassFile.jay"
    { $yyVal= array($yyVals[-2+$yyTop]->getValue() => $this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 32:  #line 119 "grammar/ClassFile.jay"
    { $yyVal= array($this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 33:  #line 123 "grammar/ClassFile.jay"
    { $yyVal= $this->top_element; $yyVal->setHeader($yyVals[-2+$yyTop]); $yyVal->setPackage($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 34:  #line 124 "grammar/ClassFile.jay"
    { $yyVal= $this->top_element; $yyVal->setHeader($yyVals[-1+$yyTop]); $yyVal->setPackage($yyVals[0+$yyTop]); } break;

    case 35:  #line 125 "grammar/ClassFile.jay"
    { $yyVal= $this->top_element; $yyVal->setHeader($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 36:  #line 126 "grammar/ClassFile.jay"
    { $yyVal= $this->top_element; $yyVal->setPackage($yyVals[-1+$yyTop]); $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 37:  #line 127 "grammar/ClassFile.jay"
    { $yyVal= $this->top_element; $yyVal->setHeader($yyVals[0+$yyTop]); } break;

    case 38:  #line 128 "grammar/ClassFile.jay"
    { $yyVal= $this->top_element; $yyVal->setPackage($yyVals[0+$yyTop]); } break;

    case 39:  #line 129 "grammar/ClassFile.jay"
    { $yyVal= $this->top_element; $yyVal->setUses($yyVals[0+$yyTop]); } break;

    case 40:  #line 133 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Package($this->unquote($yyVals[-1+$yyTop]->getValue())); } break;

    case 41:  #line 137 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Uses(); $yyVal->setClassnames($yyVals[-2+$yyTop]); } break;

    case 42:  #line 140 "grammar/ClassFile.jay"
    { $yyVals[-2+$yyTop][]= $this->unquote($yyVals[0+$yyTop]->getValue()); $yyVal= $yyVals[-2+$yyTop]; } break;

    case 43:  #line 141 "grammar/ClassFile.jay"
    { $yyVal= array($this->unquote($yyVals[0+$yyTop]->getValue())); } break;

    case 44:  #line 145 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·BlockComment(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 45:  #line 149 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-2+$yyTop]->getValue()); $yyVal->setDirectives($yyVals[-1+$yyTop]); } break;

    case 46:  #line 150 "grammar/ClassFile.jay"
    { $yyVal= new xp·ide·source·element·Apidoc(); $yyVal->setText($yyVals[-1+$yyTop]->getValue()); } break;

    case 47:  #line 154 "grammar/ClassFile.jay"
    { $yyVal= $yyVals[-1+$yyTop]; $yyVal[]= new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue()); } break;

    case 48:  #line 155 "grammar/ClassFile.jay"
    { $yyVal= array(new xp·ide·source·element·ApidocDirective($yyVals[0+$yyTop]->getValue())); } break;
#line 516 "-"
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
