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
      $in= NULL,
      $out= NULL,
      $err= NULL,
      $ide= NULL;

    /**
     * constructor
     *
     * @param xp.ide.IXpIde
     */
    public function __construct(xp·ide·IXpIde $ide) {
      $this->ide= $ide;
      $this->in= $this->ide->getIn();
    }

    /**
     * set input stream
     *
     * @param  xp.ide.text.IInputStream stream
     */
    public function setIn(xp·ide·text·IInputStream $in) {
      $this->in= $in;
    }

    /**
     * get input stream
     *
     * @return xp.ide.text.IInputStream
     */
    public function getIn() {
      return $this->in;
    }

  }
?>
