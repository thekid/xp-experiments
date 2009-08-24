<?php
 /* This class is part of the XP framework
  *
  * $Id$
  */
  $package= 'xp.ide.source.parser';

  uses(
    'xp.ide.source.parser.Lexer',
    'xp.ide.source.parser.ClassFileParser'
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
%state S_COMMENT S_COMMENT_END S_INNERBLOCK S_ENCAPSED_S S_ENCAPSED_D
%ignorecase

LNUM=[0-9]+
DNUM=([0-9]*[\.][0-9]+)|([0-9]+[\.][0-9]*)
EXPONENT_DNUM=(({LNUM}|{DNUM})[eE][+-]?{LNUM})
HNUM="0x"[0-9a-fA-F]+
LABEL=([a-zA-Z_\x81-\xff][·a-zA-Z0-9_\x81-\xff]*)
TOKENS=[;:,.\[\]()|^&+-*/=%!~$<>?@]
NUMBER={LNUM}|{DNUM}|{EXPONENT_DNUM}|{HNUM}
VARIABLE=(\$+{LABEL})
WHITE_SPACE=([\ \n\r\t\f])+

%%

<YYINITIAL> {WHITE_SPACE} { }
<YYINITIAL> "<?php" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_TAG); }
<YYINITIAL> "?>" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_TAG); }
<YYINITIAL> "uses" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_USES); }
<YYINITIAL> "abstract" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_ABSTRACT); }
<YYINITIAL> "class" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLASS); }
<YYINITIAL> "extends" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_EXTENDS); }
<YYINITIAL> "implements" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_IMPLEMENTS); }
<YYINITIAL> {NUMBER} { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
<YYINITIAL> \{ { $this->yybegin(self::S_INNERBLOCK); $this->cnt= 0; return $this->createToken(ord($this->yytext())); }
<YYINITIAL> \} { return $this->createToken(ord($this->yytext())); }
<YYINITIAL> \" { $this->yybegin(self::S_ENCAPSED_D); $this->addBuffer($this->yytext()); }
<YYINITIAL> ' { $this->yybegin(self::S_ENCAPSED_S); $this->addBuffer($this->yytext()); }
<YYINITIAL> "/*" { $this->yybegin(self::S_COMMENT); return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_BCOMMENT); }
<YYINITIAL> {VARIABLE} { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_VARIABLE); }
<YYINITIAL> {LABEL} { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
<YYINITIAL> {TOKENS} { return $this->createToken(ord($this->yytext())); }

<S_INNERBLOCK> \{ { $this->addBuffer($this->yytext()); $this->cnt++; }
<S_INNERBLOCK> \} {
  if (--$this->cnt < 0) {
    $this->yy_buffer_index--;
    $this->yybegin(self::YYINITIAL);
    $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_INNERBLOCK, $this->getBuffer());
    $this->resetBuffer();
    return;
  } else {
    $this->addBuffer($this->yytext());
  }
}

<S_COMMENT> "*/" {
  $this->yy_buffer_index -= 2;
  $this->yybegin(self::S_COMMENT_END);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_BCOMMENT, $this->getBuffer());
  $this->resetBuffer();
  return;
}
<S_COMMENT_END> "*/" {
  $this->yybegin(self::YYINITIAL);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_BCOMMENT);
  return;
}

<S_ENCAPSED_D> \\\" { $this->addBuffer($this->yytext()); }
<S_ENCAPSED_S> \\' { $this->addBuffer($this->yytext()); }
<S_ENCAPSED_S> ' {
  $this->yybegin(self::YYINITIAL);
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
<S_ENCAPSED_D> \" {
  $this->yybegin(self::YYINITIAL);
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}
<S_COMMENT,S_INNERBLOCK,S_ENCAPSED_S,S_ENCAPSED_D> .|{WHITE_SPACE} {  $this->addBuffer($this->yytext()); }

