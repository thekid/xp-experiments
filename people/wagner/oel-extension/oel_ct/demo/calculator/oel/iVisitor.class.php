<?php

  $package= "oel";

  uses('oel.iAcceptor');

  interface oel·iVisitor {
    /**
     * handle an instruction
     *
     * @param   oel.iAcceptor acceptor
     * @return  mixed
     */
    public function visit(oel·iAcceptor $acceptor);
  }

?>
