<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';

  /**
   * ide interface
   *
   * @purpose IDE
   */
  interface xp·ide·IXpIde {

    /**
     * complete the source under the cursor
     *
     * @param  io.streams.InputStream stream
     * @param  xp-ide.Cursor cursor
     * @return xp.ide.ClassFileInfo
     */
    public function complete(InputStream $stream, xp·ide·Cursor $cursor);

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  io.streams.InputStream stream
     * @param  xp-ide.Cursor cursor
     * @return xp.ide.ClassFileInfo
     */
    public function grepClassFileUri(InputStream $stream, xp·ide·Cursor $cursor);

    public function lint();
  }
?>
