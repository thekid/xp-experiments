<?php
/* This class is part of the XP IDE
 *
 * $Id: XpIde.class.php 11628 2009-11-09 22:51:33Z ruben $ 
 */
  $package= 'xp.ide.unittest.mock';

  uses(
    'xp.ide.IXpIde'
  );

  /**
   * XP IDE mock
   *
   * @purpose test IDE
   */
  class xp·ide·unittest·mock·XpIde extends Object implements xp·ide·IXpIde {

    private
      $in= NULL,
      $out= NULL,
      $err= NULL,
      $accessorConfig= array();

    /**
     * Constructor
     *
     * @param  io.streams.TextReader in
     * @param  io.streams.TextWriter out
     * @param  io.streams.TextWriter err
     */
    public function __construct(TextReader $in, TextWriter $out, TextWriter $err) {
      $this->in= $in;
      $this->out= $out;
      $this->err= $err;
    }

    /**
     * set member $in
     * 
     * @param io.streams.TextReader in
     */
    public function setIn(TextReader $in) {
      $this->in= $in;
    }

    /**
     * get member $in
     * 
     * @return io.streams.TextReader
     */
    public function getIn() {
      return $this->in;
    }

    /**
     * set member $out
     * 
     * @param io.streams.TextWriter out
     */
    public function setOut(TextWriter $out) {
      $this->out= $out;
    }

    /**
     * get member $out
     * 
     * @return io.streams.TextWriter
     */
    public function getOut() {
      return $this->out;
    }

    /**
     * set member $err
     * 
     * @param io.streams.TextWriter err
     */
    public function setErr(TextWriter $err) {
      $this->err= $err;
    }

    /**
     * get member $err
     * 
     * @return io.streams.TextWriter
     */
    public function getErr() {
      return $this->err;
    }

    /**
     * complete the source under the cursor
     *
     * @param  xp.ide.Cursor cursor
     * @param  io.Folder cwd
     * @return xp.ide.completion.Response
     */
    public function complete(xp·ide·Cursor $cursor, Folder $cwd) {}

    /**
     * toggle classname and class locator
     *
     * @param  xp.ide.Cursor cursor
     * @param  io.Folder cwd
     * @throws lang.IllegalArgumentException
     * @return xp.ide.toggle.Response
     */
    public function toggleClass(xp·ide·Cursor $cursor, Folder $cwd) {}

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  xp.ide.Cursor cursor
     * @param  io.Folder cwd
     * @return xp.ide.resolve.Response
     */
    public function grepClassFileUri(xp·ide·Cursor $cursor, Folder $cwd) {}

    /**
     * check syntax
     *
     * @param  xp.ide.lint.ILanguage language
     * @return xp.ide.lint.Error[]
     */
    public function checkSyntax(xp·ide·lint·ILanguage $language) {}

    /**
     * get member Info
     *
     * @return xp.ide.info.MemberInfo[]
     */
    public function memberInfo() {}

    /**
     * create accessors
     *
     * @param xp·ide·AccessorConfig[]
     */
    public function createAccessors(array $accInfos) {
      $this->accessorConfig= $accInfos;
    }

    /**
     * get member $accessorConfig
     * 
     * @return xp.ide.AccessorConfig[]
     */
    public function getAccessorConfig() {
      return $this->accessorConfig;
    }
  }
?>
