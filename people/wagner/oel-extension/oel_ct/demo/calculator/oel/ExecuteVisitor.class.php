<?php

  $package= 'oel';

  uses(
    'oel.iVisitor',
    'oel.iAcceptor'
  );

  class oel·ExecuteVisitor extends Object implements oel·iVisitor {
    private
      $oparray= NULL;

    /**
     * Constructor
     *
     * @param   resource(oel op array) oparray
     */
    public function __construct($oparray) {
      $this->oparray= $oparray;
    }

    /**
     * execute an instruction
     *
     * @param   oel.iAcceptor acceptor
     * @return  mixed
     */
    public function visit(oel·iAcceptor $acceptor) {
      foreach ($acceptor->preInstructions as $instruction) $instruction->accept($this);
      if ($acceptor->is_root) {
        oel_finalize($this->oparray);
        return oel_execute($this->oparray);
      } else {
        $params= $acceptor->config;
        array_unshift($params, $this->oparray);
        call_user_func_array($acceptor->name, $params);
      }
    }
  }

?>
