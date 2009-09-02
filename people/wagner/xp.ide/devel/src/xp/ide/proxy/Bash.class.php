<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.proxy';

  uses(
    'xp.ide.IXpIde',
    'xp.ide.proxy.Proxy',
    'lang.IllegalArgumentException'
  );

  /**
   * Bash ide Proxy
   *
   * @purpose IDE
   */
  class xp·ide·proxy·Bash extends xp·ide·proxy·Proxy implements xp·ide·IXpIde {

    /**
     * complete the source under the cursor
     *
     * @param  xp.ide.text.IInputStream stream
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.completion.Response
     */
    public function complete(xp·ide·text·IInputStream $stream, xp·ide·Cursor $cursor) {
      $response= $this->ide->complete($stream, $cursor);
      Console::$out->write(implode(PHP_EOL, $response->getSuggestions()));
      return $response;
    }

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  xp.ide.text.IInputStream stream
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.resolve.Response
     */
    public function grepClassFileUri(xp·ide·text·IInputStream $stream, xp·ide·Cursor $cursor) {
      $result= array();
      do {
        try {
          $response= $this->ide->grepClassFileUri($stream, $cursor);
        } catch (IllegalArgumentException $e) {
          continue;
        } catch (xp·ide·resolve·NoSourceException $e) {
          Console::$err->writeLine($e->getMessage());
          continue;
        }
        list($scheme, $rest)= explode('://', $response->getUri(), 2);
        if ('file' !== $scheme) Console::$err->writeLine(sprintf('Cannot open class "%s" from location %s', $response->getSnippet()->getText(), $response->getUri()));
        $result[]= $rest;
      } while ($stream->available());
      Console::$out->write(implode(' ', $result));
      return $result;
    }

    /**
     * check syntax
     *
     * @param  xp.ide.text.IInputStream stream
     * @param  xp.ide.lint.ILanguage language
     * @return xp.ide.lint.Error[]
     * @throws lang.IllegalArgumentException
     */
    public function checkSyntax(xp·ide·text·IInputStream $stream, xp·ide·lint·ILanguage $language) {
      throw new IllegalArgumentException('checkSyntax is not implemented for bash proxy');
    }
  }
?>
