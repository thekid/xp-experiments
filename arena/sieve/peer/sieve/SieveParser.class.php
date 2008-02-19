<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses('text.parser.generic.AbstractParser');

#line 2 "grammar/sieve.jay"
  uses(
    'peer.sieve.SyntaxTree',
    'peer.sieve.CommandSet',
    'peer.sieve.Rule',
    'peer.sieve.AddressPart',
    'peer.sieve.action.ActionFactory',
    'peer.sieve.condition.AllOfCondition',
    'peer.sieve.condition.NegationOfCondition',
    'peer.sieve.condition.AnyOfCondition',
    'peer.sieve.condition.HeaderCondition',
    'peer.sieve.condition.ExistsCondition',
    'peer.sieve.condition.SizeCondition',
    'peer.sieve.condition.AddressCondition',
    'peer.sieve.condition.EnvelopeCondition',
    'peer.sieve.condition.BooleanCondition',
    'peer.sieve.match.MatchType',
    'peer.sieve.match.ValueMatch',
    'peer.sieve.match.CountMatch'
  );
#line 29 "-"

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class SieveParser extends AbstractParser {
    const T_WORD= 260;
    const T_STRING= 261;
    const T_NUMBER= 263;
    const T_REQUIRE= 270;
    const T_IF= 280;
    const T_ELSE= 281;
    const T_ELSEIF= 282;
    const T_ALLOF= 290;
    const T_ANYOF= 291;
    const T_NOT= 292;
    const T_HEADER= 300;
    const T_SIZE= 301;
    const T_ADDRESS= 302;
    const T_TRUE= 303;
    const T_FALSE= 304;
    const T_COMPARATOR= 305;
    const T_ENVELOPE= 306;
    const T_EXISTS= 307;
    const T_IS= 400;
    const T_CONTAINS= 401;
    const T_MATCHES= 402;
    const T_REGEX= 403;
    const T_VALUE= 404;
    const T_COUNT= 405;
    const T_ALL= 500;
    const T_DOMAIN= 501;
    const T_LOCALPART= 502;
    const T_USER= 503;
    const T_DETAIL= 504;
    const YY_ERRORCODE= 256;

    protected static $yyLhs= array(-1,
          0,     1,     1,     3,     3,     4,     4,     2,     2,     6, 
          6,     9,     7,     7,    10,    12,    10,    13,    10,    15, 
         11,    17,     8,    19,     8,    20,     8,    21,     8,    23, 
          8,    24,     8,    25,     8,    26,     8,     8,     8,    14, 
         14,    27,    27,    28,    28,    28,    28,    18,    18,    16, 
         16,    32,    32,    22,    22,    22,    31,    30,    30,    30, 
         30,    30,    29,    29,    29,    29,    29,    29,     5,     5, 
    );
    protected static $yyLen= array(2,
          2,     0,     1,     1,     2,     3,     5,     0,     1,     1, 
          2,     0,     7,     1,     0,     0,     5,     0,     7,     0, 
          5,     0,     5,     0,     5,     0,     3,     0,     5,     0, 
          3,     0,     5,     0,     5,     0,     5,     1,     1,     0, 
          1,     1,     2,     2,     2,     3,     2,     1,     3,     0, 
          1,     1,     2,     1,     1,     3,     2,     1,     1,     1, 
          1,     1,     1,     1,     1,     1,     2,     2,     1,     3, 
    );
    protected static $yyDefRed= array(0,
          0,     0,     0,     3,     0,     0,     0,    20,    12,     1, 
          9,     0,    14,     5,     6,     0,     0,     0,     0,    11, 
          0,     0,     0,     0,    41,     0,    22,    24,    26,    28, 
          0,    36,    38,    39,    34,    30,     0,    70,     7,     0, 
          0,    63,    64,    65,    66,     0,     0,    58,    59,    60, 
         61,    62,    44,    45,    47,    54,    55,     0,     0,     0, 
         51,    43,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    46,    57,    67,    68,     0,    21,    53,     0,     0, 
         27,     0,    32,     0,     0,    31,     0,    56,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    23,    25,    29, 
         33,    37,    35,    16,    18,    13,    49,     0,     0,     0, 
          0,     0,     0,    17,     0,     0,    19, 
    );
    protected static $yyDgoto= array(2,
          3,    10,     4,     5,    17,    11,    12,    89,    19,   106, 
         13,   108,   109,    24,    18,    59,    63,    90,    64,    65, 
         66,    60,    70,    93,    69,    68,    25,    26,    53,    54, 
         55,    61, 
    );
    protected static $yySindex = array(         -250,
        -81,     0,  -247,     0,  -250,   -29,  -227,     0,     0,     0, 
          0,  -247,     0,     0,     0,    -6,   -53,   -19,  -275,     0, 
       -227,   -18,  -260,   -85,     0,   -19,     0,     0,     0,     0, 
        -15,     0,     0,     0,     0,     0,   -79,     0,     0,   -85, 
       -215,     0,     0,     0,     0,  -214,  -213,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,  -227,    -1,   -85, 
          0,     0,     9,    12,  -275,   -19,  -201,   -19,   -19,   -85, 
       -247,     0,     0,     0,     0,   -33,     0,     0,  -275,  -275, 
          0,   -85,     0,   -85,   -85,     0,   -64,     0,    18,    22, 
         24,   -85,  -195,   -85,   -85,  -258,  -275,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,   -52,  -275,  -247, 
        -51,   -56,  -247,     0,   -50,  -258,     0, 
    );
    protected static $yyRindex= array(            2,
          0,     0,    70,     0,     3,     0,     0,     0,     0,     0, 
          0,     8,     0,     0,     0,   -20,     0,   -55,     0,     0, 
          0,     0,     0,    15,     0,   -54,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    17, 
          0,     0,     0,     0,     0,   -84,     0,   -84,   -84,     0, 
        -48,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,    37,     0, 
          0,     0,     0,     0,     0,     1,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,   -48, 
          0,     0,   -48,     0,     0,     1,     0, 
    );
    protected static $yyGindex= array(0,
          0,   -60,    74,     0,    -7,    68,     0,   -10,     0,   -35, 
          0,     0,     0,   -47,     0,     0,     0,   -62,     0,     0, 
          0,   -28,     0,     0,     0,     0,    56,     0,     0,     0, 
          0,    23, 
    );
    protected static $yyTable = array(40,
         15,     2,     4,    40,    42,    58,    40,    10,    37,     7, 
         87,    72,     8,    38,    27,    28,    29,    91,    82,     1, 
         84,    85,   104,   105,    30,    31,    32,    33,    34,    15, 
         35,    36,     9,    16,   107,    40,    42,    21,    23,    22, 
         39,    86,    67,    71,    41,    73,    74,    75,    79,   112, 
         76,    80,   115,    92,    81,    94,    95,    77,    83,    88, 
         96,    97,    98,   100,    99,   102,   103,   101,   114,     8, 
        110,   113,    69,    50,   116,    52,     8,    48,    14,    20, 
        117,    62,    78,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,   111,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,    15,     0,     0,     0,     0, 
          0,     0,    10,     0,     0,     0,     0,     0,     0,    42, 
         43,    44,    45,    46,    47,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,    56,    40,    57,    40,     6, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,    40,    42,    40,    42,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    48, 
         49,    50,    51,    52,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
         15,     2,     4,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
         15,     2,     4, 
    );
    protected static $yyCheck = array(260,
          0,     0,     0,    59,    59,    91,    91,     0,    19,    91, 
         71,    40,   260,    21,   290,   291,   292,    80,    66,   270, 
         68,    69,   281,   282,   300,   301,   302,   303,   304,    59, 
        306,   307,   280,   261,    97,    91,    91,    44,    58,    93, 
         59,    70,    58,   123,   305,   261,   261,   261,    40,   110, 
         58,    40,   113,    82,    65,    84,    85,    59,   260,    93, 
        125,    44,    41,    92,    41,    94,    95,   263,   125,     0, 
        123,   123,    93,    59,   125,    59,   125,    41,     5,    12, 
        116,    26,    60,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   109,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,   125,    -1,    -1,    -1,    -1, 
         -1,    -1,   125,    -1,    -1,    -1,    -1,    -1,    -1,   400, 
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
      $yyVal->commandset= new peer新ieve嵩ommandSet();
      $yyVal->commandset->list= $yyVals[0+$yyTop];
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
    { $yyVals[0+$yyTop]= new peer新ieve愛ule(); } break;

    case 13:  #line 99 "grammar/sieve.jay"
    {
      $yyVals[-6+$yyTop]->condition= $yyVals[-4+$yyTop];
      $yyVals[-6+$yyTop]->commands= $yyVals[-2+$yyTop];
      $yyVals[-6+$yyTop]->otherwise= $yyVals[0+$yyTop];
      if ($yyVals[0+$yyTop] && !$yyVals[0+$yyTop]->condition) {    /* dangling else*/
        $yyVals[0+$yyTop]->condition= new NegationOfCondition();
        $yyVals[0+$yyTop]->condition->negated= $yyVals[-4+$yyTop];
      }
    } break;

    case 15:  #line 113 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 16:  #line 114 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= new peer新ieve愛ule(); } break;

    case 17:  #line 114 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->condition= NULL;
      $yyVals[-4+$yyTop]->actions= $yyVals[-1+$yyTop];
    } break;

    case 18:  #line 118 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= new peer新ieve愛ule(); } break;

    case 19:  #line 118 "grammar/sieve.jay"
    {
      $yyVals[-6+$yyTop]->condition= $yyVals[-4+$yyTop];
      $yyVals[-6+$yyTop]->commands= $yyVals[-2+$yyTop];
      $yyVals[-6+$yyTop]->otherwise= $yyVals[0+$yyTop];
      if ($yyVals[0+$yyTop] && !$yyVals[0+$yyTop]->condition) {    /* dangling else*/
        $yyVals[0+$yyTop]->condition= new NegationOfCondition();
        $yyVals[0+$yyTop]->condition->negated= $yyVals[-4+$yyTop];
      }
    } break;

    case 20:  #line 131 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= ActionFactory::newAction($yyVals[0+$yyTop]); } break;

    case 21:  #line 131 "grammar/sieve.jay"
    {
      try {
        $yyVals[-4+$yyTop]->pass($yyVals[-2+$yyTop], $yyVals[-1+$yyTop]);
      } catch (IllegalArgumentException $e) { 
        $this->error(E_ERROR, $e->getMessage().' at '.$yyLex->fileName.', line '.$yyLex->position[0]); 
        $yyVals[-4+$yyTop]= NULL;
      }
    } break;

    case 22:  #line 144 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= new AllOfCondition(); } break;

    case 23:  #line 144 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->conditions= $yyVals[-1+$yyTop];
    } break;

    case 24:  #line 148 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= new AnyOfCondition(); } break;

    case 25:  #line 148 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop]->conditions= $yyVals[-1+$yyTop];
    } break;

    case 26:  #line 152 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= new NegationOfCondition(); } break;

    case 27:  #line 152 "grammar/sieve.jay"
    {
      $yyVals[-2+$yyTop]->negated= $yyVals[0+$yyTop];
    } break;

    case 28:  #line 156 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= new HeaderCondition(); } break;

    case 29:  #line 156 "grammar/sieve.jay"
    { 
      isset($yyVals[-2+$yyTop]['comparator']) && $yyVals[-4+$yyTop]->comparator= $yyVals[-2+$yyTop]['comparator'];
      isset($yyVals[-2+$yyTop]['matchtype']) && $yyVals[-4+$yyTop]->matchtype= $yyVals[-2+$yyTop]['matchtype'];
      $yyVals[-4+$yyTop]->names= (array)$yyVals[-1+$yyTop];
      $yyVals[-4+$yyTop]->keys= (array)$yyVals[0+$yyTop];
    } break;

    case 30:  #line 163 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= new ExistsCondition(); } break;

    case 31:  #line 163 "grammar/sieve.jay"
    {
      $yyVals[-2+$yyTop]->names= (array)$yyVals[0+$yyTop];
    } break;

    case 32:  #line 167 "grammar/sieve.jay"
    { 
      try { 
        $yyVals[-2+$yyTop]= SizeCondition::forName($yyVals[0+$yyTop]); 
      } catch (IllegalArgumentException $e) { 
        $this->error(E_ERROR, $e->getMessage().' at '.$yyLex->fileName.', line '.$yyLex->position[0]); 
        $yyVals[-2+$yyTop]= NULL;
      }
    } break;

    case 33:  #line 174 "grammar/sieve.jay"
    {
      $yyVals[-4+$yyTop] && $yyVals[-4+$yyTop]->value= intval($yyVals[0+$yyTop]);
    } break;

    case 34:  #line 178 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= new EnvelopeCondition(); } break;

    case 35:  #line 178 "grammar/sieve.jay"
    {
      isset($yyVals[-2+$yyTop]['addresspart']) && $yyVals[-4+$yyTop]->addresspart= $yyVals[-2+$yyTop]['addresspart'];
      isset($yyVals[-2+$yyTop]['comparator']) && $yyVals[-4+$yyTop]->comparator= $yyVals[-2+$yyTop]['comparator'];
      isset($yyVals[-2+$yyTop]['matchtype']) && $yyVals[-4+$yyTop]->matchtype= $yyVals[-2+$yyTop]['matchtype'];
      $yyVals[-4+$yyTop]->headers= (array)$yyVals[-1+$yyTop];
      $yyVals[-4+$yyTop]->keys= (array)$yyVals[0+$yyTop];
    } break;

    case 36:  #line 186 "grammar/sieve.jay"
    { $yyVals[0+$yyTop]= new AddressCondition(); } break;

    case 37:  #line 186 "grammar/sieve.jay"
    {
      isset($yyVals[-2+$yyTop]['addresspart']) && $yyVals[-4+$yyTop]->addresspart= $yyVals[-2+$yyTop]['addresspart'];
      isset($yyVals[-2+$yyTop]['comparator']) && $yyVals[-4+$yyTop]->comparator= $yyVals[-2+$yyTop]['comparator'];
      isset($yyVals[-2+$yyTop]['matchtype']) && $yyVals[-4+$yyTop]->matchtype= $yyVals[-2+$yyTop]['matchtype'];
      $yyVals[-4+$yyTop]->headers= (array)$yyVals[-1+$yyTop];
      $yyVals[-4+$yyTop]->keys= (array)$yyVals[0+$yyTop];
    } break;

    case 38:  #line 194 "grammar/sieve.jay"
    { 
      $yyVal= new BooleanCondition(TRUE);
    } break;

    case 39:  #line 198 "grammar/sieve.jay"
    { 
      $yyVal= new BooleanCondition(FALSE);
    } break;

    case 40:  #line 205 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 42:  #line 210 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 43:  #line 211 "grammar/sieve.jay"
    { $yyVal= array_merge($yyVals[-1+$yyTop], $yyVals[0+$yyTop]); } break;

    case 44:  #line 215 "grammar/sieve.jay"
    { $yyVal= array('matchtype' => $yyVals[0+$yyTop]); } break;

    case 45:  #line 216 "grammar/sieve.jay"
    { $yyVal= array('addresspart' => $yyVals[0+$yyTop]); } break;

    case 46:  #line 217 "grammar/sieve.jay"
    { $yyVal= array($yyVals[-1+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 47:  #line 218 "grammar/sieve.jay"
    { $yyVal= array('comparator' => $yyVals[0+$yyTop]); } break;

    case 48:  #line 222 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 49:  #line 223 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 50:  #line 227 "grammar/sieve.jay"
    { $yyVal= NULL; } break;

    case 52:  #line 232 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 53:  #line 233 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 56:  #line 239 "grammar/sieve.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 57:  #line 247 "grammar/sieve.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 58:  #line 251 "grammar/sieve.jay"
    { $yyVal= AddressPart::$all; } break;

    case 59:  #line 252 "grammar/sieve.jay"
    { $yyVal= AddressPart::$domain; } break;

    case 60:  #line 253 "grammar/sieve.jay"
    { $yyVal= AddressPart::$localpart; } break;

    case 61:  #line 254 "grammar/sieve.jay"
    { $yyVal= AddressPart::$user; } break;

    case 62:  #line 255 "grammar/sieve.jay"
    { $yyVal= AddressPart::$detail; } break;

    case 63:  #line 259 "grammar/sieve.jay"
    { $yyVal= MatchType::is(); } break;

    case 64:  #line 260 "grammar/sieve.jay"
    { $yyVal= MatchType::contains(); } break;

    case 65:  #line 261 "grammar/sieve.jay"
    { $yyVal= MatchType::matches(); } break;

    case 66:  #line 262 "grammar/sieve.jay"
    { $yyVal= MatchType::regex(); } break;

    case 67:  #line 263 "grammar/sieve.jay"
    { $yyVal= new ValueMatch($yyVals[0+$yyTop]); } break;

    case 68:  #line 264 "grammar/sieve.jay"
    { $yyVal= new CountMatch($yyVals[0+$yyTop]); } break;

    case 69:  #line 268 "grammar/sieve.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 70:  #line 269 "grammar/sieve.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;
#line 655 "-"
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
