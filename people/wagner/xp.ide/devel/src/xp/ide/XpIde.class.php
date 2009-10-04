<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';

  uses(
    'xp.ide.source.parser.ClassFileParser',
    'xp.ide.source.parser.ClassFileLexer',
    'xp.ide.IXpIde',
    'xp.ide.resolve.Resolver',
    'xp.ide.completion.PackageClassCompleter',
    'xp.ide.completion.UncompletePackageClass',
    'xp.ide.text.StreamWorker',
    'xp.ide.info.MemberInfoVisitor',
    'xp.ide.resolve.Response',
    'xp.ide.completion.Response',
    'xp.ide.source.element.Classmethod',
    'xp.ide.source.Scope'
  );

  /**
   * XP IDE
   *
   * @purpose IDE
   */
  class xp·ide·XpIde extends Object implements xp·ide·IXpIde {

    private
      $in= NULL,
      $out= NULL,
      $err= NULL;

    /**
     * Constructor
     *
     * @param  xp.ide.streams.IEncodedInputStream in
     * @param  xp.ide.streams.IEncodedOutputStream out
     * @param  xp.ide.streams.IEncodedOutputStream err
     */
    public function __construct(xp·ide·streams·IEncodedInputStream $in, xp·ide·streams·IEncodedOutputStream $out, xp·ide·streams·IEncodedOutputStream $err) {
      $this->in= $in;
      $this->out= $out;
      $this->err= $err;
    }

    /**
     * set input stream
     *
     * @param  xp.ide.streams.IEncodedInputStream stream
     */
    public function setIn(xp·ide·streams·IEncodedInputStream $in) {
      $this->in= $in;
    }

    /**
     * get input stream
     *
     * @return xp.ide.streams.IEncodedInputStream in
     */
    public function getIn() {
      return $this->in;
    }

    /**
     * set output stream
     *
     * @param  xp.ide.streams.IEncodedOutputStream out
     */
    public function setOut(xp·ide·streams·IEncodedOutputStream $out) {
      $this->out= $out;
    }

    /**
     * get output stream
     *
     * @return xp.ide.streams.IEncodedOutputStream
     */
    public function getOut() {
      return $this->out;
    }

    /**
     * set error stream
     *
     * @param  xp.ide.streams.IEncodedOutputStream err
     */
    public function setErr(xp·ide·streams·IEncodedOutputStream $err) {
      $this->err= $err;
    }

    /**
     * get error stream
     *
     * @return xp.ide.streams.IEncodedOutputStream
     */
    public function getErr() {
      return $this->err;
    }

    /**
     * complete the source under the cursor
     *
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.completion.Response
     */
    #[@action(name='complete', args="Cursor")]
    public function complete(xp·ide·Cursor $cursor) {
      $searchWord= create(new xp·ide·text·StreamWorker())->grepClassName($this->in, $cursor);
      return new xp·ide·completion·Response(
        $searchWord,
        create(new xp·ide·completion·PackageClassCompleter())->suggest(
          new xp·ide·completion·UncompletePackageClass($searchWord->getText())
        )
      );
    }

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  xp.ide.streams.IEncodedInputStream stream
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.resolve.Response
     */
    #[@action(name='grepclassfile', args="Cursor")]
    public function grepClassFileUri(xp·ide·Cursor $cursor) {
      $searchWord= create(new xp·ide·text·StreamWorker())->grepClassName($this->in, $cursor);
      $resolver= new xp·ide·resolve·Resolver();
      return new xp·ide·resolve·Response($searchWord, $resolver->getSourceUri($searchWord->getText()));
    }

    /**
     * check syntax
     *
     * @param  xp.ide.lint.ILanguage language
     * @return xp.ide.lint.Error[]
     */
    #[@action(name='checksyntax', args="Language")]
    public function checkSyntax(xp·ide·lint·ILanguage $language) {
      return $language->checkSyntax($this->in);
    }

    /**
     * get class info
     *
     * @param  xp.ide.info.InfoType itype
     * @return xp.ide.source.Element[]
     */
    #[@action(name='info', args="Infotype")]
    public function info(xp·ide·info·InfoType $itype) {
      $p= new xp·ide·source·parser·ClassFileParser();
      $p->setTopElement($t= new xp·ide·source·element·ClassFile());
      $p->parse(new xp·ide·source·parser·ClassFileLexer($this->in));

      switch ($itype) {
        case xp·ide·info·InfoType::$MEMBER:
        return create(new xp·ide·info·MemberInfoVisitor())->visit($t);
      }
    }

    /**
     * create accessors
     *
     */
    #[@action(name='createAccessors')]
    public function createAccessors() {
      $confs= '';
      while ($this->in->available()) $confs.= $this->in->read();
      if (!$confs) return;
      $confs= explode(PHP_EOL, $confs);
      foreach ($confs as $conf) {
        list($name, $type, $acc)= explode(':', $conf);
        $me= new xp·ide·source·element·Classmethod($name);
        var_dump($me);
      }
    }

  }
?>
