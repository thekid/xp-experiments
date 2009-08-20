<?php
 /* This class is part of the XP framework
  *
  * $Id$
  */
  $package= 'xp.ide.source.parser';

  uses(
    'xp.ide.source.parser.Lexer',
    'xp.ide.source.parser.ClassParser'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */

%%

%line
%char
%state ENCAPSED
%state COMMENT

ALPHA=[A-Za-z_]
DIGIT=[0-9]
NUMBER=({DIGIT})+
WHITE_SPACE=([\ \n\r\t\f])+

%%

<YYINITIAL> 'const' { return xp·ide·source·parser·ClassParser::T_CONST; }
<YYINITIAL> "private" { return xp·ide·source·parser·ClassParser::T_PRIVATE; }
<YYINITIAL> 'protected' { return xp·ide·source·parser·ClassParser::T_PROTECTED; }
<YYINITIAL> 'public' { return xp·ide·source·parser·ClassParser::T_PUBLIC; }
<YYINITIAL> 'static' { return xp·ide·source·parser·ClassParser::T_STATIC; }
<YYINITIAL> 'array' { return xp·ide·source·parser·ClassParser::T_ARRAY; }
<YYINITIAL> 'null' { return xp·ide·source·parser·ClassParser::T_NULL; }
<YYINITIAL> 'true' { return xp·ide·source·parser·ClassParser::T_BOOLEAN; }
<YYINITIAL> 'false' { return xp·ide·source·parser·ClassParser::T_BOOLEAN; }
<YYINITIAL> {NUMBER} { return xp·ide·source·parser·ClassParser::T_NUMBER; }
<YYINITIAL> {WHITE_SPACE} { }
<YYINITIAL> "'" { $this->yybegin(self::ENCAPSED); }
<YYINITIAL> . { return ord($this->yytext()); }

<ENCAPSED> ("\'") { }
<ENCAPSED> "'" { $this->yybegin(self::YYINITIAL); }

