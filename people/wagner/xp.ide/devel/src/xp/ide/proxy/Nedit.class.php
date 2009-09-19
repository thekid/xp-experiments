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
   * Nedit ide Proxy
   *
   * @purpose IDE
   */
  class xp·ide·proxy·Nedit extends xp·ide·proxy·Proxy implements xp·ide·IXpIde {

    /**
     * complete the source under the cursor
     *
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.completion.Response
     */
    public function complete(xp·ide·Cursor $cursor) {
      $response= $this->ide->complete($cursor);
      $this->out->write(
        $response->getSnippet()->getPosition().PHP_EOL
        .strlen($response->getSnippet()->getText()).PHP_EOL
        .count($response->getSuggestions()).PHP_EOL
        .implode(PHP_EOL, $response->getSuggestions())
      );
      return $response;
    }

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.resolve.Response
     */
    public function grepClassFileUri(xp·ide·Cursor $cursor) {
      $response= $this->ide->grepClassFileUri($cursor);
      list($scheme, $rest)= explode('://', $response->getUri(), 2);
      if ('file' !== $scheme) throw new IllegalArgumentException(sprintf('Cannot open class "%s" from location %s', $response->getSnippet()->getText(), $response->getUri()));
      $this->out->write($rest);
      return $response;
    }

    /**
     * check syntax
     *
     * @param  xp.ide.lint.ILanguage language
     * @return xp.ide.lint.Error[]
     */
    public function checkSyntax(xp·ide·lint·ILanguage $language) {
      $errors= $this->ide->checkSyntax($language);
      if (0 == sizeOf($errors)) {
        $this->out->write("0".PHP_EOL."0".PHP_EOL.PHP_EOL);
        return;
      }
      foreach ($errors as $e) {
        $this->out->write(
          $e->getLine().PHP_EOL
          .$e->getColumn().PHP_EOL
          .$e->getText()
        );
      }
      return $errors;
    }
  }
?>
