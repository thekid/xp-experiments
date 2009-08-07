<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 $package= 'xp.ide.lint';
 
  /**
   * check php syntax
   *
   * @purpose  IDE
   */
  interface xp·ide·lint·ILanguage {

    /**
     * check source code
     *
     * @param   io.streams.InputStream
     */
    public function checkSyntax(InputStream $stream);
  }
?>
