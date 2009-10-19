<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.wrapper';

  uses(
    'xp.ide.IXpIde',
    'xp.ide.wrapper.Wrapper',
    'lang.IllegalArgumentException'
  );

  /**
   * Bash ide Wrapper
   *
   * @purpose IDE
   */
  class xp·ide·wrapper·Bash extends xp·ide·wrapper·Wrapper implements xp·ide·IXpIde {

    /**
     * complete the source under the cursor
     *
     * @param  xp.ide.Cursor cursor
     * @return xp.ide.completion.Response
     */
    public function complete(xp·ide·Cursor $cursor) {
      $response= $this->ide->complete($cursor);
      $this->out->write(implode(PHP_EOL, $response->getSuggestions()));
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
      $result= array();
      do {
        try {
          $response= $this->ide->grepClassFileUri($cursor);
        } catch (IllegalArgumentException $e) {
          continue;
        } catch (xp·ide·resolve·NoSourceException $e) {
          $this->err->write($e->getMessage().PHP_EOL);
          continue;
        }
        list($scheme, $rest)= explode('://', $response->getUri(), 2);
        if ('file' !== $scheme) $this->err->write(sprintf('Cannot open class "%s" from location %s'.PHP_EOL, $response->getSnippet()->getText(), $response->getUri()));
        $result[]= $rest;
      } while ($this->in->available());
      $this->out->write(implode(' ', $result));
      return $result;
    }

    /**
     * check syntax
     *
     * @param  xp.ide.lint.ILanguage language
     * @return xp.ide.lint.Error[]
     * @throws lang.IllegalArgumentException
     */
    public function checkSyntax(xp·ide·lint·ILanguage $language) {
      throw new IllegalArgumentException('checkSyntax is not implemented for bash wrapper');
    }
  }
?>
