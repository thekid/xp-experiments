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
  define('TOKEN_T_REGEX',  403);
  define('TOKEN_T_VALUE',  404);
  define('TOKEN_T_COUNT',  405);
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
         15,    31,    31,    21,    21,    21,    30,    29,    29,    29, 
         28,    28,    28,    28,    28,    28,     5,     5, 
    );
    protected static $yyLen= array(2,
          2,     0,     1,     1,     2,     3,     5,     0,     1,     1, 
          2,     0,     7,     1,     0,     4,     6,     1,     2,     0, 
          5,     0,     5,     0,     5,     0,     3,     0,     5,     0, 
          3,     0,     5,     0,     5,     0,     5,     1,     1,     0, 
          1,     1,     2,     2,     2,     3,     2,     1,     3,     0, 
          1,     1,     2,     1,     1,     3,     2,     1,     1,     1, 
          1,     1,     1,     2,     1,     2,     1,     3, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     3,     0,     0,     0,    20,    12,     1, 
          9,     0,    14,     0,     5,     6,     0,     0,     0,     0, 
         11,    19,     0,     0,     0,     0,    41,     0,    22,    24, 
         26,    28,     0,    36,    38,    39,    34,    30,     0,    68, 
          7,     0,     0,    61,    62,    63,    65,     0,     0,    58, 
         59,    60,    44,    45,    47,    54,    55,     0,     0,     0, 
         51,    43,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    46,    57,    64,    66,     0,    21,    53,     0,     0, 
         27,     0,    32,     0,     0,    31,     0,    56,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    23,    25,    29, 
         33,    37,    35,     0,     0,    13,    49,     0,     0,     0, 
          0,    16,     0,     0,    17, 
    );
    protected static $yyDgoto= array(2,
          3,    10,     4,     5,    18,    11,    12,    89,    20,    13, 
        106,    14,    26,    19,    59,    63,    90,    64,    65,    66, 
         60,    70,    93,    69,    68,    27,    28,    53,    54,    55, 
         61, 
    );
    protected static $yySindex = array(         -250,
        -80,     0,  -247,     0,  -250,   -36,  -232,     0,     0,     0, 
          0,  -247,     0,  -228,     0,     0,    -4,   -52,   -19,  -276, 
          0,     0,  -232,   -17,  -260,   -84,     0,   -19,     0,     0, 
          0,     0,   -15,     0,     0,     0,     0,     0,   -79,     0, 
          0,   -84,  -213,     0,     0,     0,     0,  -212,  -211,     0, 
          0,     0,     0,     0,     0,     0,     0,  -232,    -8,   -84, 
          0,     0,    12,    13,  -276,   -19,  -206,   -19,   -19,   -84, 
       -228,     0,     0,     0,     0,   -37,     0,     0,  -276,  -276, 
          0,   -84,     0,   -84,   -84,     0,   -68,     0,    15,    21, 
         22,   -84,  -199,   -84,   -84,  -246,  -276,     0,     0,     0, 
          0,     0,     0,   -58,  -276,     0,     0,  -228,   -56,   -51, 
       -228,     0,   -50,  -246,     0, 
    );
    protected static $yyRindex= array(            1,
          0,     0,    69,     0,     2,     0,     0,     0,     0,     0, 
          0,    72,     0,     3,     0,     0,   -20,     0,   -54,     0, 
          0,     0,     0,     0,     0,    17,     0,   -53,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    18, 
          0,     0,     0,     0,     0,   -83,     0,   -83,   -83,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,    37,     0, 
          0,     0,     0,     0,     0,     4,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     4,     0, 
    );
    protected static $yyGindex= array(0,
          0,     0,    74,     0,   -11,    68,     0,   -10,     0,    -5, 
        -33,     0,   -47,     0,     0,     0,   -63,     0,     0,     0, 
        -24,     0,     0,     0,     0,    54,     0,     0,     0,     0, 
         23, 
    );
    protected static $yyTable = array(42,
          2,     4,    18,    15,    40,    42,    58,    40,    22,    39, 
          7,    40,     8,    29,    30,    31,    91,    72,    82,     1, 
         84,    85,    16,    32,    33,    34,    35,    36,    17,    37, 
         38,     8,     9,   107,   104,   105,    40,    42,    25,    23, 
         24,    41,    67,    71,    43,    86,    76,    73,    74,    75, 
         77,    79,    80,    83,    81,    88,    96,    92,    97,    94, 
         95,    98,    99,   101,   108,    87,   111,   100,     8,   102, 
        103,    10,    67,   112,   114,    50,    52,    48,    15,    21, 
        115,    62,    78,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,   109,     0,     0,     0,     0,     0, 
          0,     0,   110,     0,     0,   113,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    18,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    44, 
         45,    46,    47,    48,    49,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,    56,    40,    57,    40, 
          6,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,    40,    42,    40,    42, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    50, 
         51,    52,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          2,     4,     0,    15,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          2,     4,    18,    15, 
    );
    protected static $yyCheck = array(260,
          0,     0,     0,     0,    59,    59,    91,    91,    14,    20, 
         91,    23,   260,   290,   291,   292,    80,    42,    66,   270, 
         68,    69,    59,   300,   301,   302,   303,   304,   261,   306, 
        307,   260,   280,    97,   281,   282,    91,    91,    58,    44, 
         93,    59,    58,   123,   305,    70,    58,   261,   261,   261, 
         59,    40,    40,   260,    65,    93,   125,    82,    44,    84, 
         85,    41,    41,   263,   123,    71,   123,    92,     0,    94, 
         95,     0,    93,   125,   125,    59,    59,    41,     5,    12, 
        114,    28,    60,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,   105,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,   108,    -1,    -1,   111,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,   125,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   400, 
        401,   402,   403,   404,   405,    -1,    -1,    -1,    -1,    -1, 
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
      'T_CONTAINS', 'T_MATCHES', 'T_REGEX', 'T_VALUE', 'T_COUNT', NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T_ALL', 'T_DOMAIN', 'T_LOCALPART', 
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

    case 1:  #line 57 "grammar/sieve.jay"
    {
      $yyVal= new peer新ieve惹yntaxTree();
      $yyVal->required= $yyVals[-1+$yyTop];
      $yyVal->ruleset= new peer新ieve愛uleSet();
      $yyVal->ruleset->rules= $yyVals[0+$yyTop];
    } break;

    case 2:  #line 67 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 4:  #line 72 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 5:  #line 73 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 6:  #line 77 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop]); } break;

    case 7:  #line 78 "grammar/sieve.jay"
    { $yyVal= $yyVals[-2+$yyTop]; } break;

    case 8:  #line 84 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 10:  #line 89 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 11:  #line 90 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 12:  #line 94 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new peer新ieve愛ule()); } break;

    case 13:  #line 94 "grammar/sieve.jay"
    {
      $yyVals[-6+$yyTop]->condition= $yyVals[-4+$yyTop];
      $yyVals[-6+$yyTop]->actions= $yyVals[-2+$yyTop];
    } break;

    case 14:  #line 98 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new peer新ieve愛ule());
      $yyVal->condition= NULL;
      $yyVal->actions= $yyVals[0+$yyTop];
    } break;

    case 15:  #line 107 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 18:  #line 114 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 19:  #line 115 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 20:  #line 119 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(ActionFactory::newAction($yyVals[0+$yyTop])); } break;

    case 21:  #line 119 "grammar/sieve.jay"
    {
      try {
        $yyVals[-4+$yyTop]->pass($yyVals[-2+$yyTop], $yyVals[-1+$yyTop]);
      } catch (IllegalArgumentException $e) { 
        $this->error(E_ERROR, $e->getMessage().' at '.$yyLex->fileName.', line '.$yyLex->position[0]); 
        $yyVals[-4+$yyTop]= NULL;
      }
    } break;

    case 22:  #line 132 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AllOfCondition()); } break;

    case 23:  #line 132 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->conditions= $yyVals[-1+$yyTop];
    } break;

    case 24:  #line 136 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AnyOfCondition()); } break;

    case 25:  #line 136 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->conditions= $yyVals[-1+$yyTop];
    } break;

    case 26:  #line 140 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new NegationOfCondition()); } break;

    case 27:  #line 140 "grammar/sieve.jay"
    {
      $yyVals[-2+$yyTop]->negated= $yyVals[-1+$yyTop];
    } break;

    case 28:  #line 144 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new HeaderCondition()); } break;

    case 29:  #line 144 "grammar/sieve.jay"
    { 
      isset($yyVals[-2+$yyTop]['comparator']) && $yyVals[-4+$yyTop]->comparator= $yyVals[-2+$yyTop]['comparator'];
      isset($yyVals[-2+$yyTop]['matchtype']) && $yyVals[-4+$yyTop]->matchtype= $yyVals[-2+$yyTop]['matchtype'];
      $yyVals[-4+$yyTop]->names= (array)$yyVals[-1+$yyTop];
      $yyVals[-4+$yyTop]->keys= (array)$yyVals[0+$yyTop];
    } break;

    case 30:  #line 151 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new ExistsCondition()); } break;

    case 31:  #line 151 "grammar/sieve.jay"
    {
      $yyVals[-2+$yyTop]->names= (array)$yyVals[0+$yyTop];
    } break;

    case 32:  #line 155 "grammar/sieve.jay"
    { 
      try { 
        $yyVals[-2+$yyTop]= $yyLex->create(SizeCondition::forName($yyVals[0+$yyTop])); 
      } catch (IllegalArgumentException $e) { 
        $this->error(E_ERROR, $e->getMessage().' at '.$yyLex->fileName.', line '.$yyLex->position[0]); 
        $yyVals[-2+$yyTop]= NULL;
      }
    } break;

    case 33:  #line 162 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop] && $yyVals[-4+$yyTop]->value= intval($yyVals[0+$yyTop]);
    } break;

    case 34:  #line 166 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new EnvelopeCondition()); } break;

    case 35:  #line 166 "grammar/sieve.jay"
    {
      isset($yyVals[-2+$yyTop]['addresspart']) && $yyVals[-4+$yyTop]->addresspart= $yyVals[-2+$yyTop]['addresspart'];
      isset($yyVals[-2+$yyTop]['comparator']) && $yyVals[-4+$yyTop]->comparator= $yyVals[-2+$yyTop]['comparator'];
      isset($yyVals[-2+$yyTop]['matchtype']) && $yyVals[-4+$yyTop]->matchtype= $yyVals[-2+$yyTop]['matchtype'];
      $yyVals[-4+$yyTop]->headers= (array)$yyVals[-1+$yyTop];
      $yyVals[-4+$yyTop]->keys= (array)$yyVals[0+$yyTop];
    } break;

    case 36:  #line 174 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AddressCondition()); } break;

    case 37:  #line 174 "grammar/sieve.jay"
    {
      isset($yyVals[-2+$yyTop]['addresspart']) && $yyVals[-4+$yyTop]->addresspart= $yyVals[-2+$yyTop]['addresspart'];
      isset($yyVals[-2+$yyTop]['comparator']) && $yyVals[-4+$yyTop]->comparator= $yyVals[-2+$yyTop]['comparator'];
      isset($yyVals[-2+$yyTop]['matchtype']) && $yyVals[-4+$yyTop]->matchtype= $yyVals[-2+$yyTop]['matchtype'];
      $yyVals[-4+$yyTop]->headers= (array)$yyVals[-1+$yyTop];
      $yyVals[-4+$yyTop]->keys= (array)$yyVals[0+$yyTop];
    } break;

    case 38:  #line 182 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new BooleanCondition(TRUE));
    } break;

    case 39:  #line 186 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new BooleanCondition(FALSE));
    } break;

    case 40:  #line 193 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 42:  #line 198 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 43:  #line 199 "grammar/sieve.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 44:  #line 203 "grammar/sieve.jay"
    { $yyVal= array('matchtype' => $yyVals[0+$yyTop]); } break;

    case 45:  #line 204 "grammar/sieve.jay"
    { $yyVal= array('addresspart' => $yyVals[0+$yyTop]); } break;

    case 46:  #line 205 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 47:  #line 206 "grammar/sieve.jay"
    { $yyVal= array('comparator' => $yyVals[0+$yyTop]); } break;

    case 48:  #line 210 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 49:  #line 211 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 50:  #line 215 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 52:  #line 220 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 53:  #line 221 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 56:  #line 227 "grammar/sieve.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 57:  #line 235 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 64:  #line 248 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 66:  #line 250 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 67:  #line 254 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 68:  #line 255 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;
#line 605 "-"
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
