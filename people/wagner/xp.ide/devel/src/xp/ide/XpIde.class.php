<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';

  uses(
    'xp.ide.source.parser.ClassFileParser',
    'xp.ide.source.parser.ClassFileLexer',
    'xp.ide.source.parser.ClassParser',
    'xp.ide.source.parser.ClassLexer',
    'xp.ide.resolve.Resolver',
    'xp.ide.completion.PackageClassCompleter',
    'xp.ide.completion.UncompletePackageClass',
    'xp.ide.text.StreamWorker',
    'xp.ide.info.MemberInfo',
    'xp.ide.resolve.Response',
    'xp.ide.completion.Response',
    'xp.ide.source.snippet.GetterFactory',
    'xp.ide.source.snippet.SetterFactory',
    'xp.ide.source.Generator'
  );

  /**
   * XP IDE
   *
   * @purpose IDE
   */
  class xp·ide·XpIde extends Object {

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
    public function checkSyntax(xp·ide·lint·ILanguage $language) {
      return $language->checkSyntax($this->in);
    }

    /**
     * get member Info
     *
     * @return xp.ide.info.MemberInfo[]
     */
    public function memberInfo() {
      $p= new xp·ide·source·parser·ClassFileParser();
      $p->setTopElement($cf= new xp·ide·source·element·ClassFile());
      $p->parse(new xp·ide·source·parser·ClassFileLexer($this->in));

      $cp= new xp·ide·source·parser·ClassParser();
      $cp->setTopElement($cf->getClassdef());
      try {
        $cp->parse(new xp·ide·source·parser·ClassLexer(new MemoryInputStream($cf->getClassdef()->getContent())));
      } catch (ParseException $pe) {
        return array();
      }

      $mis= array();
      foreach ($cf->getClassdef()->getMembergroups() as $mg) foreach ($mg->getMembers() as $m) {
        $mis[]= new xp·ide·info·MemberInfo(
          $mg->isFinal(),
          $mg->isStatic(),
          $mg->getScope(),
          $m->getName(),
          $this->dataTypeFromInit($m->getInit())
        );
      }
      return $mis;

    }

    /**
     * create accessors
     *
     * @param xp·ide·AccessorConfig[]
     */
    public function createAccessors(array $accInfos) {
      $gen= new xp·ide·source·Generator($this->out);
      $gen->setIndent(2);
      foreach ($accInfos as $accInfo) {
        if ($accInfo->hasAccess(xp·ide·AccessorConfig::ACCESS_SET)) {
          $me= xp·ide·source·snippet·SetterFactory::create($accInfo->getName(), $accInfo->getType(), $accInfo->getType2(), $accInfo->getDim());
          $me->accept($gen);
          $this->out->write(PHP_EOL.PHP_EOL);
        }
        if ($accInfo->hasAccess(xp·ide·AccessorConfig::ACCESS_GET)) {
          $me= xp·ide·source·snippet·GetterFactory::create($accInfo->getName(), $accInfo->getType(), $accInfo->getType2(), $accInfo->getDim());
          $me->accept($gen);
          $this->out->write(PHP_EOL.PHP_EOL);
        }
      }
    }

    /**
     * detects the data type from the init value
     *
     * @param string i
     * @return string
     */
    private function dataTypeFromInit($i) {
      if (is_null($i)) return 'none';
      if ($i instanceof xp·ide·source·element·Array) return 'array';
      if (is_numeric($i) &&($i == (int)$i)) return 'integer';
      if (is_numeric($i)) return 'double';
      if ('NULL' == $i) return 'object';
      if ('TRUE' == strToUpper($i)) return 'boolean';
      if ('FALSE' == strToUpper($i)) return 'boolean';
      return 'string';
    }
  }
?>
