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
    'peer.sieve.AddressPart',
    'peer.sieve.ActionFactory',
    'peer.sieve.AllOfCondition',
    'peer.sieve.NegationOfCondition',
    'peer.sieve.AnyOfCondition',
    'peer.sieve.HeaderCondition',
    'peer.sieve.ExistsCondition',
    'peer.sieve.SizeCondition',
    'peer.sieve.AddressCondition',
    'peer.sieve.EnvelopeCondition',
    'peer.sieve.BooleanCondition',
    'peer.sieve.MatchType',
    'peer.sieve.ValueMatch',
    'peer.sieve.CountMatch'
  );
#line 29 "-"
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
  define('TOKEN_T_USER',  503);
  define('TOKEN_T_DETAIL',  504);
  define('TOKEN_YY_ERRORCODE', 256);

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class SieveParser extends AbstractParser {
    protected static $yyLhs= array(-1,
          0,     1,     1,     3,     3,     4,     4,     2,     2,     6, 
          6,     9,     7,     7,    11,    13,    11,    14,    11,    10, 
         10,    16,    12,    18,     8,    20,     8,    21,     8,    22, 
          8,    24,     8,    25,     8,    26,     8,    27,     8,     8, 
          8,    15,    15,    28,    28,    29,    29,    29,    29,    19, 
         19,    17,    17,    33,    33,    23,    23,    23,    32,    31, 
         31,    31,    31,    31,    30,    30,    30,    30,    30,    30, 
          5,     5, 
    );
    protected static $yyLen= array(2,
          2,     0,     1,     1,     2,     3,     5,     0,     1,     1, 
          2,     0,     7,     1,     0,     0,     5,     0,     7,     1, 
          2,     0,     5,     0,     5,     0,     5,     0,     3,     0, 
          5,     0,     3,     0,     5,     0,     5,     0,     5,     1, 
          1,     0,     1,     1,     2,     2,     2,     3,     2,     1, 
          3,     0,     1,     1,     2,     1,     1,     3,     2,     1, 
          1,     1,     1,     1,     1,     1,     1,     1,     2,     2, 
          1,     3, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     3,     0,     0,     0,    22,    12,     1, 
          9,     0,    14,     5,     6,     0,     0,     0,     0,    11, 
          0,     0,     0,     0,    43,     0,    24,    26,    28,    30, 
          0,    38,    40,    41,    36,    32,     0,    72,     7,     0, 
          0,    65,    66,    67,    68,     0,     0,    60,    61,    62, 
         63,    64,    46,    47,    49,    56,    57,     0,     0,     0, 
         53,    45,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    48,    59,    69,    70,     0,    23,    55,     0,     0, 
         29,     0,    34,     0,     0,    33,     0,     0,    58,     0, 
          0,     0,     0,     0,     0,     0,     0,    21,     0,    25, 
         27,    31,    35,    39,    37,    16,    18,    13,    51,     0, 
          0,     0,     0,     0,     0,    17,     0,     0,    19, 
    );
    protected static $yyDgoto= array(2,
          3,    10,     4,     5,    17,    11,    12,    90,    19,    87, 
        108,    88,   110,   111,    24,    18,    59,    63,    91,    64, 
         65,    66,    60,    70,    94,    69,    68,    25,    26,    53, 
         54,    55,    61, 
    );
    protected static $yySindex = array(         -253,
        -81,     0,  -248,     0,  -253,   -36,  -237,     0,     0,     0, 
          0,  -248,     0,     0,     0,   -19,   -67,   -31,  -232,     0, 
       -237,   -30,  -260,   -85,     0,   -31,     0,     0,     0,     0, 
        -28,     0,     0,     0,     0,     0,   -95,     0,     0,   -85, 
       -230,     0,     0,     0,     0,  -227,  -226,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,  -237,   -21,   -85, 
          0,     0,     4,     7,  -232,   -31,  -220,   -31,   -31,   -85, 
       -217,     0,     0,     0,     0,   -45,     0,     0,  -232,  -232, 
          0,   -85,     0,   -85,   -85,     0,   -76,  -217,     0,     6, 
         11,    16,   -85,  -212,   -85,   -85,  -261,     0,  -232,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,   -62, 
       -232,  -217,   -61,   -60,  -217,     0,   -52,  -261,     0, 
    );
    protected static $yyRindex= array(            1,
          0,     0,    63,     0,     2,     0,     0,     0,     0,     0, 
          0,    76,     0,     0,     0,   -16,     0,   -55,     0,     0, 
          0,     0,     0,    19,     0,   -54,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    20, 
          0,     0,     0,     0,     0,   -84,     0,   -84,   -84,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,   -44,     0,    39, 
          0,     0,     0,     0,     0,     0,     3,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     3,     0, 
    );
    protected static $yyGindex= array(0,
          0,     0,    77,     0,   -12,    71,     0,   -11,     0,   -73, 
        -34,    10,     0,     0,   -50,     0,     0,     0,   -66,     0, 
          0,     0,   -29,     0,     0,     0,     0,    59,     0,     0, 
          0,     0,    26, 
    );
    protected static $yyTable = array(40,
          2,     4,    15,    42,    44,    58,    42,    37,    38,     7, 
         72,     8,    13,    92,    98,    82,     1,    84,    85,   106, 
        107,    13,    15,    16,    21,    22,    23,    71,    39,    67, 
         73,     9,   109,    74,    75,    42,    44,    77,   114,    83, 
         86,   117,     8,    79,    41,    76,    80,    89,    97,    99, 
        103,   100,    93,    81,    95,    96,   101,    27,    28,    29, 
        112,   115,     8,   102,   116,   104,   105,    30,    31,    32, 
         33,    34,   118,    35,    36,    10,    71,    52,    54,    50, 
         20,    14,    20,   119,    62,    78,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,   113, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    42, 
         43,    44,    45,    46,    47,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,    56,    42,    57,    42,     6, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,    42,    44,    42,    44,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    48, 
         49,    50,    51,    52,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          2,     4,    15,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          2,     4,    15, 
    );
    protected static $yyCheck = array(260,
          0,     0,     0,    59,    59,    91,    91,    19,    21,    91, 
         40,   260,     3,    80,    88,    66,   270,    68,    69,   281, 
        282,    12,    59,   261,    44,    93,    58,   123,    59,    58, 
        261,   280,    99,   261,   261,    91,    91,    59,   112,   260, 
         70,   115,   260,    40,   305,    58,    40,    93,   125,    44, 
        263,    41,    82,    65,    84,    85,    41,   290,   291,   292, 
        123,   123,     0,    93,   125,    95,    96,   300,   301,   302, 
        303,   304,   125,   306,   307,     0,    93,    59,    59,    41, 
        125,     5,    12,   118,    26,    60,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   111, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   400, 
        401,   402,   403,   404,   405,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,   261,   261,   263,   263,   261, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,   261,   261,   263,   263,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   500, 
        501,   502,   503,   504,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
        260,   260,   260,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
        280,   280,   280, 
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
      'T_USER', 'T_DETAIL', 
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

    case 1:  #line 62 "grammar/sieve.jay"
    {
      $yyVal= new peer新ieve惹yntaxTree();
      $yyVal->required= $yyVals[-1+$yyTop];
      $yyVal->ruleset= new peer新ieve愛uleSet();
      $yyVal->ruleset->rules= $yyVals[0+$yyTop];
    } break;

    case 2:  #line 72 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 4:  #line 77 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 5:  #line 78 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 6:  #line 82 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop]); } break;

    case 7:  #line 83 "grammar/sieve.jay"
    { $yyVal= $yyVals[-2+$yyTop]; } break;

    case 8:  #line 89 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 10:  #line 94 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 11:  #line 95 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 12:  #line 99 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new peer新ieve愛ule()); } break;

    case 13:  #line 99 "grammar/sieve.jay"
    {
      $yyVals[-6+$yyTop]->condition= $yyVals[-4+$yyTop];
      $yyVals[-6+$yyTop]->actions= $yyVals[-2+$yyTop];
      $yyVals[-6+$yyTop]->otherwise= $yyVals[0+$yyTop];
      if ($yyVals[0+$yyTop] && !$yyVals[0+$yyTop]->condition) {    /* dangling else*/
        $yyVals[0+$yyTop]->condition= new NegationOfCondition();
        $yyVals[0+$yyTop]->condition->negated= $yyVals[-4+$yyTop];
      }
    } break;

    case 14:  #line 108 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new peer新ieve愛ule());
      $yyVal->condition= NULL;
      $yyVal->actions= array($yyVals[0+$yyTop]);
    } break;

    case 15:  #line 117 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 16:  #line 118 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new peer新ieve愛ule()); } break;

    case 17:  #line 118 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->condition= NULL;
      $yyVals[-4+$yyTop]->actions= $yyVals[-1+$yyTop];
    } break;

    case 18:  #line 122 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new peer新ieve愛ule()); } break;

    case 19:  #line 122 "grammar/sieve.jay"
    {
      $yyVals[-6+$yyTop]->condition= $yyVals[-4+$yyTop];
      $yyVals[-6+$yyTop]->actions= $yyVals[-2+$yyTop];
      $yyVals[-6+$yyTop]->otherwise= $yyVals[0+$yyTop];
      if ($yyVals[0+$yyTop] && !$yyVals[0+$yyTop]->condition) {    /* dangling else*/
        $yyVals[0+$yyTop]->condition= new NegationOfCondition();
        $yyVals[0+$yyTop]->condition->negated= $yyVals[-4+$yyTop];
      }
    } break;

    case 20:  #line 135 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 21:  #line 136 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 22:  #line 140 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(ActionFactory::newAction($yyVals[0+$yyTop])); } break;

    case 23:  #line 140 "grammar/sieve.jay"
    {
      try {
        $yyVals[-4+$yyTop]->pass($yyVals[-2+$yyTop], $yyVals[-1+$yyTop]);
      } catch (IllegalArgumentException $e) { 
        $this->error(E_ERROR, $e->getMessage().' at '.$yyLex->fileName.', line '.$yyLex->position[0]); 
        $yyVals[-4+$yyTop]= NULL;
      }
    } break;

    case 24:  #line 153 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AllOfCondition()); } break;

    case 25:  #line 153 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->conditions= $yyVals[-1+$yyTop];
    } break;

    case 26:  #line 157 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AnyOfCondition()); } break;

    case 27:  #line 157 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->conditions= $yyVals[-1+$yyTop];
    } break;

    case 28:  #line 161 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new NegationOfCondition()); } break;

    case 29:  #line 161 "grammar/sieve.jay"
    {
      $yyVals[-2+$yyTop]->negated= $yyVals[-1+$yyTop];
    } break;

    case 30:  #line 165 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new HeaderCondition()); } break;

    case 31:  #line 165 "grammar/sieve.jay"
    { 
      isset($yyVals[-2+$yyTop]['comparator']) && $yyVals[-4+$yyTop]->comparator= $yyVals[-2+$yyTop]['comparator'];
      isset($yyVals[-2+$yyTop]['matchtype']) && $yyVals[-4+$yyTop]->matchtype= $yyVals[-2+$yyTop]['matchtype'];
      $yyVals[-4+$yyTop]->names= (array)$yyVals[-1+$yyTop];
      $yyVals[-4+$yyTop]->keys= (array)$yyVals[0+$yyTop];
    } break;

    case 32:  #line 172 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new ExistsCondition()); } break;

    case 33:  #line 172 "grammar/sieve.jay"
    {
      $yyVals[-2+$yyTop]->names= (array)$yyVals[0+$yyTop];
    } break;

    case 34:  #line 176 "grammar/sieve.jay"
    { 
      try { 
        $yyVals[-2+$yyTop]= $yyLex->create(SizeCondition::forName($yyVals[0+$yyTop])); 
      } catch (IllegalArgumentException $e) { 
        $this->error(E_ERROR, $e->getMessage().' at '.$yyLex->fileName.', line '.$yyLex->position[0]); 
        $yyVals[-2+$yyTop]= NULL;
      }
    } break;

    case 35:  #line 183 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop] && $yyVals[-4+$yyTop]->value= intval($yyVals[0+$yyTop]);
    } break;

    case 36:  #line 187 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new EnvelopeCondition()); } break;

    case 37:  #line 187 "grammar/sieve.jay"
    {
      isset($yyVals[-2+$yyTop]['addresspart']) && $yyVals[-4+$yyTop]->addresspart= $yyVals[-2+$yyTop]['addresspart'];
      isset($yyVals[-2+$yyTop]['comparator']) && $yyVals[-4+$yyTop]->comparator= $yyVals[-2+$yyTop]['comparator'];
      isset($yyVals[-2+$yyTop]['matchtype']) && $yyVals[-4+$yyTop]->matchtype= $yyVals[-2+$yyTop]['matchtype'];
      $yyVals[-4+$yyTop]->headers= (array)$yyVals[-1+$yyTop];
      $yyVals[-4+$yyTop]->keys= (array)$yyVals[0+$yyTop];
    } break;

    case 38:  #line 195 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new AddressCondition()); } break;

    case 39:  #line 195 "grammar/sieve.jay"
    {
      isset($yyVals[-2+$yyTop]['addresspart']) && $yyVals[-4+$yyTop]->addresspart= $yyVals[-2+$yyTop]['addresspart'];
      isset($yyVals[-2+$yyTop]['comparator']) && $yyVals[-4+$yyTop]->comparator= $yyVals[-2+$yyTop]['comparator'];
      isset($yyVals[-2+$yyTop]['matchtype']) && $yyVals[-4+$yyTop]->matchtype= $yyVals[-2+$yyTop]['matchtype'];
      $yyVals[-4+$yyTop]->headers= (array)$yyVals[-1+$yyTop];
      $yyVals[-4+$yyTop]->keys= (array)$yyVals[0+$yyTop];
    } break;

    case 40:  #line 203 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new BooleanCondition(TRUE));
    } break;

    case 41:  #line 207 "grammar/sieve.jay"
    { 
      $yyVal= $yyLex->create(new BooleanCondition(FALSE));
    } break;

    case 42:  #line 214 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 44:  #line 219 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 45:  #line 220 "grammar/sieve.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 46:  #line 224 "grammar/sieve.jay"
    { $yyVal= array('matchtype' => $yyVals[0+$yyTop]); } break;

    case 47:  #line 225 "grammar/sieve.jay"
    { $yyVal= array('addresspart' => $yyVals[0+$yyTop]); } break;

    case 48:  #line 226 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 49:  #line 227 "grammar/sieve.jay"
    { $yyVal= array('comparator' => $yyVals[0+$yyTop]); } break;

    case 50:  #line 231 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 51:  #line 232 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 52:  #line 236 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 54:  #line 241 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 55:  #line 242 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 58:  #line 248 "grammar/sieve.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 59:  #line 256 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 60:  #line 260 "grammar/sieve.jay"
    { $yyVal= AddressPart::$all; } break;

    case 61:  #line 261 "grammar/sieve.jay"
    { $yyVal= AddressPart::$domain; } break;

    case 62:  #line 262 "grammar/sieve.jay"
    { $yyVal= AddressPart::$localpart; } break;

    case 63:  #line 263 "grammar/sieve.jay"
    { $yyVal= AddressPart::$user; } break;

    case 64:  #line 264 "grammar/sieve.jay"
    { $yyVal= AddressPart::$detail; } break;

    case 65:  #line 268 "grammar/sieve.jay"
    { $yyVal= MatchType::is(); } break;

    case 66:  #line 269 "grammar/sieve.jay"
    { $yyVal= MatchType::contains(); } break;

    case 67:  #line 270 "grammar/sieve.jay"
    { $yyVal= MatchType::matches(); } break;

    case 68:  #line 271 "grammar/sieve.jay"
    { $yyVal= MatchType::regex(); } break;

    case 69:  #line 272 "grammar/sieve.jay"
    { $yyVal= new ValueMatch($yyVals[0+$yyTop]); } break;

    case 70:  #line 273 "grammar/sieve.jay"
    { $yyVal= new CountMatch($yyVals[0+$yyTop]); } break;

    case 71:  #line 277 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 72:  #line 278 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;
#line 669 "-"
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
