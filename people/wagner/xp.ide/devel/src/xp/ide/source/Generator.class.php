<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
  $package="xp.ide.source";

  uses(
    'io.streams.StringWriter'
  );

  /**
   * source tree generator visitor
   * base object
   *
   * @purpose  IDE
   */
  class xp·ide·source·Generator extends Object {

    private
      $output_stream= NULL,
      $out= NULL,
      $indent= 0,
      $iSign= '  ';

    public function __construct(OutputStream $output_stream) {
      $this->output_stream= $output_stream;
      $this->out= new StringWriter($this->output_stream);
    }

    public function getOutputStream() {
      return $this->output_stream;
    }

    public function setOutputStream(OutputStream $output_stream) {
      $this->output_stream= $output_stream;
      $this->out= new StringWriter($this->output_stream);
    }

    private function indention() {
      $this->out->write(str_repeat($this->iSign, $this->indent));
    }

    public function visit(xp·ide·source·Element $e) {
      switch ($e->getClassName()) {
        case 'xp.ide.source.element.ClassFile':    return $this->visitClassFile($e);
        case 'xp.ide.source.element.Package':      return $this->visitPackage($e);
        case 'xp.ide.source.element.BlockComment': return $this->visitBlockComment($e);
        case 'xp.ide.source.element.Uses':         return $this->visitUses($e);
        case 'xp.ide.source.element.Classdef':     return $this->visitClassdef($e);
      }
    }

    private function visitClassFile($e) {
      $this->out->writeLine('<?php');
      if ($e->getHeader()) {
        $this->visit($e->getHeader());
        $this->out->writeLine('');
      }
      $this->indent++;
      if ($e->getPackage()) {
        $this->visit($e->getPackage());
        $this->out->writeLine('');
        $this->out->writeLine('');
      }
      if ($e->getUses()) {
        $this->visit($e->getUses());
        $this->out->writeLine('');
      }
      if ($e->getClassdef()) {
        $this->visit($e->getClassdef());
        $this->out->writeLine('');
      }
      $this->indent--;
      $this->out->write('?>');
    }

    private function visitPackage($e) {
      $this->indention();
      $this->out->writef("\$package= '%s';", $e->getName());
    }

    private function visitBlockComment($e) {
      $this->out->write('/*');
      for ($i= 0, $lines= explode(PHP_EOL, $e->getText()), $m= sizeOf($lines); $i < $m; $i++) {
        if (0 !== $i) {
          $this->out->writeLine('');
          $this->indention();
        }
        $this->out->write($lines[$i]);
      }
      $this->out->write('*/');
    }

    private function visitUses($e) {
      $this->indention();
      $this->out->writeLine('uses(');
      $this->indent++;
      for ($i= 0, $lines= $e->getClassnames(), $m= sizeOf($lines); $i < $m; $i++) {
        $this->indention();
        $this->out->writef("'%s'", $lines[$i]);
        if ($i !== $m - 1) $this->out->write(',');
        $this->out->writeLine('');
      }
      $this->indent--;
      $this->indention();
      $this->out->write(');');
    }

    private function visitClassdef($e) {
      $this->indention();
      $this->out->writef('class %s extends %s {}', $e->getName(), $e->getParent());
    }

  }

?>
