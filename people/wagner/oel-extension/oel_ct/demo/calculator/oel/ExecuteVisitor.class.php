<?php

  $package= 'oel';

  uses(
    'oel.iVisitor',
    'oel.iAcceptor'
  );

  class oel텲xecuteVisitor extends Object implements oel톓Visitor {
    /**
     * execute an instruction
     *
     * @param   oel.iAcceptor acceptor
     * @return  mixed
     */
    public function visit(oel톓Acceptor $acceptor) {
      // visitor for oel텶nstructionTreeRoot
      if ($acceptor instanceof oel텶nstructionTreeRoot) {
        oel_finalize($acceptor->oparray);
        return oel_execute($acceptor->oparray);
      // visitor for oel텶nstructionTree
      } else if ($acceptor instanceof oel텶nstructionTree) {
        call_user_func_array($acceptor->name, $acceptor->config);
      }
    }
  }

?>
