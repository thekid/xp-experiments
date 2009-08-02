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
    'xp.ide.text.StreamWorker',
    'xp.ide.ClassFileInfo',
    'xp.ide.CompleteInfo'
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
     * @param  xp-ide.Cursor cursor
     * @return xp.ide.ClassFileInfo
     */
    #[@action(name='complete', args="InputStream, Cursor")]
    public function complete(InputStream $stream, xp·ide·Cursor $cursor) {
      $searchWord= create(new xp·ide·text·StreamWorker($this->inputStream, $this->cursor))->grepClassName();
      return new xp·ide·CompleteInfo(
        $searchWord,
        create(new xp·ide·completion·PackageClassCompleter(
          new xp·ide·completion·UncompletePackageClass($searchWord->getText())
        ))->suggest()
      );
    }

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  io.streams.InputStream stream
     * @param  xp-ide.Cursor cursor
     * @return xp.ide.ClassFileInfo
     */
    #[@action(name='grepclassfile', args="InputStream, Cursor")]
    public function grepClassFileUri(InputStream $stream, xp·ide·Cursor $cursor) {
      $searchWord= create(new xp·ide·text·StreamWorker($stream, $cursor))->grepClassName();
      $resolver= new xp·ide·resolve·Resolver();
      return new xp·ide·ClassFileInfo($searchWord, $resolver->getSourceUri($searchWord->getText()));
    }

    public function lint() {
    }

  }
?>
