<?php
 /* This class is part of the XP framework
  *
  * $Id$
  */

  uses(
    'net.jaylex.JlexBase'
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
%state COMMENTS

ALPHA=[A-Za-z_]
DIGIT=[0-9]
ALPHA_NUMERIC={ALPHA}|{DIGIT}
IDENT={ALPHA}({ALPHA_NUMERIC})*
NUMBER=({DIGIT})+
WHITE_SPACE=([\ \n\r\t\f])+

%%

<YYINITIAL> {NUMBER} { return; }
<YYINITIAL> {WHITE_SPACE} { }
<YYINITIAL> "+"  { return; }
<YYINITIAL> "-"  { return; }
<YYINITIAL> "*"  { return; }
<YYINITIAL> "/"  { return; }
<YYINITIAL> ";"  { return; }
<YYINITIAL> "//" {
	  $this->yybegin(self::COMMENTS);
}
<COMMENTS> [^\n] {
}
<COMMENTS> [\n] {
	  $this->yybegin(self::YYINITIAL);
}
<YYINITIAL> . {
	  throw new XPException("bah!");
}
