<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.proxy';

  uses(
    'xp.ide.IXpIde',
    'xp.ide.proxy.Proxy'
  );

  /**
   * Gedit ide Proxy
   *
   * @purpose IDE
   */
  class xp·ide·proxy·Gedit extends xp·ide·proxy·Proxy implements xp·ide·IXpIde {

    /**
     * complete the source under the cursor
     *
     * @param  xp.ide.text.IInputStream stream
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.completion.Info
     */
    public function complete(xp·ide·text·IInputStream $stream, xp·ide·Cursor $cursor) {
      $info= $this->ide->complete($stream, $cursor);
      Console::$out->writeLine($info->getSnippet()->getPosition());
      Console::$out->writeLine(strlen($info->getSnippet()->getText()));
      Console::$out->writeLine(count($info->getSuggestions()));
      Console::$out->write(implode(PHP_EOL, $info->getSuggestions()));
      return $info;
    }

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  xp.ide.text.IInputStream stream
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.resolve.Info
     */
    public function grepClassFileUri(xp·ide·text·IInputStream $stream, xp·ide·Cursor $cursor) {
      $info= $this->ide->grepClassFileUri($stream, $cursor);
      list($scheme, $rest)= explode('://', $info->getUri(), 2);
      if ('file' !== $scheme) throw new IllegalArgumentException(sprintf('Cannot open class "%s" from location %s', $info->getSnippet()->getText(), $info->getUri()));
      Console::$out->write($info->getUri());
      return $info;
    }

    /**
     * check syntax
     *
     * @param  xp.ide.text.IInputStream stream
     * @param  xp.ide.lint.ILanguage language
     * @return xp.ide.lint.Error[]
     */
    public function checkSyntax(xp·ide·text·IInputStream $stream, xp·ide·lint·ILanguage $language) {
      $errors= $this->ide->checkSyntax($stream, $language);
      if (0 == sizeOf($errors)) {
        Console::$out->writeLine("0".PHP_EOL."0".PHP_EOL);
        return;
      }
      $e= array_shift($errors);
      Console::$out->writeLine($e->getLine());
      Console::$out->writeLine($e->getColumn());
      Console::$out->writeLine($e->getText());
      foreach ($errors as $e) {
        Console::$out->writeLine(sprintf(
          '- %d(%d): %s',
          $e->getLine(),
          $e->getColumn(),
          $e->getText()
        ));
      }
      return $errors;
    }
  }
?>
