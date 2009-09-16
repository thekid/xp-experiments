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
     * @param  xp.ide.text.IInputStream stream
     */
    public function setIn(xp·ide·text·IInputStream $in);

    /**
     * get input stream
     *
     * @return xp.ide.text.IInputStream
     */
    public function getIn();

  }
?>
