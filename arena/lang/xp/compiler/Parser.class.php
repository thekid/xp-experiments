<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses('text.parser.generic.AbstractParser');

#line 2 "grammar/xp.jay"
  uses(
    'xp.compiler.types.TypeName',
    'xp.compiler.ast.ClassNode',
    'xp.compiler.ast.EnumNode',
    'xp.compiler.ast.InterfaceNode',
    'xp.compiler.ast.FieldNode',
    'xp.compiler.ast.PropertyNode',
    'xp.compiler.ast.MethodNode',
    'xp.compiler.ast.OperatorNode',
    'xp.compiler.ast.ReturnNode',
    'xp.compiler.ast.InstanceCreationNode',
    'xp.compiler.ast.VariableNode',
    'xp.compiler.ast.ArrayAccessNode',
    'xp.compiler.ast.TryNode',
    'xp.compiler.ast.CatchNode',
    'xp.compiler.ast.ThrowNode',
    'xp.compiler.ast.FinallyNode',
    'xp.compiler.ast.ForNode',
    'xp.compiler.ast.ForeachNode',
    'xp.compiler.ast.DoNode',
    'xp.compiler.ast.WhileNode',
    'xp.compiler.ast.AssignmentNode',
    'xp.compiler.ast.InvocationNode',
    'xp.compiler.ast.NumberNode',
    'xp.compiler.ast.StringNode',
    'xp.compiler.ast.ComparisonNode',
    'xp.compiler.ast.BinaryOpNode',
    'xp.compiler.ast.IfNode',
    'xp.compiler.ast.ElseNode'
  );
