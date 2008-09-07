<?php

  $package= "oel";

  uses('oel.iVisitor');

  interface oel·iAcceptor {
    /**
     * visit Instructions
     *
     * @param   oel.iVisitor visitor
     */
    public function accept(oel·iVisitor $visitor);
  }

?>
