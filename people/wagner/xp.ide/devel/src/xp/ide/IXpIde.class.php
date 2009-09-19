<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';

  /**
   * ide interface
   *
   * @purpose IDE
   */
  interface xp·ide·IXpIde {

    /**
     * complete the source under the cursor
     *
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.completion.Response
     */
    public function complete(xp·ide·Cursor $cursor);

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.resolve.Response
     */
    public function grepClassFileUri(xp·ide·Cursor $cursor);

    /**
     * check syntax
     *
     * @param  xp.ide.lint.ILanguage language
     * @return xp.ide.lint.Error[]
     */
    public function checkSyntax(xp·ide·lint·ILanguage $language);

    /**
     * set input stream
     *
     * @param  xp.ide.streams.IEncodedInputStream in
     */
    public function setIn(xp·ide·streams·IEncodedInputStream $in);

    /**
     * get input stream
     *
     * @return xp.ide.streams.IEncodedInputStream
     */
    public function getIn();

    /**
     * set output stream
     *
     * @param  xp.ide.streams.IEncodedOutputStream out
     */
    public function setOut(xp·ide·streams·IEncodedOutputStream $out);

    /**
     * get output stream
     *
     * @return xp.ide.streams.IEncodedOutputStream
     */
    public function getOut();

    /**
     * set error stream
     *
     * @param  xp.ide.streams.IEncodedOutputStream err
     */
    public function setErr(xp·ide·streams·IEncodedOutputStream $err);

    /**
     * get error stream
     *
     * @return xp.ide.streams.IEncodedOutputStream
     */
    public function getErr();

  }
?>
