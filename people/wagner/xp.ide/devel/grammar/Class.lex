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

%full
%line
%char
%state S_ENCAPSED_S S_ENCAPSED_D S_METHOD_CONTENT
%ignorecase

LNUM=[0-9]+
DNUM=([0-9]*[\.][0-9]+)|([0-9]+[\.][0-9]*)
EXPONENT_DNUM=(({LNUM}|{DNUM})[eE][+-]?{LNUM})
HNUM="0x"[0-9a-fA-F]+
LABEL=([a-zA-Z_\x81-\xff][a-zA-Z0-9_\x81-\xff]*)
TOKENS=[;:,.\[\]()|^&+-*/=%!~$<>?@]
NUMBER={LNUM}|{DNUM}|{EXPONENT_DNUM}|{HNUM}
VARIABLE=(\$+{LABEL})
WHITE_SPACE=([\ \n\r\t\f])+

%%

<YYINITIAL> {WHITE_SPACE} { }
<YYINITIAL> "null" { return $this->createToken(xp·ide·source·parser·ClassParser::T_NULL); }
<YYINITIAL> "const" { return $this->createToken(xp·ide·source·parser·ClassParser::T_CONST); }
<YYINITIAL> "private" { return $this->createToken(xp·ide·source·parser·ClassParser::T_PRIVATE); }
<YYINITIAL> "protected" { return $this->createToken(xp·ide·source·parser·ClassParser::T_PROTECTED); }
<YYINITIAL> "public" { return $this->createToken(xp·ide·source·parser·ClassParser::T_PUBLIC); }
<YYINITIAL> "static" { return $this->createToken(xp·ide·source·parser·ClassParser::T_STATIC); }
<YYINITIAL> "array" { return $this->createToken(xp·ide·source·parser·ClassParser::T_ARRAY); }
<YYINITIAL> "null" { return $this->createToken(xp·ide·source·parser·ClassParser::T_NULL); }
<YYINITIAL> "true" { return $this->createToken(xp·ide·source·parser·ClassParser::T_BOOLEAN); }
<YYINITIAL> "false" { return $this->createToken(xp·ide·source·parser·ClassParser::T_BOOLEAN); }
<YYINITIAL> "function" { return $this->createToken(xp·ide·source·parser·ClassParser::T_FUNCTION); }
<YYINITIAL> "abstract" { return $this->createToken(xp·ide·source·parser·ClassParser::T_ABSTRACT); }
<YYINITIAL> "=>" { return $this->createToken(xp·ide·source·parser·ClassParser::T_DOUBLE_ARROW); }
<YYINITIAL> {NUMBER} { return $this->createToken(xp·ide·source·parser·ClassParser::T_NUMBER); }
<YYINITIAL> \{ { $this->yybegin(self::S_METHOD_CONTENT); $this->cnt= 0; return $this->createToken(ord($this->yytext())); }
<YYINITIAL> \" { $this->yybegin(self::S_ENCAPSED_D); $this->addBuffer($this->yytext()); }
<YYINITIAL> ' { $this->yybegin(self::S_ENCAPSED_S); $this->addBuffer($this->yytext()); }
<YYINITIAL> {VARIABLE} { return $this->createToken(xp·ide·source·parser·ClassParser::T_VARIABLE); }
<YYINITIAL> \}|{TOKENS} { return $this->createToken(ord($this->yytext())); }
<YYINITIAL> {LABEL} { return $this->createToken(xp·ide·source·parser·ClassParser::T_STRING); }

<S_METHOD_CONTENT> \{ { $this->addBuffer($this->yytext()); $this->cnt++; }
<S_METHOD_CONTENT> \} {
  if (--$this->cnt < 0) {
    $this->yy_buffer_index--;
    $this->yybegin(self::YYINITIAL);
    $this->createToken(xp·ide·source·parser·ClassParser::T_FUNCTION_BODY, $this->getBuffer());
    $this->resetBuffer();
    return;
  } else {
    $this->addBuffer($this->yytext());
  }
}

<S_ENCAPSED_D> \\\" { $this->addBuffer($this->yytext()); }
<S_ENCAPSED_S> \\' { $this->addBuffer($this->yytext()); }
<S_ENCAPSED_S> ' {
  $this->yybegin(self::YYINITIAL);
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
<S_ENCAPSED_D> \" {
  $this->yybegin(self::YYINITIAL);
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
<S_METHOD_CONTENT,S_ENCAPSED_D,S_ENCAPSED_S> .|{WHITE_SPACE} {  $this->addBuffer($this->yytext()); }

