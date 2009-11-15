<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.wrapper';

  uses(
    'xp.ide.wrapper.Wrapper',
    'io.Folder',
    'lang.IllegalArgumentException'
  );

  /**
   * Bash ide Wrapper
   *
   * @purpose IDE
   */
  class xp·ide·wrapper·Bash extends xp·ide·wrapper·Wrapper {

    /**
     * complete the source under the cursor
     *
     * @param  xp.ide.Cursor cursor
     */
    #[@action(name='complete', args="Cursor")]
    public function complete(xp·ide·Cursor $cursor) {
      $response= $this->ide->complete($cursor, new Folder('file://'.getcwd()));
      $this->out->write(implode(PHP_EOL, $response->getSuggestions()));
    }

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  xp.ide.Cursor cursor
     */
    #[@action(name='grepclassfile', args="Cursor")]
    public function grepClassFileUri(xp·ide·Cursor $cursor) {
      $result= array();
      do {
        try {
          $response= $this->ide->grepClassFileUri($cursor, new Folder('file://'.getcwd()));
          list($scheme, $rest)= explode('://', $response->getUri(), 2);
          if ('file' !== $scheme) $this->err->write(sprintf('Cannot open class "%s" from location %s'.PHP_EOL, $response->getSnippet()->getText(), $response->getUri()));
          $result[]= $rest;
        } catch (IllegalStateException $e) {
          break;
        } catch (IllegalArgumentException $e) {
          continue;
        } catch (xp·ide·resolve·NoSourceException $e) {
          $this->err->write($e->getMessage().PHP_EOL);
          continue;
        }
      } while (TRUE);
      $this->out->write(implode(' ', $result));
    }
  }
?>
