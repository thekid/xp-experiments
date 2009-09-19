<?php
/* This class is part of the XP framework
 *
 * $Id: IInputStream.class.php 11317 2009-08-07 12:34:15Z ruben $ 
 */
  $package= 'xp.ide.streams';

  uses(
    'xp.ide.streams.IEncodedStream',
    'io.streams.OutputStream'
  );

  /**
   * input stream interface with encoding meta information
   *
   * @purpose  IDE
   */
  interface xp·ide·streams·IEncodedOutputStream extends OutputStream, xp·ide·streams·IEncodedStream {
  }

?>
