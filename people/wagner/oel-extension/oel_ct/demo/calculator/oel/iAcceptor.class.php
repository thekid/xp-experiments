<?php

  $package= "oel";

  uses('util.Visitor');

  interface oel·iAcceptor {
    /**
     * visit Instructions
     *
     * @param   util.Visitor visitor
     */
    public function accept(Visitor $visitor);
  }

?>