#line 40 "-"
  define('TOKEN_T_ADD_EQUAL',  404);
  define('TOKEN_T_SUB_EQUAL',  405);
  define('TOKEN_T_MUL_EQUAL',  406);
  define('TOKEN_T_DIV_EQUAL',  407);
  define('TOKEN_T_MOD_EQUAL',  408);
  define('TOKEN_T_SE',  401);
  define('TOKEN_T_GE',  400);
  define('TOKEN_T_OBJECT_OPERATOR',  409);
  define('TOKEN_T_EQUALS',  410);
  define('TOKEN_T_NOT_EQUALS',  411);
  define('TOKEN_T_WORD',  260);
  define('TOKEN_T_STRING',  261);
  define('TOKEN_T_NUMBER',  262);
  define('TOKEN_T_PUBLIC',  280);
  define('TOKEN_T_PRIVATE',  281);
  define('TOKEN_T_PROTECTED',  282);
  define('TOKEN_T_STATIC',  283);
  define('TOKEN_T_FINAL',  284);
  define('TOKEN_T_ABSTRACT',  285);
  define('TOKEN_T_NATIVE',  286);
  define('TOKEN_T_CLASS',  300);
  define('TOKEN_T_INTERFACE',  301);
  define('TOKEN_T_ENUM',  302);
  define('TOKEN_T_EXTENDS',  310);
  define('TOKEN_T_IMPLEMENTS',  311);
  define('TOKEN_T_OPERATOR',  320);
  define('TOKEN_T_THROWS',  321);
  define('TOKEN_T_PROPERTY',  330);
  define('TOKEN_T_VARIABLE',  340);
  define('TOKEN_T_RETURN',  341);
  define('TOKEN_T_TRY',  342);
  define('TOKEN_T_THROW',  343);
  define('TOKEN_T_CATCH',  344);
  define('TOKEN_T_FINALLY',  345);
  define('TOKEN_T_NEW',  346);
  define('TOKEN_T_FOR',  360);
  define('TOKEN_T_WHILE',  361);
  define('TOKEN_T_DO',  362);
  define('TOKEN_T_FOREACH',  363);
  define('TOKEN_T_AS',  364);
  define('TOKEN_T_BREAK',  365);
  define('TOKEN_T_CONTINUE',  366);
  define('TOKEN_T_IF',  370);
  define('TOKEN_T_ELSE',  371);
  define('TOKEN_T_SWITCH',  372);
  define('TOKEN_T_CASE',  373);
  define('TOKEN_T_DEFAULT',  374);
  define('TOKEN_T_INC',  402);
  define('TOKEN_T_DEC',  403);
  define('TOKEN_YY_ERRORCODE', 256);

  /**
   * Generated parser class
   *
   * @purpose  Parser implementation
   */
  class Parser extends AbstractParser {
    protected static $yyLhs= array(-1,
          0,     1,     8,     1,     3,     3,     5,     5,     6,     6, 
          9,     9,    11,    11,     7,     7,     7,    12,    12,    14, 
         14,    17,    17,    16,    16,    16,    15,    15,    13,    13, 
         22,    20,    26,    20,    24,    24,    21,    21,    28,    28, 
         29,    29,    23,    23,    25,    25,    25,    25,    25,    27, 
         27,    18,    18,    31,    30,    32,    30,    35,    30,    37, 
         30,    38,    30,    39,    30,    40,    30,    42,    30,    30, 
         33,    33,    34,    43,    34,    41,    41,    44,    44,    48, 
         47,    45,    45,    49,    46,    19,    19,    19,    51,    19, 
         52,    19,    53,    19,    19,    19,    19,    19,    19,    19, 
         19,    54,    54,    54,    54,    54,    54,    55,    55,    55, 
         55,    55,    55,    56,    56,    56,    56,    56,    50,    50, 
         58,    57,    57,    59,    57,    57,    36,    36,    60,    60, 
          4,     4,     4,    61,    61,    10,    10,     2,     2,    62, 
         62,    63,    63,    63,    63,    63,    63,    63, 
    );
    protected static $yyLen= array(2,
          1,     8,     0,     8,     1,     1,     0,     2,     0,     2, 
          0,     2,     0,     3,     0,     1,     1,     1,     2,     5, 
          6,     0,     1,     2,     4,     4,     0,     2,     1,     2, 
          0,     9,     0,     9,     1,     3,     0,     1,     1,     3, 
          2,     3,     0,     2,     1,     1,     1,     1,     1,     0, 
          1,     1,     2,     0,     4,     0,     7,     0,    10,     0, 
         11,     0,     6,     0,     7,     0,     6,     0,     4,     2, 
          1,     3,     0,     0,     3,     2,     1,     1,     2,     0, 
          9,     0,     1,     0,     5,     1,     1,     1,     0,     3, 
          0,     8,     0,     6,     3,     3,     3,     3,     2,     2, 
          5,     1,     1,     1,     1,     1,     1,     1,     1,     1, 
          1,     1,     1,     1,     1,     1,     1,     1,     0,     1, 
          0,     4,     2,     0,     6,     2,     0,     1,     1,     3, 
          1,     4,     3,     1,     3,     1,     3,     0,     1,     1, 
          2,     1,     1,     1,     1,     1,     1,     1, 
    );
    protected static $yyDefRed= array(0,
        142,   144,   143,   145,   147,   146,   148,     0,     1,     0, 
        139,     0,     5,     3,     6,     0,   141,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,   135, 
          8,     0,     0,   133,     0,     0,    12,     0,    10,     0, 
          0,   132,     0,     0,    16,    17,     0,     0,     0,   137, 
          0,     0,     0,     4,     0,    19,     0,    30,     2,    45, 
         46,    47,    48,    49,     0,     0,     0,     0,     0,     0, 
         33,     0,     0,    31,     0,     0,     0,     0,    24,     0, 
         23,     0,     0,     0,    88,    87,    89,    91,     0,     0, 
         20,     0,     0,    38,     0,     0,    54,     0,    68,    58, 
         62,    64,    60,    56,     0,     0,     0,    21,     0,    93, 
          0,     0,     0,   102,   114,   115,   116,   117,   118,     0, 
        103,   104,   105,   106,   107,   108,   109,   110,   111,   112, 
        113,    99,   100,     0,     0,     0,     0,    41,     0,     0, 
         25,     0,    66,     0,     0,     0,     0,     0,     0,    26, 
         70,    53,     0,     0,   121,     0,    90,     0,     0,    95, 
          0,     0,     0,     0,    42,     0,     0,    40,     0,     0, 
          0,     0,     0,     0,    71,     0,     0,     0,     0,     0, 
          0,   128,     0,     0,     0,     0,     0,    44,     0,    35, 
         34,    55,    51,     0,    69,     0,     0,     0,     0,     0, 
          0,    32,     0,     0,     0,   124,     0,     0,     0,     0, 
          0,     0,    72,     0,     0,     0,   130,    94,   122,     0, 
          0,    36,    80,    84,    67,     0,    77,     0,     0,    63, 
          0,     0,     0,     0,     0,     0,     0,     0,    76,    83, 
         79,     0,    65,     0,    74,    57,   125,     0,    92,     0, 
          0,     0,     0,     0,    14,     0,     0,     0,     0,    75, 
          0,    85,    59,     0,     0,    61,     0,     0,    81, 
    );
    protected static $yyDgoto= array(8,
          9,    43,    16,    35,    25,    33,    44,    18,    29,    36, 
        236,    45,    46,    47,    76,    73,    82,   193,   106,    48, 
         93,    83,   167,   191,    65,    77,   194,    94,    95,   107, 
        142,   149,   176,   246,   145,   181,   148,   146,   147,   170, 
        225,   144,   254,   226,   239,   227,   228,   237,   238,   157, 
        111,   112,   154,   134,   135,   136,   158,   183,   220,   182, 
         21,    11,    12, 
    );
    protected static $yySindex = array(         -162,
          0,     0,     0,     0,     0,     0,     0,     0,     0,  -207, 
          0,  -162,     0,     0,     0,  -213,     0,  -213,    13,  -249, 
        -15,  -244,  -213,  -213,  -229,   -24,  -213,  -213,   -23,     0, 
          0,  -213,   -13,     0,    53,    81,     0,  -162,     0,  -162, 
       -213,     0,  -241,    23,     0,     0,  -162,  -162,    28,     0, 
        223,  -186,  -242,     0,  -222,     0,  -221,     0,     0,     0, 
          0,     0,     0,     0,   122,   -85,   130,   115,  -163,   -82, 
          0,  -110,   -85,     0,     1,   120,  -213,   141,     0,   676, 
          0,   133,  -213,   149,     0,     0,     0,     0,     1,   476, 
          0,   -26,   154,     0,   155,   159,     0,    78,     0,     0, 
          0,     0,     0,     0,    77,   151,   676,     0,   162,     0, 
        -90,  -213,   178,     0,     0,     0,     0,     0,     0,     1, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     1,     1,     1,  -132,     0,  -105,  -213, 
          0,     1,     0,     1,   188,   196,   581,   202,   205,     0, 
          0,     0,  -105,     1,     0,   -42,     0,   -90,   206,     0, 
        190,   476,   476,   476,     0,  -213,   -31,     0,   212,   676, 
        239,     1,     1,   676,     0,  -114,     1,     1,   -31,   268, 
        215,     0,     1,   218,   -90,     1,     1,     0,   676,     0, 
          0,     0,     0,   139,     0,   208,   295,   144,   237,   366, 
        378,     0,     1,   -90,   422,     0,   238,   -51,   158,  -199, 
          1,   581,     0,     1,   -60,   581,     0,     0,     0,     1, 
        164,     0,     0,     0,     0,   -57,     0,   -59,   230,     0, 
        449,   229,   -80,   251,  -162,   -90,   253,   171,     0,     0, 
          0,     1,     0,   233,     0,     0,     0,   172,     0,  -213, 
        676,   255,   -34,   581,     0,   -33,   179,   581,   262,     0, 
        267,     0,     0,   581,   186,     0,   676,   191,     0, 
    );
    protected static $yyRindex= array(         -128,
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,   -96,     0,     0,     0,     0,     0,     0,   854,  -120, 
        343,   194,     0,     0,   195,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     3,     0,     0,  -123,     0,  -123, 
          0,     0,     0,     0,     0,     0,  -108,  -111,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,   261,     0,     0, 
          0,     0,   263,     0,     0,     0,   280,     0,     0,     0, 
          0,     0,   280,    43,     0,     0,     0,     0,     0,   264, 
          0,     0,     0,     0,   283,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,   200,     0,     0,     0, 
         70,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     4,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     4,   285,     0,     0,     0,    97,     0,     0, 
          0,   -29,    16,   185,     0,     0,     0,     0,     0,   209, 
          0,   274,     0,   209,     0,     0,     0,     0,     0,    37, 
          0,     0,     0,   -37,   124,   285,     0,     0,   209,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,    70,     0,     0,     0,   670,     0,     0, 
        274,     0,     0,     0,     0,     0,     0,     0,     0,   285, 
        -10,     0,     0,     0,     0,   612,     0,   474,     0,     0, 
          0,     0,   650,     0,  -123,    70,     0,     0,     0,     0, 
          0,   285,     0,     0,     0,     0,     0,     0,     0,     0, 
        209,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,   209,     0,     0, 
    );
    protected static $yyGindex= array(0,
          0,    20,     0,   608,     0,     0,    -4,     0,     0,    14, 
          0,   292,   296,     0,     0,   270,     0,   -36,   909,     0, 
        265,     0,   193,   174,     0,     0,  -116,   221,     0,   198, 
          0,     0,   468,     0,     0,   -95,     0,     0,     0,     0, 
          0,     0,     0,   134,     0,   150,     0,     0,     0,  -164, 
          0,     0,     0,     0,     0,     0,  -115,     0,     0,   175, 
        352,   365,     0, 
    );
    protected static $yyTable = array(123,
        155,    15,     7,   123,   123,   123,   123,   123,   126,   123, 
        127,    96,    80,    29,    96,   137,    18,    67,    19,    10, 
        123,   123,   123,   123,   123,   123,    13,   190,    96,    96, 
         13,    13,    13,    13,    13,    49,    13,    19,    19,   218, 
         89,    37,   185,   105,    27,    39,    19,    13,    13,    13, 
         13,    13,    13,   123,    50,   123,    97,   198,    23,    97, 
         24,   136,    43,    96,   136,    28,    55,    57,    34,   185, 
        152,   249,   209,    97,    97,    26,   196,   129,    51,    86, 
         13,    32,    13,    86,    86,    86,    86,    86,    52,    86, 
        207,   189,    13,    14,    15,   129,    41,    68,    51,    38, 
         86,    86,    86,    86,    86,    86,   119,    52,    97,    40, 
        119,   119,   119,   119,   119,   229,   119,     1,     2,     3, 
          4,     5,     6,     7,   234,   136,    43,   119,   119,   119, 
        119,   119,   119,   120,   257,    86,   138,   120,   120,   120, 
        120,   120,    42,   120,   223,   224,   252,    54,   138,    78, 
        268,   138,    59,    66,   120,   120,   120,   120,   120,   120, 
        126,    71,   119,   140,   126,   126,   126,   126,   126,    74, 
        126,   138,   138,   138,    72,    75,    68,    67,    91,   188, 
         96,   126,   126,   126,   126,   126,   126,   119,   110,   120, 
          7,   108,   117,   115,   139,   116,   138,   118,   140,   141, 
        143,   150,   153,   140,   140,   140,   138,   165,   138,   151, 
        126,   114,   127,   120,   119,   166,   126,   184,   160,   117, 
        115,   138,   116,   140,   118,    98,   119,   172,    98,    79, 
        248,   117,   115,   140,   116,   173,   118,   126,   114,   127, 
        120,   177,    98,    98,   178,   186,   199,   187,   119,   126, 
        114,   127,   120,   117,   115,   204,   116,   206,   118,    64, 
         84,    85,    86,   210,    62,    60,   211,    61,   213,    63, 
        192,   126,   114,   127,   120,   119,   214,    98,   221,   232, 
        117,   115,   222,   116,   223,   118,   235,   224,   242,   244, 
        245,   247,   250,   251,   253,   258,   255,   195,   126,   114, 
        127,   120,   264,   262,   119,   259,   261,   265,   267,   117, 
        115,   203,   116,   138,   118,   269,    11,     9,   156,    27, 
         37,    22,    28,    39,    52,   127,   123,   126,   114,   127, 
        120,   119,   127,    50,    96,   212,   117,   115,    56,   116, 
         87,   118,    81,    58,   175,   179,    88,   109,   129,   128, 
        132,   133,   202,    13,   126,   114,   127,   120,   130,   131, 
        168,   241,   123,   123,   123,   123,   123,   123,   123,   123, 
        123,   123,   123,   123,    30,   240,    17,   217,     0,    97, 
          0,     0,   131,     0,   131,     0,   131,     0,     0,    13, 
         13,    13,    13,    13,    13,    13,    13,    13,    13,    13, 
         13,   131,   119,     0,   131,     0,    86,   117,   115,   175, 
        116,     0,   118,   175,   119,     0,     0,     0,   216,   117, 
        115,     0,   116,     0,   118,   126,   114,   127,   120,     0, 
          0,     0,     0,   119,     0,     0,     0,   126,   114,   127, 
        120,     0,    86,    86,    86,    86,    86,    86,    86,    86, 
         86,   175,    86,    86,     0,   175,     0,     0,   119,     0, 
        120,   175,     0,   117,   115,   131,   116,     0,   118,   119, 
        119,   119,   119,   119,   119,   119,   119,   119,     0,   119, 
        119,   126,   114,   127,   120,   119,     0,   126,     0,   243, 
        117,   115,     0,   116,     0,   118,   120,   120,   120,   120, 
        120,   120,   120,   120,   120,     0,   120,   120,   126,   114, 
        127,   120,   119,    78,   219,     0,     0,   117,   115,     0, 
        116,     0,   118,   126,   126,   126,   126,   126,   126,   126, 
        126,   126,     0,   126,   126,   126,   114,   127,   120,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,    98,     0, 
        129,   128,   132,   133,   121,   122,   123,   124,   125,     0, 
        130,   131,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,   129,   128,   132, 
        133,   121,   122,   123,   124,   125,     0,   130,   131,   129, 
        128,   132,   133,   121,   122,   123,   124,   125,    78,   130, 
        131,     0,   131,     0,     0,     0,     0,     0,     0,     0, 
          0,   129,   128,   132,   133,   121,   122,   123,   124,   125, 
         89,   130,   131,    20,     0,    22,     0,     0,     0,     0, 
          0,    31,     0,     0,     0,     0,     0,     0,   129,   128, 
        132,   133,   121,   122,   123,   124,   125,     0,   130,   131, 
         53,    82,   131,   131,     0,     0,     0,     0,     0,     0, 
          0,     0,    69,     0,    70,     0,     0,   129,   128,   132, 
        133,   121,   122,   123,   124,   125,     0,   130,   131,   230, 
          0,     0,   131,   233,    92,     0,     0,     0,     0,    73, 
         92,     0,     0,     0,   129,   128,   132,   133,   121,   122, 
        123,   124,   125,   174,   130,   131,   101,     0,     0,     0, 
        101,   101,   101,   101,   101,    89,   101,     0,     0,   159, 
          0,   260,     0,     0,     0,   263,     0,   101,   101,   215, 
        101,   266,   101,    78,    78,    78,    82,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,    92,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,   101,     0,     0,   129,   128,   132,   133,   121, 
        122,   123,   124,   125,    73,   130,   131,   129,   128,   132, 
        133,   121,   122,   123,   124,   125,     0,   130,   131,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,    78,    78,    78,    78,     0,    78,    78, 
          0,   129,   128,   132,   133,   121,   122,   123,   124,   125, 
          0,   130,   131,    78,    78,    78,    78,     0,     0,     0, 
         84,    85,    86,    78,    78,     0,     0,     0,   129,   128, 
        132,   133,   121,   122,   123,   124,   125,   256,   130,   131, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    82,    82,    82,     0,   129,   128,   132,   133,   121, 
        122,   123,   124,   125,     0,   130,   131,     0,     0,     0, 
          0,     0,     0,   134,     0,   134,     0,   134,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    73, 
         73,    73,   134,   134,     0,   134,     0,     0,     0,     0, 
         87,    97,    98,    99,     0,     0,    88,     0,     0,     0, 
          0,     0,     0,     0,     0,    84,    85,    86,     0,     0, 
        100,   101,   102,   103,   134,     0,     0,     0,     0,     0, 
        104,    82,    82,    82,    82,     0,     0,    82,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,    82,    82,    82,    82,     0,   134,     0,     0,     0, 
          0,    82,    82,    90,     0,     0,     0,     0,     0,    73, 
         73,    73,    73,     0,     0,    73,     0,   113,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,    73, 
         73,    73,    73,     0,     0,    87,    97,    98,    99,    73, 
          0,    88,     0,     0,     0,     0,     0,     0,   161,     0, 
          0,     0,     0,   101,     0,   100,   101,   102,   103,     0, 
          0,     0,   162,   163,   164,   104,     0,     0,     0,     0, 
        169,     0,   171,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,   180,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,   101,   101,   101,   101,   101,     0,     0, 
        180,   197,     0,     0,     0,   200,   201,     0,     0,     0, 
          0,   205,     0,     0,   180,   208,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,   180,     0,   134,     0,     0,     0,     0,     0,   180, 
          0,     0,   231,     0,     0,     0,     0,     0,   180,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
        180,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,   134,   134,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,     0,     0,     0,     0,     0,     0,     0, 
          0,     0,     0,   134, 
    );
    protected static $yyCheck = array(37,
         91,   125,   123,    41,    42,    43,    44,    45,    60,    47, 
         62,    41,   123,   125,    44,    42,   125,   260,   260,     0, 
         58,    59,    60,    61,    62,    63,    37,    59,    58,    59, 
         41,    42,    43,    44,    45,    40,    47,   260,   260,   204, 
         40,    28,   158,    80,    60,    32,   260,    58,    59,    60, 
         61,    62,    63,    91,    41,    93,    41,   174,    46,    44, 
        310,    59,    59,    93,    62,   310,    47,    48,    93,   185, 
        107,   236,   189,    58,    59,    91,   172,    41,   320,    37, 
         91,   311,    93,    41,    42,    43,    44,    45,   330,    47, 
        186,   123,   300,   301,   302,    59,    44,   340,   320,   123, 
         58,    59,    60,    61,    62,    63,    37,   330,    93,   123, 
         41,    42,    43,    44,    45,   211,    47,   280,   281,   282, 
        283,   284,   285,   286,   220,   123,   123,    58,    59,    60, 
         61,    62,    63,    37,   251,    93,   260,    41,    42,    43, 
         44,    45,    62,    47,   344,   345,   242,   125,   260,   260, 
        267,   260,   125,   340,    58,    59,    60,    61,    62,    63, 
         37,    40,    93,   260,    41,    42,    43,    44,    45,    40, 
         47,   300,   301,   302,   260,    61,   340,   260,    59,   166, 
         40,    58,    59,    60,    61,    62,    63,    37,    40,    93, 
        311,    59,    42,    43,    41,    45,   320,    47,    44,    41, 
        123,   125,    41,   300,   301,   302,   330,   340,   320,    59, 
         60,    61,    62,    63,    37,   321,    93,   260,    41,    42, 
         43,   330,    45,   320,    47,    41,    37,    40,    44,   340, 
        235,    42,    43,   330,    45,    40,    47,    60,    61,    62, 
         63,    40,    58,    59,    40,    40,   361,    58,    37,    60, 
         61,    62,    63,    42,    43,    41,    45,    40,    47,    37, 
        260,   261,   262,   125,    42,    43,    59,    45,   125,    47, 
         59,    60,    61,    62,    63,    37,    40,    93,    41,   340, 
         42,    43,   125,    45,   344,    47,   123,   345,    59,    61, 
        371,    41,    40,   123,    62,    41,   125,    59,    60,    61, 
         62,    63,    41,   125,    37,   340,   340,    41,   123,    42, 
         43,    44,    45,   340,    47,   125,   123,   123,   409,    59, 
         41,    59,    59,    41,   125,    41,   364,    60,    61,    62, 
         63,    37,    59,   125,   364,    41,    42,    43,    47,    45, 
        340,    47,    73,    48,   147,   153,   346,    83,   400,   401, 
        402,   403,   179,   364,    60,    61,    62,    63,   410,   411, 
        140,   228,   400,   401,   402,   403,   404,   405,   406,   407, 
        408,   409,   410,   411,    23,   226,    12,   203,    -1,   364, 
         -1,    -1,    40,    -1,    42,    -1,    44,    -1,    -1,   400, 
        401,   402,   403,   404,   405,   406,   407,   408,   409,   410, 
        411,    59,    37,    -1,    62,    -1,   364,    42,    43,   212, 
         45,    -1,    47,   216,    37,    -1,    -1,    -1,    41,    42, 
         43,    -1,    45,    -1,    47,    60,    61,    62,    63,    -1, 
         -1,    -1,    -1,   364,    -1,    -1,    -1,    60,    61,    62, 
         63,    -1,   400,   401,   402,   403,   404,   405,   406,   407, 
        408,   254,   410,   411,    -1,   258,    -1,    -1,    37,    -1, 
        364,   264,    -1,    42,    43,   123,    45,    -1,    47,   400, 
        401,   402,   403,   404,   405,   406,   407,   408,    -1,   410, 
        411,    60,    61,    62,    63,    37,    -1,   364,    -1,    41, 
         42,    43,    -1,    45,    -1,    47,   400,   401,   402,   403, 
        404,   405,   406,   407,   408,    -1,   410,   411,    60,    61, 
         62,    63,    37,    40,    93,    -1,    -1,    42,    43,    -1, 
         45,    -1,    47,   400,   401,   402,   403,   404,   405,   406, 
        407,   408,    -1,   410,   411,    60,    61,    62,    63,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   364,    -1, 
        400,   401,   402,   403,   404,   405,   406,   407,   408,    -1, 
        410,   411,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,   400,   401,   402, 
        403,   404,   405,   406,   407,   408,    -1,   410,   411,   400, 
        401,   402,   403,   404,   405,   406,   407,   408,   125,   410, 
        411,    -1,   260,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,   400,   401,   402,   403,   404,   405,   406,   407,   408, 
         40,   410,   411,    16,    -1,    18,    -1,    -1,    -1,    -1, 
         -1,    24,    -1,    -1,    -1,    -1,    -1,    -1,   400,   401, 
        402,   403,   404,   405,   406,   407,   408,    -1,   410,   411, 
         43,    40,   310,   311,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    55,    -1,    57,    -1,    -1,   400,   401,   402, 
        403,   404,   405,   406,   407,   408,    -1,   410,   411,   212, 
         -1,    -1,   340,   216,    77,    -1,    -1,    -1,    -1,    40, 
         83,    -1,    -1,    -1,   400,   401,   402,   403,   404,   405, 
        406,   407,   408,   123,   410,   411,    37,    -1,    -1,    -1, 
         41,    42,    43,    44,    45,    40,    47,    -1,    -1,   112, 
         -1,   254,    -1,    -1,    -1,   258,    -1,    58,    59,   364, 
         61,   264,    63,   260,   261,   262,   125,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,   140,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    93,    -1,    -1,   400,   401,   402,   403,   404, 
        405,   406,   407,   408,   125,   410,   411,   400,   401,   402, 
        403,   404,   405,   406,   407,   408,    -1,   410,   411,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,   340,   341,   342,   343,    -1,   345,   346, 
         -1,   400,   401,   402,   403,   404,   405,   406,   407,   408, 
         -1,   410,   411,   360,   361,   362,   363,    -1,    -1,    -1, 
        260,   261,   262,   370,   371,    -1,    -1,    -1,   400,   401, 
        402,   403,   404,   405,   406,   407,   408,   250,   410,   411, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,   260,   261,   262,    -1,   400,   401,   402,   403,   404, 
        405,   406,   407,   408,    -1,   410,   411,    -1,    -1,    -1, 
         -1,    -1,    -1,    40,    -1,    42,    -1,    44,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   260, 
        261,   262,    59,    60,    -1,    62,    -1,    -1,    -1,    -1, 
        340,   341,   342,   343,    -1,    -1,   346,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,   260,   261,   262,    -1,    -1, 
        360,   361,   362,   363,    91,    -1,    -1,    -1,    -1,    -1, 
        370,   340,   341,   342,   343,    -1,    -1,   346,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,   360,   361,   362,   363,    -1,   123,    -1,    -1,    -1, 
         -1,   370,   371,    75,    -1,    -1,    -1,    -1,    -1,   340, 
        341,   342,   343,    -1,    -1,   346,    -1,    89,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,   360, 
        361,   362,   363,    -1,    -1,   340,   341,   342,   343,   370, 
         -1,   346,    -1,    -1,    -1,    -1,    -1,    -1,   120,    -1, 
         -1,    -1,    -1,   364,    -1,   360,   361,   362,   363,    -1, 
         -1,    -1,   134,   135,   136,   370,    -1,    -1,    -1,    -1, 
        142,    -1,   144,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,   154,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,   404,   405,   406,   407,   408,    -1,    -1, 
        172,   173,    -1,    -1,    -1,   177,   178,    -1,    -1,    -1, 
         -1,   183,    -1,    -1,   186,   187,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,   203,    -1,   260,    -1,    -1,    -1,    -1,    -1,   211, 
         -1,    -1,   214,    -1,    -1,    -1,    -1,    -1,   220,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
        242,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,   310,   311,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1,    -1, 
         -1,    -1,    -1,   340, 
    );
    protected static $yyFinal= 8;
    protected static $yyName= array(    
      'end-of-file', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, "'!'", NULL, NULL, NULL, "'%'", NULL, 
      NULL, "'('", "')'", "'*'", "'+'", "','", "'-'", "'.'", "'/'", NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, "':'", "';'", "'<'", "'='", "'>'", 
      "'?'", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, "'['", NULL, "']'", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, "'{'", NULL, "'}'", NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, 'T_WORD', 'T_STRING', 'T_NUMBER', NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      'T_PUBLIC', 'T_PRIVATE', 'T_PROTECTED', 'T_STATIC', 'T_FINAL', 
      'T_ABSTRACT', 'T_NATIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, 'T_CLASS', 'T_INTERFACE', 'T_ENUM', NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, 'T_EXTENDS', 'T_IMPLEMENTS', NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, 'T_OPERATOR', 'T_THROWS', NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, 'T_PROPERTY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, 'T_VARIABLE', 'T_RETURN', 'T_TRY', 'T_THROW', 'T_CATCH', 'T_FINALLY', 
      'T_NEW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, 'T_FOR', 'T_WHILE', 'T_DO', 'T_FOREACH', 'T_AS', 'T_BREAK', 
      'T_CONTINUE', NULL, NULL, NULL, 'T_IF', 'T_ELSE', 'T_SWITCH', 'T_CASE', 
      'T_DEFAULT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
      'T_GE', 'T_SE', 'T_INC', 'T_DEC', 'T_ADD_EQUAL', 'T_SUB_EQUAL', 
      'T_MUL_EQUAL', 'T_DIV_EQUAL', 'T_MOD_EQUAL', 'T_OBJECT_OPERATOR', 
      'T_EQUALS', 'T_NOT_EQUALS', 
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

    case 2:  #line 105 "grammar/xp.jay"
    {
        $yyVals[-6+$yyTop]->modifiers= $yyVals[-7+$yyTop];
        $yyVals[-6+$yyTop]->name= $yyVals[-5+$yyTop];
        $yyVals[-6+$yyTop]->parent= $yyVals[-4+$yyTop];
        $yyVals[-6+$yyTop]->implements= $yyVals[-3+$yyTop];
        $yyVals[-6+$yyTop]->body= $yyVals[-1+$yyTop];
        $yyVal= $yyVals[-6+$yyTop];
      } break;

    case 3:  #line 113 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new InterfaceNode()); } break;

    case 4:  #line 113 "grammar/xp.jay"
    {
        $yyVals[-6+$yyTop]->modifiers= $yyVals[-7+$yyTop];
        $yyVals[-6+$yyTop]->name= $yyVals[-4+$yyTop];
        $yyVals[-6+$yyTop]->parents= $yyVals[-3+$yyTop];
        $yyVals[-6+$yyTop]->body= $yyVals[-1+$yyTop];
        $yyVal= $yyVals[-6+$yyTop];
      } break;

    case 5:  #line 123 "grammar/xp.jay"
    { $yyVal= $yyLex->create(new ClassNode()); } break;

    case 6:  #line 124 "grammar/xp.jay"
    { $yyVal= $yyLex->create(new EnumNode()); } break;

    case 7:  #line 128 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 8:  #line 129 "grammar/xp.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 9:  #line 133 "grammar/xp.jay"
    { $yyVal= array(); } break;

    case 10:  #line 134 "grammar/xp.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 11:  #line 138 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 12:  #line 139 "grammar/xp.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 13:  #line 143 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 14:  #line 144 "grammar/xp.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 15:  #line 148 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 16:  #line 149 "grammar/xp.jay"
    { $yyVal['fields']= $yyVals[0+$yyTop]; } break;

    case 17:  #line 150 "grammar/xp.jay"
    { $yyVal['methods']= $yyVals[0+$yyTop]; } break;

    case 18:  #line 156 "grammar/xp.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 19:  #line 157 "grammar/xp.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 20:  #line 161 "grammar/xp.jay"
    { $yyVal= $yyLex->create(new FieldNode());
        $yyVal->modifiers= $yyVals[-4+$yyTop];
        $yyVal->type= $yyVals[-3+$yyTop];
        $yyVal->name= $yyVals[-2+$yyTop];
        $yyVal->initialization= $yyVals[-1+$yyTop];
      } break;

    case 21:  #line 167 "grammar/xp.jay"
    { $yyVal= $yyLex->create(new PropertyNode());
        $yyVal->modifiers= $yyVals[-5+$yyTop];
        $yyVal->name= $yyVals[-3+$yyTop];
        $gs= array_merge(array('get' => NULL, 'set' => NULL), $yyVals[-2+$yyTop], $yyVals[-1+$yyTop]);
        $yyVal->get= $gs['get'];
        $yyVal->set= $gs['set'];
      } break;

    case 22:  #line 177 "grammar/xp.jay"
    { $yyVal= array(); } break;

    case 24:  #line 182 "grammar/xp.jay"
    { $yyVal= array($yyVals[-1+$yyTop] => $yyVals[0+$yyTop]); } break;

    case 25:  #line 183 "grammar/xp.jay"
    { $yyVal= array($yyVals[-3+$yyTop] => $yyVals[-2+$yyTop]); } break;

    case 26:  #line 184 "grammar/xp.jay"
    { $yyVal= array($yyVals[-3+$yyTop] => $yyVals[-1+$yyTop]); } break;

    case 27:  #line 188 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 28:  #line 189 "grammar/xp.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 29:  #line 195 "grammar/xp.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 30:  #line 196 "grammar/xp.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 31:  #line 200 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new MethodNode()); } break;

    case 32:  #line 200 "grammar/xp.jay"
    {
        $yyVals[-5+$yyTop]->modifiers= $yyVals[-8+$yyTop];
        $yyVals[-5+$yyTop]->returns= $yyVals[-7+$yyTop];
        $yyVals[-5+$yyTop]->name= $yyVals[-6+$yyTop];
        $yyVals[-5+$yyTop]->arguments= $yyVals[-3+$yyTop];
        $yyVals[-5+$yyTop]->throws= $yyVals[-1+$yyTop];
        $yyVals[-5+$yyTop]->body= $yyVals[0+$yyTop];
        $yyVal= $yyVals[-5+$yyTop];
      } break;

    case 33:  #line 209 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new OperatorNode()); } break;

    case 34:  #line 209 "grammar/xp.jay"
    {
        $yyVals[-5+$yyTop]->modifiers= $yyVals[-8+$yyTop];
        $yyVals[-5+$yyTop]->symbol= $yyVals[-6+$yyTop];
        $yyVals[-5+$yyTop]->arguments= $yyVals[-3+$yyTop];
        $yyVals[-5+$yyTop]->throws= $yyVals[-1+$yyTop];
        $yyVals[-5+$yyTop]->body= $yyVals[0+$yyTop];
        $yyVal= $yyVals[-5+$yyTop];
    } break;

    case 35:  #line 220 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 36:  #line 221 "grammar/xp.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 37:  #line 225 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 38:  #line 226 "grammar/xp.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 39:  #line 230 "grammar/xp.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 40:  #line 231 "grammar/xp.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 41:  #line 235 "grammar/xp.jay"
    { $yyVal= array('name' => $yyVals[0+$yyTop], 'type' => $yyVals[-1+$yyTop]); } break;

    case 42:  #line 236 "grammar/xp.jay"
    { $yyVal= array('name' => $yyVals[0+$yyTop], 'type' => $yyVals[-2+$yyTop], 'vararg' => TRUE); } break;

    case 43:  #line 240 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 44:  #line 241 "grammar/xp.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 50:  #line 257 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 52:  #line 262 "grammar/xp.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 53:  #line 263 "grammar/xp.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 54:  #line 267 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new ReturnNode()); } break;

    case 55:  #line 267 "grammar/xp.jay"
    { 
        $yyVal->expression= $yyVals[-1+$yyTop];
      } break;

    case 56:  #line 270 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new IfNode()); } break;

    case 57:  #line 270 "grammar/xp.jay"
    {
        $yyVals[-6+$yyTop]->condition= $yyVals[-3+$yyTop];
        $yyVals[-6+$yyTop]->statements= $yyVals[-1+$yyTop];
        $yyVals[-6+$yyTop]->otherwise= $yyVals[0+$yyTop];
      } break;

    case 58:  #line 275 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new ForNode()); } break;

    case 59:  #line 275 "grammar/xp.jay"
    {
        $yyVals[-9+$yyTop]->initialization= $yyVals[-6+$yyTop];
        $yyVals[-9+$yyTop]->condition= $yyVals[-4+$yyTop];
        $yyVals[-9+$yyTop]->loop= $yyVals[-2+$yyTop];
        $yyVals[-9+$yyTop]->statements= $yyVals[0+$yyTop];
      } break;

    case 60:  #line 281 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new ForeachNode()); } break;

    case 61:  #line 281 "grammar/xp.jay"
    {
        $yyVals[-10+$yyTop]->expression= $yyVals[-7+$yyTop];
        $yyVals[-10+$yyTop]->statements= $yyVals[0+$yyTop];
      } break;

    case 62:  #line 285 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new WhileNode()); } break;

    case 63:  #line 285 "grammar/xp.jay"
    {
        $yyVals[-5+$yyTop]->expression= $yyVals[-2+$yyTop];
        $yyVals[-5+$yyTop]->statements= $yyVals[0+$yyTop];
      } break;

    case 64:  #line 289 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new DoNode()); } break;

    case 65:  #line 289 "grammar/xp.jay"
    {
        $yyVals[-6+$yyTop]->expression= $yyVals[-1+$yyTop];
        $yyVals[-6+$yyTop]->statements= $yyVals[-4+$yyTop];
      } break;

    case 66:  #line 293 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new TryNode()); } break;

    case 67:  #line 293 "grammar/xp.jay"
    { 
        $yyVals[-4+$yyTop]->statements= NULL; /* XXX $4;*/
        $yyVals[-4+$yyTop]->handling= $yyVals[0+$yyTop];
        $yyVal= $yyVals[-4+$yyTop]; 
      } break;

    case 68:  #line 298 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new ThrowNode()); } break;

    case 69:  #line 298 "grammar/xp.jay"
    { /* Throw statement */ 
        $yyVals[-3+$yyTop]->expression= NULL; /*/ XXX $3;*/
      } break;

    case 71:  #line 305 "grammar/xp.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 72:  #line 306 "grammar/xp.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 73:  #line 310 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 74:  #line 311 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new ElseNode()); } break;

    case 75:  #line 311 "grammar/xp.jay"
    { $yyVals[-2+$yyTop]->statements= $yyVals[0+$yyTop]; } break;

    case 76:  #line 316 "grammar/xp.jay"
    { $yyVals[0+$yyTop] === NULL || $yyVal= array_merge($yyVals[-1+$yyTop], array($yyVals[0+$yyTop])); } break;

    case 77:  #line 317 "grammar/xp.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 78:  #line 321 "grammar/xp.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 79:  #line 322 "grammar/xp.jay"
    { $yyVal= array_merge(array($yyVals[-1+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 80:  #line 326 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new CatchNode()); } break;

    case 81:  #line 326 "grammar/xp.jay"
    {
        $yyVals[-8+$yyTop]->type= $yyVals[-5+$yyTop];
        $yyVals[-8+$yyTop]->variable= $yyVals[-4+$yyTop];
        $yyVals[-8+$yyTop]->statements= NULL; /* XXX $8;*/
      } break;

    case 82:  #line 334 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 84:  #line 339 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new FinallyNode()); } break;

    case 85:  #line 339 "grammar/xp.jay"
    {
        $yyVals[-4+$yyTop]->statements= NULL; /* XXX $4;*/
      } break;

    case 86:  #line 347 "grammar/xp.jay"
    { /* XXX Constant */ } break;

    case 87:  #line 348 "grammar/xp.jay"
    { $yyVal= $yyLex->create(new NumberNode()); $yyVal->value= $yyVals[0+$yyTop]; } break;

    case 88:  #line 349 "grammar/xp.jay"
    { $yyVal= $yyLex->create(new StringNode()); $yyVal->value= $yyVals[0+$yyTop]; } break;

    case 89:  #line 350 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new VariableNode(array('name' => $yyVals[0+$yyTop]))); } break;

    case 90:  #line 350 "grammar/xp.jay"
    {
      $yyVals[0+$yyTop] && $yyVals[-2+$yyTop]->chained= $yyVals[0+$yyTop];
    } break;

    case 91:  #line 353 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new InstanceCreationNode()); } break;

    case 92:  #line 353 "grammar/xp.jay"
    { 
      $yyVals[-7+$yyTop]->type= $yyVals[-5+$yyTop];
      $yyVals[-7+$yyTop]->parameters= $yyVals[-3+$yyTop];
      $yyVals[0+$yyTop] && $yyVals[-7+$yyTop]->chained= $yyVals[0+$yyTop];
    } break;

    case 93:  #line 358 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new InvocationNode()); } break;

    case 94:  #line 358 "grammar/xp.jay"
    { 
      $yyVals[-4+$yyTop]->name= $yyVals[-5+$yyTop];
      $yyVals[-4+$yyTop]->parameters= $yyVals[-2+$yyTop];
      $yyVals[0+$yyTop] && $yyVals[-4+$yyTop]->chained= $yyVals[0+$yyTop];
      $yyVal= $yyVals[-4+$yyTop];
    } break;

    case 95:  #line 364 "grammar/xp.jay"
    { $yyVal= $yyVals[-1+$yyTop]; } break;

    case 96:  #line 365 "grammar/xp.jay"
    { 
      $yyVal= $yyLex->create(new AssignmentNode()); 
      $yyVal->variable= $yyVals[-2+$yyTop]; 
      $yyVal->expression= $yyVals[0+$yyTop]; 
      $yyVal->op= $yyVals[-1+$yyTop];
    } break;

    case 97:  #line 371 "grammar/xp.jay"
    { 
      $yyVal= $yyLex->create(new ComparisonNode()); 
      $yyVal->lhs= $yyVals[-2+$yyTop]; 
      $yyVal->rhs= $yyVals[0+$yyTop]; 
      $yyVal->op= $yyVals[-1+$yyTop]; 
    } break;

    case 98:  #line 377 "grammar/xp.jay"
    { 
      $yyVal= $yyLex->create(new BinaryOpNode()); 
      $yyVal->lhs= $yyVals[-2+$yyTop]; 
      $yyVal->rhs= $yyVals[0+$yyTop]; 
      $yyVal->op= $yyVals[-1+$yyTop]; 
    } break;

    case 99:  #line 383 "grammar/xp.jay"
    { /* XXX Post-Increment */ } break;

    case 100:  #line 384 "grammar/xp.jay"
    { /* XXX Post-Decrement */ } break;

    case 101:  #line 385 "grammar/xp.jay"
    { /* XXX Ternary */ } break;

    case 119:  #line 415 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 121:  #line 420 "grammar/xp.jay"
    { $yyVals[0+$yyTop]= $yyLex->create(new ArrayAccessNode()); } break;

    case 122:  #line 420 "grammar/xp.jay"
    { 
      $yyVals[-3+$yyTop]->offset= $yyVals[-1+$yyTop];
    } break;

    case 123:  #line 423 "grammar/xp.jay"
    {
      $yyVal= $yyLex->create(new VariableNode()); 
      $yyVal->name= $yyVals[0+$yyTop]; 
    } break;

    case 124:  #line 427 "grammar/xp.jay"
    { $yyVals[-2+$yyTop]= $yyLex->create(new InvocationNode()); } break;

    case 125:  #line 427 "grammar/xp.jay"
    { 
      $yyVals[-5+$yyTop]->name= $yyVals[-4+$yyTop];
      $yyVals[-5+$yyTop]->parameters= $yyVals[-1+$yyTop];
    } break;

    case 126:  #line 431 "grammar/xp.jay"
    { $yyVals[-1+$yyTop]->chained= $yyVals[0+$yyTop]; } break;

    case 127:  #line 435 "grammar/xp.jay"
    { $yyVal= NULL; } break;

    case 129:  #line 439 "grammar/xp.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 130:  #line 440 "grammar/xp.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 131:  #line 446 "grammar/xp.jay"
    { $yyVal= new TypeName($yyVals[0+$yyTop]); } break;

    case 132:  #line 447 "grammar/xp.jay"
    { $yyVal= new TypeName($yyVals[-3+$yyTop], $yyVals[-1+$yyTop]); } break;

    case 133:  #line 448 "grammar/xp.jay"
    { $yyVal= new TypeName($yyVals[-2+$yyTop].'[]'); } break;

    case 134:  #line 452 "grammar/xp.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 135:  #line 453 "grammar/xp.jay"
    { $yyVal= $yyVals[-2+$yyTop].'.'.$yyVals[0+$yyTop]; } break;

    case 136:  #line 457 "grammar/xp.jay"
    { $yyVal= array($yyVals[0+$yyTop]); } break;

    case 137:  #line 458 "grammar/xp.jay"
    { $yyVal= array_merge(array($yyVals[-2+$yyTop]), $yyVals[0+$yyTop]); } break;

    case 138:  #line 464 "grammar/xp.jay"
    { $yyVal= 0; } break;

    case 139:  #line 465 "grammar/xp.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 140:  #line 469 "grammar/xp.jay"
    { $yyVal= $yyVals[0+$yyTop]; } break;

    case 141:  #line 470 "grammar/xp.jay"
    { $yyVal= $yyVals[-1+$yyTop] | $yyVals[0+$yyTop]; } break;

    case 142:  #line 474 "grammar/xp.jay"
    { $yyVal= MODIFIER_PUBLIC; } break;

    case 143:  #line 475 "grammar/xp.jay"
    { $yyVal= MODIFIER_PROTECTED; } break;

    case 144:  #line 476 "grammar/xp.jay"
    { $yyVal= MODIFIER_PRIVATE; } break;

    case 145:  #line 477 "grammar/xp.jay"
    { $yyVal= MODIFIER_STATIC; } break;

    case 146:  #line 478 "grammar/xp.jay"
    { $yyVal= MODIFIER_ABSTRACT; } break;

    case 147:  #line 479 "grammar/xp.jay"
    { $yyVal= MODIFIER_FINAL; } break;

    case 148:  #line 480 "grammar/xp.jay"
    { $yyVal= MODIFIER_NATIVE; } break;
#line 1134 "-"
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
