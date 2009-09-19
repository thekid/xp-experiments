<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.streams';

  uses(
    'xp.ide.streams.IEncodedStream',
    'io.streams.InputStream'
  );

  /**
   * input stream interface with encoding meta information
   *
   * @purpose  IDE
   */
  interface xp·ide·streams·IEncodedInputStream extends InputStream, xp·ide·streams·IEncodedStream {
  }

?>
