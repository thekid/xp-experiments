<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';

  uses(
    'xp.ide.resolve.Resolver',
    'xp.ide.text.StreamWorker',
    'xp.ide.IXpIde',
    'xp.ide.ClassFileInfo'
  );

  /**
   * XP IDE
   *
   * @purpose IDE
   */
  class xp·ide·XpIde extends Object implements xp·ide·IXpIde {

    public function complete() {
    }

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  string[] suggestions
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
