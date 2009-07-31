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
   * Bash ide Proxy
   *
   * @purpose IDE
   */
  class xp·ide·proxy·Bash extends xp·ide·proxy·Proxy implements xp·ide·IXpIde {
    public function complete() {
    }

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param   string[] suggestions
     */
    public function grepClassFileUri(InputStream $stream, xp·ide·Cursor $cursor) {
      $result= array();
      do {
        try {
          $info= $this->ide->grepClassFileUri($stream, $cursor);
        } catch (IllegalArgumentException $e) {
          continue;
        } catch (xp·ide·resolve·NoSourceException $e) {
          Console::$err->writeLine($e->getMessage());
          continue;
        }
        list($scheme, $rest)= explode('://', $info->getUri(), 2);
        if ('file' !== $scheme) Console::$err->writeLine(sprintf('Cannot open class "%s" from location %s', $info->getSnippet()->getText(), $info->getUri()));
        $result[]= $rest;
      } while ($stream->available());
      Console::$out->write(implode(' ', $result));
    }

    public function lint() {
    }

  }
?>
