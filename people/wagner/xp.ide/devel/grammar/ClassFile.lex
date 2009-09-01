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

%full
%line
%char
%state S_BLOCKCOMMENT S_BLOCKCOMMENT_END S_INNERBLOCK S_ENCAPSED_S S_ENCAPSED_D
%state S_APIDOC S_APIDOC_DIRECTIVE S_APIDOC_END S_APIDOC_TEXT S_APIDOC_DIRECTIVE_TEXT
%state S_ANNOTATION
%ignorecase

LNUM=[0-9]+
DNUM=([0-9]*[\.][0-9]+)|([0-9]+[\.][0-9]*)
EXPONENT_DNUM=(({LNUM}|{DNUM})[eE][+-]?{LNUM})
HNUM="0x"[0-9a-fA-F]+
LABEL=([a-zA-Z_\x81-\xff][a-zA-Z0-9_\x81-\xff]*)
TOKENS=[;:,.\[\]()|^&+-*/=%!~$<>?@]
NUMBER={LNUM}|{DNUM}|{EXPONENT_DNUM}|{HNUM}
VARIABLE=(\$+{LABEL})
SPACE=([\ \t\f])
NL=\n\r|\r|\n
WHITE_SPACE=({NL}|{SPACE})+

%%

<YYINITIAL> {WHITE_SPACE} { }
<YYINITIAL> "<?php" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_TAG); }
<YYINITIAL> "?>" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_TAG); }
<YYINITIAL> "uses" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_USES); }
<YYINITIAL> "abstract" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_ABSTRACT); }
<YYINITIAL> "final" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_FINAL); }
<YYINITIAL> "class" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLASS); }
<YYINITIAL> "extends" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_EXTENDS); }
<YYINITIAL> "implements" { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_IMPLEMENTS); }
<YYINITIAL> {NUMBER} { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_NUMBER); }
<YYINITIAL> \{ { $this->pushState(self::S_INNERBLOCK); $this->cnt= 0; return $this->createToken(ord($this->yytext())); }
<YYINITIAL> \" { $this->pushState(self::S_ENCAPSED_D); $this->addBuffer($this->yytext()); }
<YYINITIAL> ' { $this->pushState(self::S_ENCAPSED_S); $this->addBuffer($this->yytext()); }
<YYINITIAL> "/*" { $this->pushState(self::S_BLOCKCOMMENT); return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_BCOMMENT); }
<YYINITIAL> "/**" { $this->pushState(self::S_APIDOC); return $this->createToken(xp·ide·source·parser·ClassFileParser::T_OPEN_APIDOC); }
<YYINITIAL> //.* {}
<YYINITIAL> "#[" { $this->pushState(self::S_ANNOTATION); return $this->createToken(xp·ide·source·parser·ClassFileParser::T_START_ANNOTATION); }
<YYINITIAL> {VARIABLE} { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_VARIABLE); }
<YYINITIAL> {LABEL} { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }

<S_INNERBLOCK> \{ { $this->addBuffer($this->yytext()); $this->cnt++; }
<S_INNERBLOCK> \} {
  if (--$this->cnt < 0) {
  $this->yypushback(1);
    $this->popState();
    $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_INNERBLOCK, $this->getBuffer());
    $this->resetBuffer();
    return;
  } else {
    $this->addBuffer($this->yytext());
  }
}

<S_ANNOTATION> {SPACE}+ {}
<S_ANNOTATION> {LABEL} { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_STRING); }
<S_ANNOTATION> @{LABEL} { return $this->createToken(xp·ide·source·parser·ClassFileParser::T_ANNOTATION); }
<S_ANNOTATION> ' { $this->pushState(self::S_ENCAPSED_S); $this->addBuffer($this->yytext()); }
<S_ANNOTATION> "]" {
  $this->popState();
  return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_ANNOTATION);
}

<S_APIDOC> {NL}{SPACE}+"*"{SPACE}*@ {
  $this->yypushback($this->yylength());
  $this->yybegin(self::S_APIDOC_DIRECTIVE);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_APIDOC, $this->getBuffer());
  $this->resetBuffer();
  return;
}
<S_APIDOC> {NL}{SPACE}+"*/" {
  $this->yypushback(2);
  $this->yybegin(self::S_APIDOC_END);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_APIDOC, $this->getBuffer());
  $this->resetBuffer();
  return;
}
<S_APIDOC> {NL}{SPACE}+"*"{SPACE}? {
  $this->addBuffer(PHP_EOL);
  $this->yybegin(self::S_APIDOC_TEXT);
}
<S_APIDOC_TEXT> [^{NL}]* {
  $this->addBuffer($this->yytext());
  $this->yybegin(self::S_APIDOC);
}
<S_APIDOC_DIRECTIVE> {NL}{SPACE}+\*{SPACE}*@ {
  $this->yybegin(self::S_APIDOC_DIRECTIVE_TEXT);
  $this->yypushback(1);
}
<S_APIDOC_DIRECTIVE_TEXT> .* {
  $this->yybegin(self::S_APIDOC_DIRECTIVE);
  return $this->createToken(xp·ide·source·parser·ClassFileParser::T_DIRECTIVE_APIDOC, $this->yytext());
}
<S_APIDOC_DIRECTIVE> {NL}{SPACE}+"*/" {
  $this->yypushback(2);
  $this->yybegin(self::S_APIDOC_END);
}
<S_APIDOC_END> "*/" {
  $this->popState(self::YYINITIAL);
  return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_APIDOC);
}

<S_BLOCKCOMMENT> "*/" {
  $this->yypushback(2);
  $this->yybegin(self::S_BLOCKCOMMENT_END);
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_CONTENT_BCOMMENT, $this->getBuffer());
  $this->resetBuffer();
  return;
}
<S_BLOCKCOMMENT_END> "*/" {
  $this->popState();
  return $this->createToken(xp·ide·source·parser·ClassFileParser::T_CLOSE_BCOMMENT);
}

<S_ENCAPSED_D> \\\" { $this->addBuffer($this->yytext()); }
<S_ENCAPSED_D> \" {
  $this->popState();
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}

<S_ENCAPSED_S> \\' { $this->addBuffer($this->yytext()); }
<S_ENCAPSED_S> ' {
  $this->popState();
  $this->addBuffer($this->yytext());
  $this->createToken(xp·ide·source·parser·ClassFileParser::T_ENCAPSED_STRING, $this->getBuffer());
  $this->resetBuffer();
  return;
}

<S_INNERBLOCK,S_ENCAPSED_D,S_ENCAPSED_S,S_BLOCKCOMMENT> .|{WHITE_SPACE} {  $this->addBuffer($this->yytext()); }
. {  return $this->createToken(ord($this->yytext())); }
