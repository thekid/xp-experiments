<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 $package= 'xp.ide.lint';
 
  uses(
    'lang.Process',
    'xp.ide.lint.Error',
    'xp.ide.lint.ILanguage'
  );
 
  /**
   * check php syntax
   *
   * @purpose  IDE
   */
  class xp·ide·lint·Php extends Object implements xp·ide·lint·ILanguage {

    /**
     * check source code
     *
     * @param   io.streams.TextReader
     * @return xp.ide.lint.Error[]
     */
    public function checkSyntax(TextReader $stream) {
      $errors= array();
      $p= new Process('php', array('-l'));
      $in= $p->getInputStream();
      while (NULL !== $buff= $stream->read()) $in->write($buff);
      $in->close();

      $out= $p->getOutputStream();
      while (!$out->eof()) {
        if (!preg_match('#^(.*) in - on line (\d+)$#', $out->readLine(), $match)) continue;
        $errors[]= new xp·ide·lint·Error($match[2], 0, $match[1]);
      }
      return $errors;
    }

  }
?>
