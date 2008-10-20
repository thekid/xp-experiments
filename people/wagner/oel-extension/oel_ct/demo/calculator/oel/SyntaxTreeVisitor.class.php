<?php

  $package= 'oel';

  uses(
    'util.Visitor',
    'oel.DebugVisitor'
  );

  class oel·SyntaxTreeVisitor extends oel·DebugVisitor implements Visitor {
    private
      $depth= 0;

    /**
     * execute an instruction
     *
     * @param   oel.iAcceptor acceptor
     */
    public function visit($acceptor) {
      if (!$acceptor->is_root) {
        printf("%s%s(%s)\n", str_repeat('    ', $this->depth), $acceptor->name, $this->paramString($acceptor->config));
      }
      $this->depth++;
      foreach ($acceptor->preInstructions as $instruction) $instruction->accept($this);
      $this->depth--;
    }
  }

?>
