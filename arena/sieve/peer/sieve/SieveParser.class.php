<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses('text.parser.generic.AbstractParser');

#line 2 "grammar/sieve.jay"
  uses(
    'peer.sieve.RuleSet',
    'peer.sieve.Rule',
    'peer.sieve.ActionFactory',
    'peer.sieve.AllOfCondition',
    'peer.sieve.NegationOfCondition',
    'peer.sieve.AnyOfCondition',
    'peer.sieve.HeaderCondition',
    'peer.sieve.SizeCondition',
    'peer.sieve.AddressCondition',
    'peer.sieve.BooleanCondition'
  );
#line 22 "-"
  define('TOKEN_T_WORD',  260);
  define('TOKEN_T_STRING',  261);
  define('TOKEN_T_NUMBER',  263);
  define('TOKEN_T_REQUIRE',  270);
  define('TOKEN_T_IF',  280);
  define('TOKEN_T_ELSEIF',  281);
  define('TOKEN_T_ALLOF',  290);
  define('TOKEN_T_ANYOF',  291);
  define('TOKEN_T_NOT',  292);
  define('TOKEN_T_HEADER',  300);
  define('TOKEN_T_SIZE',  301);
  define('TOKEN_T_ADDRESS',  302);
  define('TOKEN_T_TRUE',  303);
  define('TOKEN_T_FALSE',  304);
  define('TOKEN_T_COMPARATOR',  305);
  define('TOKEN_YY_ERRORCODE', 256);

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class SieveParser extends AbstractParser {
    protected static $yyLhs= array(-1,
          0,     1,     1,     3,     3,     4,     2,     2,     6,     6, 
          9,     7,     7,    11,    11,    10,    10,    14,    12,    16, 
          8,    18,     8,    19,     8,    21,     8,    23,     8,    24, 
          8,     8,     8,    13,    13,    20,    20,    25,    25,    25, 
         17,    17,    15,    15,    22,    22,    26,    26,    26,     5, 
          5, 
    );
    protected static $yyLen= array(2,
          2,     0,     1,     1,     2,     5,     0,     1,     1,     2, 
          0,     7,     1,     0,     6,     1,     2,     0,     5,     0, 
          5,     0,     5,     0,     3,     0,     4,     0,     5,     0, 
          4,     1,     1,     0,     1,     1,     2,     3,     3,     3, 
          1,     3,     0,     1,     1,     2,     1,     1,     3,     1, 
          3, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     3,     0,     0,    18,    11,     1,     8, 
          0,    13,     0,     5,     0,     0,     0,     0,    10,    17, 
          0,     0,     0,     0,    35,     0,    20,    22,    24,    26, 
          0,    30,    32,    33,     0,    51,     6,     0,     0,    47, 
         48,     0,     0,    44,     0,    37,     0,     0,     0,     0, 
          0,     0,     0,    38,    39,    40,     0,    19,    46,     0, 
          0,    25,     0,    28,     0,     0,    49,     0,     0,     0, 
         27,     0,    31,     0,     0,    21,    23,    29,     0,    12, 
         42,     0,     0,     0,     0,    15, 
    );
    protected static $yyDgoto= array(2,
          3,     9,     4,     5,    16,    10,    11,    68,    18,    12, 
         80,    13,    24,    17,    43,    47,    69,    48,    49,    25, 
         50,    44,    72,    52,    26,    45, 
    );
    protected static $yySindex = array(         -255,
        -74,     0,  -241,     0,  -255,  -243,     0,     0,     0,     0, 
       -241,     0,  -239,     0,   -24,   -71,   -35,  -240,     0,     0, 
       -243,   -31,  -248,   -84,     0,   -35,     0,     0,     0,     0, 
        -34,     0,     0,     0,   -94,     0,     0,   -58,  -231,     0, 
          0,  -243,   -28,     0,   -84,     0,    -6,     6,  -240,   -35, 
       -228,   -35,  -239,     0,     0,     0,   -57,     0,     0,  -240, 
       -240,     0,   -84,     0,   -84,   -81,     0,     9,     7,    13, 
          0,  -216,     0,  -226,  -240,     0,     0,     0,  -240,     0, 
          0,   -67,  -239,   -66,  -226,     0, 
    );
    protected static $yyRindex= array(            1,
          0,     0,    58,     0,     2,     0,     0,     0,     0,     0, 
         65,     0,     3,     0,   -27,     0,   -54,     0,     0,     0, 
          0,     0,     0,     8,     0,   -53,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,   -33,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    27,     0,     0, 
          0,     0,     0,     4,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     4,     0, 
    );
    protected static $yyGindex= array(0,
          0,     0,    64,     0,    -7,    59,     0,    -8,     0,    -4, 
        -13,     0,     0,     0,     0,     0,   -48,     0,     0,   -10, 
          0,   -20,     0,     0,    35,    36, 
    );
    protected static $yyTable = array(23,
          2,     4,    16,    14,    34,    36,    42,    45,    20,    35, 
         45,    38,    70,    36,     1,    46,     6,    15,     7,    21, 
          7,    22,    23,    51,    59,    45,    81,    37,    53,    56, 
         58,    64,    42,    60,    57,    67,    34,    36,     8,    63, 
         62,    65,    71,    74,    73,    61,    78,    76,    66,    27, 
         28,    29,    75,    77,    79,    83,    39,     7,    85,    30, 
         31,    32,    33,    34,     9,    50,    43,    41,    14,    19, 
         82,    86,    54,    55,     0,     0,     0,     0,    84,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    45, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    16,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,    40,     0,    41,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    40,     0,    41,     0,    34,    36,    34,    36, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          2,     4,     0,    14,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          2,     4,    16,    14, 
    );
    protected static $yyCheck = array(58,
          0,     0,     0,     0,    59,    59,    91,    41,    13,    18, 
         44,   260,    61,    21,   270,    26,    91,   261,   260,    44, 
        260,    93,    58,    58,    45,    59,    75,    59,   123,   261, 
         59,   260,    91,    40,    42,    93,    91,    91,   280,    50, 
         49,    52,    63,   125,    65,    40,   263,    41,    53,   290, 
        291,   292,    44,    41,   281,   123,   305,     0,   125,   300, 
        301,   302,   303,   304,     0,    93,    59,    41,     5,    11, 
         79,    85,    38,    38,    -1,    -1,    -1,    -1,    83,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   123, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,   125,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,   261,    -1,   263,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,   261,    -1,   263,    -1,   261,   261,   263,   263, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
        260,   260,    -1,   260,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
        280,   280,   280,   280, 
    );
    protected static $yyFinal= 2;
    protected static $yyName= array(    
      'end-of-file', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      "'('", "')'", NULL, NULL, "','", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, "':'", "';'", NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, "'['", NULL, 
      "']'", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, "'{'", NULL, "'}'", NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, 'T_WORD', 'T_STRING', NULL, 'T_NUMBER', NULL, NULL, NULL, NULL, NULL, 
      NULL, 'T_REQUIRE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_IF', 
      'T_ELSEIF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_ALLOF', 
      'T_ANYOF', 'T_NOT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_HEADER', 
      'T_SIZE', 'T_ADDRESS', 'T_TRUE', 'T_FALSE', 'T_COMPARATOR', 
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

    case 1:  #line 39 "grammar/sieve.jay"
    {
      $yyVal= new peer新ieve愛uleSet();
      $yyVal->required= $yyVals[-1+$yyTop];
      $yyVal->rules= $yyVals[0+$yyTop];
    } break;

    case 2:  #line 48 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 4:  #line 53 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 5:  #line 54 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 6:  #line 58 "grammar/sieve.jay"
    { $yyVal= $yyVals[-2+$yyTop]; } break;

    case 7:  #line 64 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 9:  #line 69 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 10:  #line 70 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 11:  #line 74 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new peer新ieve愛ule()); } break;

    case 12:  #line 74 "grammar/sieve.jay"
    {
      $yyVals[-6+$yyTop]->condition= $yyVals[-4+$yyTop];
      $yyVals[-6+$yyTop]->actions= $yyVals[-2+$yyTop];
    } break;

    case 13:  #line 78 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new peer新ieve愛ule());
      $yyVal->condition= NULL;
      $yyVal->actions= $yyVals[0+$yyTop];
    } break;

    case 14:  #line 87 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 16:  #line 93 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 17:  #line 94 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 18:  #line 98 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(ActionFactory::newAction($yyVals[0+$yyTop])); } break;

    case 19:  #line 98 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->tags= $yyVals[-2+$yyTop];
      $yyVals[-4+$yyTop]->arguments= $yyVals[-1+$yyTop];
    } break;

    case 20:  #line 107 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AllOfCondition()); } break;

    case 21:  #line 107 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->expressions= $yyVals[-1+$yyTop];
    } break;

    case 22:  #line 110 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AnyOfCondition()); } break;

    case 23:  #line 110 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->expressions= $yyVals[-1+$yyTop];
    } break;

    case 24:  #line 113 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new NegationOfCondition()); } break;

    case 25:  #line 113 "grammar/sieve.jay"
    {
      $yyVals[-2+$yyTop]->condition= $yyVals[-1+$yyTop];
    } break;

    case 26:  #line 116 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new HeaderCondition()); } break;

    case 27:  #line 116 "grammar/sieve.jay"
    { 
      $yyVals[-3+$yyTop]->tags= $yyVals[-1+$yyTop];
      $yyVals[-3+$yyTop]->arguments= $yyVals[0+$yyTop];
    } break;

    case 28:  #line 120 "grammar/sieve.jay"
    { 
      try { 
        $yyVals[-2+$yyTop]= $yyLex->create(SizeCondition::forName($yyVals[0+$yyTop])); 
      } catch (IllegalArgumentException $e) { 
        $this->error(E_ERROR, $e->getMessage().' at '.$yyLex->fileName.', line '.$yyLex->position[0]); 
      }
    } break;

    case 29:  #line 126 "grammar/sieve.jay"
    {
      $yyVal->value= $yyVals[-1+$yyTop];
    } break;

    case 30:  #line 129 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AddressCondition()); } break;

    case 31:  #line 129 "grammar/sieve.jay"
    {
      $yyVals[-3+$yyTop]->tags= $yyVals[-1+$yyTop];
      $yyVals[-3+$yyTop]->arguments= $yyVals[0+$yyTop];
    } break;

    case 32:  #line 133 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new BooleanCondition(TRUE));
    } break;

    case 33:  #line 136 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new BooleanCondition(FALSE));
    } break;

    case 34:  #line 142 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 36:  #line 147 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 37:  #line 148 "grammar/sieve.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 38:  #line 152 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop] => NULL), $yyVals[0+$yyTop]); } break;

    case 39:  #line 153 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 40:  #line 154 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 41:  #line 158 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 42:  #line 159 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 43:  #line 163 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 45:  #line 168 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 46:  #line 169 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 49:  #line 175 "grammar/sieve.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 50:  #line 183 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 51:  #line 184 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;
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
