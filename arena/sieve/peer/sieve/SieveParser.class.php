<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses('text.parser.generic.AbstractParser');

#line 2 "grammar/sieve.jay"
  uses(
    'peer.sieve.SyntaxTree',
    'peer.sieve.RuleSet',
    'peer.sieve.Rule',
    'peer.sieve.ActionFactory',
    'peer.sieve.AllOfCondition',
    'peer.sieve.NegationOfCondition',
    'peer.sieve.AnyOfCondition',
    'peer.sieve.HeaderCondition',
    'peer.sieve.ExistsCondition',
    'peer.sieve.SizeCondition',
    'peer.sieve.AddressCondition',
    'peer.sieve.EnvelopeCondition',
    'peer.sieve.BooleanCondition'
  );
#line 25 "-"
  define('TOKEN_T_WORD',  260);
  define('TOKEN_T_STRING',  261);
  define('TOKEN_T_NUMBER',  263);
  define('TOKEN_T_REQUIRE',  270);
  define('TOKEN_T_IF',  280);
  define('TOKEN_T_ELSE',  281);
  define('TOKEN_T_ELSEIF',  282);
  define('TOKEN_T_ALLOF',  290);
  define('TOKEN_T_ANYOF',  291);
  define('TOKEN_T_NOT',  292);
  define('TOKEN_T_HEADER',  300);
  define('TOKEN_T_SIZE',  301);
  define('TOKEN_T_ADDRESS',  302);
  define('TOKEN_T_TRUE',  303);
  define('TOKEN_T_FALSE',  304);
  define('TOKEN_T_COMPARATOR',  305);
  define('TOKEN_T_ENVELOPE',  306);
  define('TOKEN_T_EXISTS',  307);
  define('TOKEN_T_IS',  400);
  define('TOKEN_T_CONTAINS',  401);
  define('TOKEN_T_MATCHES',  402);
  define('TOKEN_T_ALL',  500);
  define('TOKEN_T_DOMAIN',  501);
  define('TOKEN_T_LOCALPART',  502);
  define('TOKEN_YY_ERRORCODE', 256);

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class SieveParser extends AbstractParser {
    protected static $yyLhs= array(-1,
          0,     1,     1,     3,     3,     4,     4,     2,     2,     6, 
          6,     9,     7,     7,    11,    11,    11,    10,    10,    14, 
         12,    16,     8,    18,     8,    19,     8,    20,     8,    22, 
          8,    23,     8,    24,     8,    25,     8,     8,     8,    13, 
         13,    26,    26,    27,    27,    27,    27,    17,    17,    15, 
         15,    30,    30,    21,    21,    21,    29,    29,    29,    28, 
         28,    28,     5,     5, 
    );
    protected static $yyLen= array(2,
          2,     0,     1,     1,     2,     3,     5,     0,     1,     1, 
          2,     0,     7,     1,     0,     4,     6,     1,     2,     0, 
          5,     0,     5,     0,     5,     0,     3,     0,     5,     0, 
          3,     0,     5,     0,     5,     0,     5,     1,     1,     0, 
          1,     1,     2,     2,     2,     3,     3,     1,     3,     0, 
          1,     1,     2,     1,     1,     3,     1,     1,     1,     1, 
          1,     1,     1,     3, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     3,     0,     0,     0,    20,    12,     1, 
          9,     0,    14,     0,     5,     6,     0,     0,     0,     0, 
         11,    19,     0,     0,     0,     0,    41,     0,    22,    24, 
         26,    28,     0,    36,    38,    39,    34,    30,     0,    64, 
          7,     0,     0,    60,    61,    62,    57,    58,    59,    44, 
         45,    54,    55,     0,     0,     0,    51,    43,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    46,    47,     0, 
         21,    53,     0,     0,    27,     0,    32,     0,     0,    31, 
          0,    56,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    23,    25,    29,    33,    37,    35,     0,     0,    13, 
         49,     0,     0,     0,     0,    16,     0,     0,    17, 
    );
    protected static $yyDgoto= array(2,
          3,    10,     4,     5,    18,    11,    12,    83,    20,    13, 
        100,    14,    26,    19,    55,    59,    84,    60,    61,    62, 
         56,    66,    87,    65,    64,    27,    28,    50,    51,    57, 
    );
    protected static $yySindex = array(         -253,
        -80,     0,  -247,     0,  -253,   -34,  -235,     0,     0,     0, 
          0,  -247,     0,  -233,     0,     0,    -4,   -51,   -17,  -272, 
          0,     0,  -235,   -16,  -260,   -84,     0,   -17,     0,     0, 
          0,     0,   -14,     0,     0,     0,     0,     0,   -73,     0, 
          0,   -84,  -209,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,  -235,    -6,   -84,     0,     0,    14,    15, 
       -272,   -17,  -203,   -17,   -17,   -84,  -233,     0,     0,   -33, 
          0,     0,  -272,  -272,     0,   -84,     0,   -84,   -84,     0, 
        -64,     0,    19,    23,    24,   -84,  -197,   -84,   -84,  -267, 
       -272,     0,     0,     0,     0,     0,     0,   -56,  -272,     0, 
          0,  -233,   -55,   -50,  -233,     0,   -49,  -267,     0, 
    );
    protected static $yyRindex= array(            1,
          0,     0,    69,     0,     2,     0,     0,     0,     0,     0, 
          0,    70,     0,     3,     0,     0,   -22,     0,   -54,     0, 
          0,     0,     0,     0,     0,    13,     0,   -53,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,    18,     0,     0,     0,     0, 
          0,   -83,     0,   -83,   -83,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,    32,     0,     0,     0,     0,     0,     0,     4, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     4,     0, 
    );
    protected static $yyGindex= array(0,
          0,     0,    73,     0,    -7,    62,     0,   -10,     0,    -5, 
        -29,     0,   -41,     0,     0,     0,   -52,     0,     0,     0, 
        -30,     0,     0,     0,     0,    52,     0,     0,     0,    25, 
    );
    protected static $yyTable = array(42,
          2,     4,    18,    15,    40,    42,    54,    40,    22,    39, 
          7,    68,     8,    98,    99,    40,     1,    29,    30,    31, 
         76,    85,    78,    79,    16,    17,     8,    32,    33,    34, 
         35,    36,     9,    37,    38,    80,    40,    42,   101,    23, 
         25,    24,    41,    63,    43,    86,    70,    88,    89,    67, 
         75,    69,    71,    73,    74,    94,    77,    96,    97,    82, 
         90,    81,    91,    92,    93,    95,   102,   105,     8,    10, 
         63,    50,    48,    21,   106,   108,    52,    15,   109,    58, 
         72,     0,     0,     0,     0,     0,     0,     0,   103,     0, 
          0,     0,     0,     0,     0,     0,   104,     0,     0,   107, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    18,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    44, 
         45,    46,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,    52,    40,    53,    40, 
          6,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,    40,    42,    40,    42, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    47, 
         48,    49,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          2,     4,     0,    15,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          2,     4,    18,    15, 
    );
    protected static $yyCheck = array(260,
          0,     0,     0,     0,    59,    59,    91,    91,    14,    20, 
         91,    42,   260,   281,   282,    23,   270,   290,   291,   292, 
         62,    74,    64,    65,    59,   261,   260,   300,   301,   302, 
        303,   304,   280,   306,   307,    66,    91,    91,    91,    44, 
         58,    93,    59,    58,   305,    76,    54,    78,    79,   123, 
         61,   261,    59,    40,    40,    86,   260,    88,    89,    93, 
        125,    67,    44,    41,    41,   263,   123,   123,     0,     0, 
         93,    59,    41,    12,   125,   125,    59,     5,   108,    28, 
         56,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    99,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,   102,    -1,    -1,   105, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,   125,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   400, 
        401,   402,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,   261,   261,   263,   263, 
        261,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,   261,   261,   263,   263, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   500, 
        501,   502,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
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
      'T_ELSE', 'T_ELSEIF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_ALLOF', 
      'T_ANYOF', 'T_NOT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_HEADER', 
      'T_SIZE', 'T_ADDRESS', 'T_TRUE', 'T_FALSE', 'T_COMPARATOR', 'T_ENVELOPE', 
      'T_EXISTS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_IS', 
      'T_CONTAINS', 'T_MATCHES', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, 'T_ALL', 'T_DOMAIN', 'T_LOCALPART', 
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

    case 1:  #line 54 "grammar/sieve.jay"
    {
      $yyVal= new peer新ieve惹yntaxTree();
      $yyVal->required= $yyVals[-1+$yyTop];
      $yyVal->ruleset= new peer新ieve愛uleSet();
      $yyVal->ruleset->rules= $yyVals[0+$yyTop];
    } break;

    case 2:  #line 64 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 4:  #line 69 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 5:  #line 70 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 6:  #line 74 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop]); } break;

    case 7:  #line 75 "grammar/sieve.jay"
    { $yyVal= $yyVals[-2+$yyTop]; } break;

    case 8:  #line 81 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 10:  #line 86 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 11:  #line 87 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 12:  #line 91 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new peer新ieve愛ule()); } break;

    case 13:  #line 91 "grammar/sieve.jay"
    {
      $yyVals[-6+$yyTop]->condition= $yyVals[-4+$yyTop];
      $yyVals[-6+$yyTop]->actions= $yyVals[-2+$yyTop];
    } break;

    case 14:  #line 95 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new peer新ieve愛ule());
      $yyVal->condition= NULL;
      $yyVal->actions= $yyVals[0+$yyTop];
    } break;

    case 15:  #line 104 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 18:  #line 111 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 19:  #line 112 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 20:  #line 116 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(ActionFactory::newAction($yyVals[0+$yyTop])); } break;

    case 21:  #line 116 "grammar/sieve.jay"
    {
      try {
        $yyVals[-4+$yyTop]->pass($yyVals[-2+$yyTop], $yyVals[-1+$yyTop]);
      } catch (IllegalArgumentException $e) { 
        $this->error(E_ERROR, $e->getMessage().' at '.$yyLex->fileName.', line '.$yyLex->position[0]); 
        $yyVals[-4+$yyTop]= NULL;
      }
    } break;

    case 22:  #line 129 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AllOfCondition()); } break;

    case 23:  #line 129 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->conditions= $yyVals[-1+$yyTop];
    } break;

    case 24:  #line 133 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AnyOfCondition()); } break;

    case 25:  #line 133 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->conditions= $yyVals[-1+$yyTop];
    } break;

    case 26:  #line 137 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new NegationOfCondition()); } break;

    case 27:  #line 137 "grammar/sieve.jay"
    {
      $yyVals[-2+$yyTop]->negated= $yyVals[-1+$yyTop];
    } break;

    case 28:  #line 141 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new HeaderCondition()); } break;

    case 29:  #line 141 "grammar/sieve.jay"
    { 
      isset($yyVals[-2+$yyTop]['comparator']) && $yyVals[-4+$yyTop]->comparator= $yyVals[-2+$yyTop]['comparator'];
      isset($yyVals[-2+$yyTop]['matchtype']) && $yyVals[-4+$yyTop]->matchtype= $yyVals[-2+$yyTop]['matchtype'];
      $yyVals[-4+$yyTop]->names= (array)$yyVals[-1+$yyTop];
      $yyVals[-4+$yyTop]->keys= (array)$yyVals[0+$yyTop];
    } break;

    case 30:  #line 148 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new ExistsCondition()); } break;

    case 31:  #line 148 "grammar/sieve.jay"
    {
      $yyVals[-2+$yyTop]->names= (array)$yyVals[0+$yyTop];
    } break;

    case 32:  #line 152 "grammar/sieve.jay"
    { 
      try { 
        $yyVals[-2+$yyTop]= $yyLex->create(SizeCondition::forName($yyVals[0+$yyTop])); 
      } catch (IllegalArgumentException $e) { 
        $this->error(E_ERROR, $e->getMessage().' at '.$yyLex->fileName.', line '.$yyLex->position[0]); 
        $yyVals[-2+$yyTop]= NULL;
      }
    } break;

    case 33:  #line 159 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop] && $yyVals[-4+$yyTop]->value= intval($yyVals[0+$yyTop]);
    } break;

    case 34:  #line 163 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new EnvelopeCondition()); } break;

    case 35:  #line 163 "grammar/sieve.jay"
    {
      isset($yyVals[-2+$yyTop]['addresspart']) && $yyVals[-4+$yyTop]->addresspart= $yyVals[-2+$yyTop]['addresspart'];
      isset($yyVals[-2+$yyTop]['comparator']) && $yyVals[-4+$yyTop]->comparator= $yyVals[-2+$yyTop]['comparator'];
      isset($yyVals[-2+$yyTop]['matchtype']) && $yyVals[-4+$yyTop]->matchtype= $yyVals[-2+$yyTop]['matchtype'];
      $yyVals[-4+$yyTop]->headers= (array)$yyVals[-1+$yyTop];
      $yyVals[-4+$yyTop]->keys= (array)$yyVals[0+$yyTop];
    } break;

    case 36:  #line 171 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AddressCondition()); } break;

    case 37:  #line 171 "grammar/sieve.jay"
    {
      isset($yyVals[-2+$yyTop]['addresspart']) && $yyVals[-4+$yyTop]->addresspart= $yyVals[-2+$yyTop]['addresspart'];
      isset($yyVals[-2+$yyTop]['comparator']) && $yyVals[-4+$yyTop]->comparator= $yyVals[-2+$yyTop]['comparator'];
      isset($yyVals[-2+$yyTop]['matchtype']) && $yyVals[-4+$yyTop]->matchtype= $yyVals[-2+$yyTop]['matchtype'];
      $yyVals[-4+$yyTop]->headers= (array)$yyVals[-1+$yyTop];
      $yyVals[-4+$yyTop]->keys= (array)$yyVals[0+$yyTop];
    } break;

    case 38:  #line 179 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new BooleanCondition(TRUE));
    } break;

    case 39:  #line 183 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new BooleanCondition(FALSE));
    } break;

    case 40:  #line 190 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 42:  #line 195 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 43:  #line 196 "grammar/sieve.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 44:  #line 200 "grammar/sieve.jay"
    { $yyVal= array('matchtype' => $yyVals[0+$yyTop]); } break;

    case 45:  #line 201 "grammar/sieve.jay"
    { $yyVal= array('addresspart' => $yyVals[0+$yyTop]); } break;

    case 46:  #line 202 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 47:  #line 203 "grammar/sieve.jay"
    { $yyVal= array('comparator' => $yyVals[0+$yyTop]); } break;

    case 48:  #line 207 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 49:  #line 208 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 50:  #line 212 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 52:  #line 217 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 53:  #line 218 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 56:  #line 224 "grammar/sieve.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 63:  #line 244 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 64:  #line 245 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;
#line 588 "-"
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
