<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';

  uses(
    'xp.ide.IXpIde',
    'xp.ide.resolve.Resolver',
    'xp.ide.completion.PackageClassCompleter',
    'xp.ide.completion.UncompletePackageClass',
    'xp.ide.text.StreamWorker',
    'xp.ide.resolve.Info',
    'xp.ide.completion.Info'
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
     * @param  io.streams.InputStream stream
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.completion.Info
     */
    #[@action(name='complete', args="InputStream, Cursor")]
    public function complete(InputStream $stream, xp·ide·Cursor $cursor) {
      $searchWord= create(new xp·ide·text·StreamWorker($stream, $cursor))->grepClassName();
      return new xp·ide·completion·Info(
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
     * @param  io.streams.InputStream stream
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.resolve.Info
     */
    #[@action(name='grepclassfile', args="InputStream, Cursor")]
    public function grepClassFileUri(InputStream $stream, xp·ide·Cursor $cursor) {
      $searchWord= create(new xp·ide·text·StreamWorker($stream, $cursor))->grepClassName();
      $resolver= new xp·ide·resolve·Resolver();
      return new xp·ide·resolve·Info($searchWord, $resolver->getSourceUri($searchWord->getText()));
    }

    /**
     * check syntax
     *
     * @param  io.streams.InputStream stream
     * @param  xp.ide.lint.ILanguage language
     * @return xp.ide.lint.Error[]
     */
    #[@action(name='checksyntax', args="InputStream, Language")]
    public function checkSyntax(InputStream $stream, xp·ide·lint·ILanguage $language) {
      return $language->checkSyntax($stream);
    }

  }
?>
