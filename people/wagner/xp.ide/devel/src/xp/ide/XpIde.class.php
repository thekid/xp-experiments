<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';

  uses(
    'xp.ide.source.parser.ClassFileParser',
    'xp.ide.source.parser.ClassFileLexer',
    'io.streams.MemoryInputStream',
    'xp.ide.IXpIde',
    'xp.ide.resolve.Resolver',
    'xp.ide.completion.PackageClassCompleter',
    'xp.ide.completion.UncompletePackageClass',
    'xp.ide.text.ChannelInputStream',
    'xp.ide.text.StreamWorker',
    'xp.ide.info.MemberInfoVisitor',
    'xp.ide.resolve.Response',
    'xp.ide.completion.Response'
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
     * @param  xp.ide.text.IInputStream stream
     */
    public function __construct(xp·ide·text·IInputStream $in= NULL) {
      $this->in= is_null($in) ? new xp·ide·text·ChannelInputStream('stdin') : $in;
    }

    /**
     * set input stream
     *
     * @param  xp.ide.text.IInputStream stream
     */
    public function setIn(xp·ide·text·IInputStream $in) {
      $this->in= $in;
    }

    /**
     * get input stream
     *
     * @return xp.ide.text.IInputStream stream
     */
    public function getIn() {
      return $this->in;
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
     * @param  xp.ide.text.IInputStream stream
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
     */
    #[@action(name='info', args="Infotype")]
    public function info(xp·ide·info·InfoType $itype) {
      $p= new xp·ide·source·parser·ClassFileParser();
      $p->setTopElement($t= new xp·ide·source·element·ClassFile());
      $p->parse(new xp·ide·source·parser·ClassFileLexer($this->in));

      switch ($itype) {
        case xp·ide·info·InfoType::$MEMBER:
        create(new xp·ide·info·MemberInfoVisitor(new ConsoleOutputStream(STDOUT)))->visit($t);
      }
    }

  }
?>
