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
    public function complete() {
    }

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param   string[] suggestions
     */
    public function grepClassFileUri(InputStream $stream, xp·ide·Cursor $cursor) {
      $info= $this->ide->grepClassFileUri($stream, $cursor);
      list($scheme, $rest)= explode('://', $info->getUri(), 2);
      if ('file' !== $scheme) throw new IllegalArgumentException(sprintf('Cannot open class "%s" from location %s', $info->getSnippet()->getText(), $info->getUri()));
      Console::$out->write($info->getUri());
    }

    public function lint() {
    }

  }
?>
