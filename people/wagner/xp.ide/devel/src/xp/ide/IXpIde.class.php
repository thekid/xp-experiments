<?php
/* This class is part of the XP framework
 *
 * $Id: XpIde.class.php 11628 2009-11-09 22:51:33Z ruben $ 
 */
  $package= 'xp.ide';

  /**
   * XP IDE
   *
   * @purpose IDE
   */
  interface xp·ide·IXpIde {

    /**
     * complete the source under the cursor
     *
     * @param  xp.ide.Cursor cursor
     * @param  io.Folder cwd
     * @return xp.ide.completion.Response
     */
    public function complete(xp·ide·Cursor $cursor, Folder $cwd);

    /**
     * toggle classname and class locator
     *
     * @param  xp.ide.Cursor cursor
     * @param  io.Folder cwd
     * @throws lang.IllegalArgumentException
     * @return  xp.ide.toggle.Response
     */
    public function toggleClass(xp·ide·Cursor $cursor, Folder $cwd);

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  xp.ide.Cursor cursor
     * @param  io.Folder cwd
     * @return xp.ide.resolve.Response
     */
    public function grepClassFileUri(xp·ide·Cursor $cursor, Folder $cwd);

    /**
     * check syntax
     *
     * @param  xp.ide.lint.ILanguage language
     * @return xp.ide.lint.Error[]
     */
    public function checkSyntax(xp·ide·lint·ILanguage $language);

    /**
     * get member Info
     *
     * @return xp.ide.info.MemberInfo[]
     */
    public function memberInfo();

    /**
     * create accessors
     *
     * @param xp·ide·AccessorConfig[]
     */
    public function createAccessors(array $accInfos);
  }
?>
