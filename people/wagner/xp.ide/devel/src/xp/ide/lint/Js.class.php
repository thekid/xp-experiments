<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 $package= 'xp.ide.lint';
 
  uses(
    'lang.Process',
    'io.TempFile',
    'xp.ide.lint.Error',
    'xp.ide.lint.ILanguage'
  );
 
  /**
   * check javascript syntax
   *
   * @purpose  IDE
   */
  class xp·ide·lint·Js extends Object implements xp·ide·lint·ILanguage {

    /**
     * check source code
     *
     * @param   io.streams.InputStream
     * @return xp.ide.lint.Error[]
     */
    public function checkSyntax(InputStream $stream) {
      with ($cl= $this->getClass()->getPackage()->getPackage('js'), $tmp= new TempFile()); {
        $tmp->open(FILE_MODE_WRITE);
        $tmp->write($cl->getResource('fulljslint.js'));
        $tmp->write($cl->getResource('spidermonkey.js'));
        $tmp->close();
      }

      $errors= array();
      $p= new Process('js', array($tmp->getURI()));
      $in= $p->getInputStream();
      while ($stream->available()) $in->write($stream->read());
      $in->close();

      $out= $p->getOutputStream();
      while (!$out->eof()) {
        if (!preg_match('#^Lint at line (\d+) character (\d+): (.*)\.$#', $out->readLine(), $match)) continue;
        $errors[]= new xp·ide·lint·Error(++$match[1], $match[2], $match[3]);
        break;
      }

      $tmp->unlink();
      return $errors;
    }
  }
?>
