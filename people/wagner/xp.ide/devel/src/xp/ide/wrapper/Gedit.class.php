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
   * Gedit ide Wrapper
   *
   * @purpose IDE
   */
  class xp·ide·wrapper·Gedit extends xp·ide·wrapper·Wrapper {

    /**
     * complete the source under the cursor
     *
     * @param  xp.ide.Cursor cursor
     */
    #[@action(name='complete', args="Cursor")]
    public function complete(xp·ide·Cursor $cursor) {
      $response= $this->ide->complete($cursor);
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
      $response= $this->ide->toggleClass($cursor);
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
      $response= $this->ide->grepClassFileUri($cursor);
      list($scheme, $rest)= explode('://', $response->getUri(), 2);
      if ('file' !== $scheme) throw new IllegalArgumentException(sprintf('Cannot open class "%s" from location %s', $response->getSnippet()->getText(), $response->getUri()));
      $this->out->write($response->getUri());
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
      $e= array_shift($errors);
      $this->out->write(
        $e->getLine().PHP_EOL
        .$e->getColumn().PHP_EOL
        .$e->getText().PHP_EOL
      );
      foreach ($errors as $e) {
        $this->out->write(sprintf(
          '- %d(%d): %s'.PHP_EOL,
          $e->getLine(),
          $e->getColumn(),
          $e->getText()
        ));
      }
    }

    /**
     * get class member info
     *
     */
    #[@action(name='memberInfo')]
    public function memberInfo() {
      $mis= $this->ide->memberInfo();
      foreach ($mis as $mi) {
        $this->out->write(sprintf('%d:%d:%s:%s:%s:%d:%d'.PHP_EOL,
          $mi->isFinal(),
          $mi->isStatic(),
          $mi->getScope()->name(),
          $mi->getName(),
          $mi->getType(),
          $mi->hasAccess(xp·ide·AccessorConfig::ACCESS_SET),
          $mi->hasAccess(xp·ide·AccessorConfig::ACCESS_GET)
        ));
      }
    }

    /**
     * create accessors
     *
     * @throw lang.IllegalArgumentException
     */
    #[@action(name='createAccessors')]
    public function createAccessors() {
      $confs= '';
      while (NULL !== $buf= $this->in->read()) $confs.= $buf;
      if (!$confs) return;

      $accInfos= array();
      foreach (explode(PHP_EOL, $confs) as $conf) {
        $parts= explode(':', $conf);
        if (5 !== count($parts)) throw new IllegalArgumentException(sprintf('cannot parse "%s" into five pieces', $conf));
        list($name, $type, $type2, $dim, $accs)= $parts;
        $accInfos[]= $accInfo= new xp·ide·AccessorConfig($name, $type, $type2, $dim);
        foreach (explode('+', $accs) as $acc) switch ($acc) {
          case 'set': $accInfo->addAccess(xp·ide·AccessorConfig::ACCESS_SET); break;
          case 'get': $accInfo->addAccess(xp·ide·AccessorConfig::ACCESS_GET); break;
        }
      }
      $this->ide->createAccessors($accInfos);
    }
  }
?>
