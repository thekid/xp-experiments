<?php

  $package= 'oel';

  uses(
    'oel.InstructionTree'
  );

  class oel·InstructionTreeRoot extends oel·InstructionTree {
    public
      $oparray= NULL;

    /**
     * Constructor
     *
     * @param   string name
     * @param   resource(oel op array) oparray
     * @param   array config
     */
    public function __construct($oparray) {
      $this->oparray= $oparray;
    }

    /**
     * Get op array
     *
     * @return  resource(oel op array)
     */
    public function getOparray() {
      return $this->oparray;
    }

  }

?>
