<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.wrapper';

  uses(
    'xp.ide.wrapper.Wrapper',
    'xp.ide.AccessorConfig'
  );

  /**
   * Nedit ide Wrapper
   *
   * @purpose IDE
   */
  class xp·ide·wrapper·Nedit extends xp·ide·wrapper·Wrapper {

    /**
     * complete the source under the cursor
     *
     * @param  xp.ide.Cursor cursor
     */
    #[@action(name='complete', args="Cursor")]
    public function complete(xp·ide·Cursor $cursor) {
      $response= $this->ide->complete($cursor, new Folder('file://'.getcwd()));
      $this->out->write(
        $response->getSnippet()->getPosition().PHP_EOL
        .strlen($response->getSnippet()->getText()).PHP_EOL
        .count($response->getSuggestions()).PHP_EOL
        .implode(PHP_EOL, $response->getSuggestions())
      );
    }

    /**
     * toggle classname and class locator
     *
     * @param  xp.ide.Cursor cursor
     */
    #[@action(name='toggleClass', args="Cursor")]
    public function toggleClass(xp·ide·Cursor $cursor) {
      $response= $this->ide->toggleClass($cursor, new Folder('file://'.getcwd()));
      $this->out->write(
        $response->getSnippet()->getPosition().PHP_EOL
        .strlen($response->getSnippet()->getText()).PHP_EOL
        .$response->getToggle()
      );
    }

    /**
     * grep the file URI where the XP class
     * under the cursor if defined
     *
     * @param  xp.ide.Cursor cursor
     */
    #[@action(name='grepclassfile', args="Cursor")]
    public function grepClassFileUri(xp·ide·Cursor $cursor) {
      $response= $this->ide->grepClassFileUri($cursor, new Folder('file://'.getcwd()));
      list($scheme, $rest)= explode('://', $response->getUri(), 2);
      if ('file' !== $scheme) throw new IllegalArgumentException(sprintf('Cannot open class "%s" from location %s', $response->getSnippet()->getText(), $response->getUri()));
      $this->out->write($rest);
    }

    /**
     * check syntax
     *
     * @param  xp.ide.lint.ILanguage language
     */
    #[@action(name='checksyntax', args="Language")]
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
    }

    /**
     * create accessors
     *
     * @throw lang.IllegalArgumentException
     */
    #[@action(name='createAccessors')]
    public function createAccessors() {
      $mis= $this->ide->memberInfo();
      $accInfos= array();
      foreach ($mis as $mi) {
        $accInfos[]= $accInfo= new xp·ide·AccessorConfig($mi->getName(), $mi->getType(), 'lang.Object', 1);
        if (!$mi->hasAccess(xp·ide·AccessorConfig::ACCESS_SET)) $accInfo->addAccess(xp·ide·AccessorConfig::ACCESS_SET);
        if (!$mi->hasAccess(xp·ide·AccessorConfig::ACCESS_GET)) $accInfo->addAccess(xp·ide·AccessorConfig::ACCESS_GET);
      }
      return $this->ide->createAccessors($accInfos);
    }
  }
?>
