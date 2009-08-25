<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
  $package="xp.ide.source";

  /**
   * source tree generator visitor
   * base object
   *
   * @purpose  IDE
   */
  class xp·ide·source·Generator extends Object {

    private
      $output_stream= NULL;

    public function __construct(OutputStream $output_stream) {
      $this->output_stream= $output_stream;
    }

    public function getOutputStream() {
      return $this->output_stream;
    }

    public function setOutputStream(OutputStream $output_stream) {
      $this->output_stream= $output_stream;
    }

    public function visit(xp·ide·source·Element $e) {
      $this->output_stream->write("<?php\n?>");
    }

  }

?>
