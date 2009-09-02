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
    'io.streams.MemoryInputStream',
    'xp.ide.IXpIde',
    'xp.ide.resolve.Resolver',
    'xp.ide.completion.PackageClassCompleter',
    'xp.ide.completion.UncompletePackageClass',
    'xp.ide.text.StreamWorker',
    'xp.ide.text.StreamWorker',
    'xp.ide.resolve.Response',
    'xp.ide.completion.Response'
  );

  /**
   * XP IDE
   *
   * @purpose IDE
   */
  class xp·ide·XpIde extends Object implements xp·ide·IXpIde {

    /**
     * complete the source under the cursor
     *
     * @param  xp.ide.text.IInputStream stream
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.completion.Response
     */
    #[@action(name='complete', args="InputStream, Cursor")]
    public function complete(xp·ide·text·IInputStream $stream, xp·ide·Cursor $cursor) {
      $searchWord= create(new xp·ide·text·StreamWorker())->grepClassName($stream, $cursor);
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
    #[@action(name='grepclassfile', args="InputStream, Cursor")]
    public function grepClassFileUri(xp·ide·text·IInputStream $stream, xp·ide·Cursor $cursor) {
      $searchWord= create(new xp·ide·text·StreamWorker())->grepClassName($stream, $cursor);
      $resolver= new xp·ide·resolve·Resolver();
      return new xp·ide·resolve·Response($searchWord, $resolver->getSourceUri($searchWord->getText()));
    }

    /**
     * check syntax
     *
     * @param  xp.ide.text.IInputStream stream
     * @param  xp.ide.lint.ILanguage language
     * @return xp.ide.lint.Error[]
     */
    #[@action(name='checksyntax', args="InputStream, Language")]
    public function checkSyntax(xp·ide·text·IInputStream $stream, xp·ide·lint·ILanguage $language) {
      return $language->checkSyntax($stream);
    }

    /**
     * get class info
     *
     * @param  xp.ide.text.IInputStream stream
     * @param  xp.ide.info.InfoType itype
     */
    #[@action(name='info', args="InputStream, Infotype")]
    public function info(xp·ide·text·IInputStream $stream, xp·ide·info·InfoType $itype) {
      $t= new xp·ide·source·element·ClassFile();

      $p= new xp·ide·source·parser·ClassFileParser();
      $p->setTopElement($t);
      $l= new xp·ide·source·parser·ClassFileLexer($stream);
      try {
        $p->parse($l);
      } catch (ParseException $e) {
        var_dump($e->getCause()->getMessage());
        exit();
      }

      $cd= $t->getClassdef();
      $cp= new xp·ide·source·parser·ClassParser();
      $cp->setTopElement($cd);
      $cl= new xp·ide·source·parser·ClassLexer(new MemoryInputStream($cd->getContent()));
      try {
        $cp->parse($cl);
      } catch (ParseException $e) {
        var_dump($e->getCause()->getMessage());
        var_dump($cd->getContent());
        exit();
      }
      $cd->setContent(NULL);

      switch ($itype) {
        case xp·ide·info·InfoType::$MEMBER:
        var_dump($t);
      }
    }

  }
?>
