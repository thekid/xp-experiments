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

    public function complete();

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param   string[] suggestions
     */
    public function grepClassFileUri(InputStream $stream, xp·ide·Cursor $cursor);

    public function lint();
  }
?>
