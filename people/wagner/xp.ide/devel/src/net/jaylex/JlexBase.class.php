<?php
 /* This class is part of the XP framework
  *
  * $Id$
  *
  * Copyright 2009 Ruben Wagner, XP framework
  * Based on JLexPHP which is:
  *
  *   Copyright 2006 Wez Furlong, OmniTI Computer Consulting, Inc.
  *   Based on JLex which is:
  *
  *        JLEX COPYRIGHT NOTICE, LICENSE, AND DISCLAIMER
  *     Copyright 1996-2000 by Elliot Joel Berk and C. Scott Ananian 
  *
  *     Permission to use, copy, modify, and distribute this software and its
  *     documentation for any purpose and without fee is hereby granted,
  *     provided that the above copyright notice appear in all copies and that
  *     both the copyright notice and this permission notice and warranty
  *     disclaimer appear in supporting documentation, and that the name of
  *     the authors or their employers not be used in advertising or publicity
  *     pertaining to distribution of the software without specific, written
  *     prior permission.
  *
  *     The authors and their employers disclaim all warranties with regard to
  *     this software, including all implied warranties of merchantability and
  *     fitness. In no event shall the authors or their employers be liable
  *     for any special, indirect or consequential damages or any damages
  *     whatsoever resulting from loss of use, data or profits, whether in an
  *     action of contract, negligence or other tortious action, arising out
  *     of or in connection with the use or performance of this software.
  */

  $package= 'net.jaylex';

  uses(
    'text.parser.generic.AbstractLexer',
    'io.IOException',
    'lang.IllegalArgumentException'
  );

  abstract class net·jaylex·JLexBase extends AbstractLexer {
    public static $yy_error_string= array(
      'INTERNAL' => "Error: internal error.\n",
      'MATCH' => "Error: Unmatched input.\n"
    );

    protected
      $yy_reader= NULL,
      $yy_buffer= "",
      $yy_buffer_read= 0,
      $yy_buffer_index= 0,
      $yy_buffer_start= 0,
      $yy_buffer_end= 0,
      $yychar= 0,
      $yycol= 0,
      $yyline= 0,
      $yy_at_bol= TRUE,
      $yy_lexical_state,
      $yy_last_was_cr= FALSE,
      $yy_count_lines= FALSE,
      $yy_count_chars= FALSE;

    /**
     * Constructor
     *
     * @param io.streams.InputStream
     */
    public function __construct(InputStream $stream) {
      $this->yy_reader= $stream;
    }

    /**
     * Advance to next token. Return TRUE and set token, value and
     * position members to indicate we have more tokens, or FALSE
     * to indicate we've arrived at the end of the tokens.
     *
     * @return  bool
     */
    public function advance() {
      $this->yylex();
      $this->token    = NULL;
      $this->value    = $this->yytext();
      $this->position = array($this->yyline, $this->yycol);
      return TRUE;
    }

    /**
     * read the next token and sets the member variables:
     * - yycol
     * - yyline
     * - buffer*
     *
     */
    abstract protected function yylex();

    /**
     * set state
     *
     */
    protected function yybegin($state) {
      $this->yy_lexical_state= $state;
    }

    /**
     * get next token
     *
     */
    protected function yy_advance() {
      if ($this->yy_buffer_index < $this->yy_buffer_read) {
        return ord($this->yy_buffer[$this->yy_buffer_index++]);
      }
      if ($this->yy_buffer_start != 0) {
        /* shunt */
        $j= $this->yy_buffer_read - $this->yy_buffer_start;
        $this->yy_buffer= substr($this->yy_buffer, $this->yy_buffer_start, $j);
        $this->yy_buffer_end -= $this->yy_buffer_start;
        $this->yy_buffer_start= 0;
        $this->yy_buffer_read= $j;
        $this->yy_buffer_index= $j;

        if (!$this->yy_reader->available()) return $this->YY_EOF;
        $data= $this->yy_reader->read();
        $this->yy_buffer .= $data;
        $this->yy_buffer_read .= strlen($data);
      }

      while ($this->yy_buffer_index >= $this->yy_buffer_read) {
        if (!$this->yy_reader->available()) return $this->YY_EOF;
        $data= $this->yy_reader->read();
        $this->yy_buffer .= $data;
        $this->yy_buffer_read .= strlen($data);
      }
      return ord($this->yy_buffer[$this->yy_buffer_index++]);
    }

    /**
     * move to the end of line
     *
     */
    protected function yy_move_end() {
      if (
        $this->yy_buffer_end > $this->yy_buffer_start
        && "\n" == $this->yy_buffer[$this->yy_buffer_end-1]
      ) $this->yy_buffer_end--;
      if (
        $this->yy_buffer_end > $this->yy_buffer_start
        && "\r" == $this->yy_buffer[$this->yy_buffer_end-1]
      ) $this->yy_buffer_end--;
    }

    /**
     * set start index
     *
     */
    protected function yy_mark_start() {
      if (!$this->yy_count_lines && !$this->yy_count_chars) return;
      if ($this->yy_count_lines) {
        for ($i= $this->yy_buffer_start; $i < $this->yy_buffer_index; ++$i) {
          if ("\n" == $this->yy_buffer[$i] && !$this->yy_last_was_cr) {
            $this->yyline++;
            $this->yycol= 0;
          }
          if ("\r" == $this->yy_buffer[$i]) {
            $yyline++;
            $this->yycol= 0;
            $this->yy_last_was_cr= TRUE;
          } else {
            $this->yy_last_was_cr= FALSE;
          }
        }
      }
      if ($this->yy_count_chars) {
        $this->yychar += $this->yy_buffer_index - $this->yy_buffer_start;
        $this->yycol +=  $this->yy_buffer_index - $this->yy_buffer_start;
      }
      $this->yy_buffer_start= $this->yy_buffer_index;
    }

    /**
     * set end index
     *
     */
    protected function yy_mark_end() {
      $this->yy_buffer_end= $this->yy_buffer_index;
    }

    /**
     * goto mark
     *
     */
    protected function yy_to_mark() {
      $this->yy_buffer_index= $this->yy_buffer_end;
      $this->yy_at_bol=
        ($this->yy_buffer_end > $this->yy_buffer_start)
        && in_array($this->yy_buffer[$this->yy_buffer_end-1], array(
          "\r",
          "\n",
          2028, // unicode LS
          2029, // unicode PS
        ))
      ;
    }

    /**
     * get detected token
     *
     * @return string
     */
    protected function yytext() {
      return substr(
        $this->yy_buffer,
        $this->yy_buffer_start,
        $this->yy_buffer_end - $this->yy_buffer_start
      );
    }

    /**
     * get detected token length
     *
     * @return int
     */
    protected function yylength() {
      return $this->yy_buffer_end - $this->yy_buffer_start;
    }

    /**
     * go back in buffer
     *
     * @param int l
     * @return int
     * @throws lang.IllegalArgumentException
     */
    protected function yypushback($l) {
      if ($l > $this->yylength()) throw new IllegalStateException(sprintf('pushback can only be as long as the recognized pattern (%d byte but was %d)', $this->yylength(), $l));
      return $this->yy_buffer_index -= $l;
    }

    /**
     * raise error
     *
     * @param string error code
     * @param bool fatal
     * @throws io.IOException
     */
    protected function yy_error($code, $fatal) {
      throw new IOException("JLex fatal error " . self::$yy_error_string[$code]);
    }

  }

?>
