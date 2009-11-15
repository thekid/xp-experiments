<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';

  uses(
    'lang.ClassLoader',
    'xp.ide.ClassPathScanner',
    'xp.ide.completion.PackageClassCompleter',
    'xp.ide.completion.Response',
    'xp.ide.completion.UncompletePackageClass',
    'xp.ide.IXpIde',
    'xp.ide.info.MemberInfo',
    'xp.ide.resolve.Resolver',
    'xp.ide.resolve.Response',
    'xp.ide.source.element.Classdef',
    'xp.ide.source.element.ClassFile',
    'xp.ide.source.Generator',
    'xp.ide.source.snippet.GetterFactory',
    'xp.ide.source.snippet.GetterName',
    'xp.ide.source.snippet.SetterFactory',
    'xp.ide.source.snippet.SetterName',
    'xp.ide.text.StreamWorker',
    'xp.ide.toggle.Response'
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
     * set input stream reader
     *
     * @param  io.streams.TextReader in
     */
    public function setIn(TextReader $in) {
      $this->in= $in;
    }

    /**
     * get input stream reader
     *
     * @return io.streams.TextReader
     */
    public function getIn() {
      return $this->in;
    }

    /**
     * set output stream writer
     *
     * @param  io.streams.TextWriter out
     */
    public function setOut(TextWriter $out) {
      $this->out= $out;
    }

    /**
     * get output stream writer
     *
     * @return io.streams.TextWriter
     */
    public function getOut() {
      return $this->out;
    }

    /**
     * set error stream writer
     *
     * @param  io.streams.TextWriter err
     */
    public function setErr(TextWriter $err) {
      $this->err= $err;
    }

    /**
     * get error stream writer
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
    public function complete(xp·ide·Cursor $cursor, Folder $cwd) {
      create(new xp·ide·ClassPathScanner())->fromFolder($cwd);
      $searchWord= create(new xp·ide·text·StreamWorker())->grepClassName($this->in, $cursor);
      return new xp·ide·completion·Response(
        $searchWord,
        create(new xp·ide·completion·PackageClassCompleter())->suggest(
          new xp·ide·completion·UncompletePackageClass($searchWord->getText())
        )
      );
    }

    /**
     * toggle classname and class locator
     *
     * @param  xp.ide.Cursor cursor
     * @param  io.Folder cwd
     * @throws lang.IllegalArgumentException
     * @return  xp.ide.toggle.Response
     */
    public function toggleClass(xp·ide·Cursor $cursor, Folder $cwd) {
      create(new xp·ide·ClassPathScanner())->fromFolder($cwd);
      $searchWord= create(new xp·ide·text·StreamWorker())->grepClassName($this->in, $cursor);
      if (ClassLoader::getDefault()->providesClass($searchWord->getText())) {
        $typename= '';
        try {
          $typename= xp·ide·source·element·ClassFile::fromClasslocator($searchWord->getText())->getClassdef()->getName();
        } catch (XPException $e) {
          $typename= 'Object';
        }
        return new xp·ide·toggle·Response($searchWord, $typename);
      }
      throw new IllegalArgumentException(sprintf(
        '%s is not a class location.'.PHP_EOL.PHP_EOL.'Registered ClassLoaders:'.PHP_EOL.'%s',
        $searchWord->getText(),
        implode(PHP_EOL, array_map(array('xp', 'stringOf'), ClassLoader::getDefault()->getLoaders()))
      ));
    }

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  xp.ide.Cursor cursor
     * @param  io.Folder cwd
     * @return xp.ide.resolve.Response
     */
    public function grepClassFileUri(xp·ide·Cursor $cursor, Folder $cwd) {
      create(new xp·ide·ClassPathScanner())->fromFolder($cwd);
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
      $cf= xp·ide·source·element·ClassFile::fromStream($this->in);
      try {
        $cf->parseClassdefContent();
      } catch (ParseException $pe) {
        return array();
      }

      $mis= array();
      $mens= array_map(create_function('$e', 'return $e->getName();'), $cf->getClassdef()->getMethods());
      foreach ($cf->getClassdef()->getMembergroups() as $mg) foreach ($mg->getMembers() as $m) {
        $mis[]= $mi= new xp·ide·info·MemberInfo(
          $mg->isFinal(),
          $mg->isStatic(),
          $mg->getScope(),
          $m->getName(),
          $this->dataTypeFromInit($m->getInit())
        );
        if (in_array(xp·ide·source·snippet·GetterName::getByType($mi->getName(), $mi->getType()), $mens)) $mi->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
        if (in_array(xp·ide·source·snippet·SetterName::getByType($mi->getName(), $mi->getType()), $mens)) $mi->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
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
