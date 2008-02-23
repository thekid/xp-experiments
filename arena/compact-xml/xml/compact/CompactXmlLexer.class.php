<?php
/* This class is part of the XP framework's experiments
 *
 * $Id$ 
 */

  uses(
    'text.StringTokenizer', 
    'xml.compact.CompactXmlParser', 
    'text.parser.generic.AbstractLexer'
  );

  /**
   * Lexer for compact XML
   *
   * @see      xp://text.parser.generic.AbstractLexer
   * @purpose  Lexer
   */
  class CompactXmlLexer extends AbstractLexer {
    protected static
      $keywords  = array(
      );

    const 
      DELIMITERS = " ;,=<>(){}[]#\"\r\n";
      
    /**
     * Constructor
     *
     * @param   string input
     * @param   string source
     */
    function __construct($input, $source) {
      $this->tokenizer= new StringTokenizer($input, self::DELIMITERS, TRUE);
      $this->fileName= $source;
      $this->position= array(1, 1);   // Y, X
    }
  
    /**
     * Advance this 
     *
     * @return  bool
     */
    public function advance() {
      do {
        if (!$this->tokenizer->hasMoreTokens()) return FALSE;
        $token= $this->tokenizer->nextToken(self::DELIMITERS);
        
        // Check for whitespace
        if (FALSE !== strpos(" \n\r\t", $token)) {
          $l= substr_count($token, "\n");
          $this->position[1]= strlen($token) + ($l ? 1 : $this->position[1]);
          $this->position[0]+= $l;
          continue;
        }
        
        if ('"' == $token{0}) {
          $this->token= CompactXmlParser::T_STRING;
          $this->value= $this->tokenizer->nextToken('"');
          $this->tokenizer->nextToken('"');
        } else if ('<' == $token{0}) {
          $this->token= CompactXmlParser::T_TEXT;
          $this->value= $this->tokenizer->nextToken('>');
          $this->tokenizer->nextToken('>');
        } else if ('#' == $token{0}) {
          $this->token= CompactXmlParser::T_COMMENT;
          $this->value= ltrim($this->tokenizer->nextToken("\r\n"), ' ');
        } else if (isset(self::$keywords[$token])) {
          $this->token= self::$keywords[$token];
          $this->value= $token;
        } else if (FALSE !== strpos(self::DELIMITERS, $token) && 1 == strlen($token)) {
          $this->token= ord($token);
          $this->value= $token;
        } else if (preg_match('/^[0-9]+$/', $token)) {
          $this->token= CompactXmlParser::T_NUMBER;
          $this->value= $token;
        } else {
          $this->token= CompactXmlParser::T_WORD;
          $this->value= $token;
        }
        
        break;
      } while (1);
      
      return TRUE;
    }
  }
?>
