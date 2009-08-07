<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.proxy';

  uses(
    'xp.ide.IXpIde',
    'util.cmd.Console',
    'peer.URL'
  );

  /**
   * abstract ide Proxy
   *
   * @purpose IDE
   */
  abstract class xp·ide·proxy·Proxy extends Object {

    protected
      $ide= NULL;

    /**
     * constructor
     *
     */
    public function __construct(xp·ide·IXpIde $ide) {
      $this->ide= $ide;
    }

  }
?>
