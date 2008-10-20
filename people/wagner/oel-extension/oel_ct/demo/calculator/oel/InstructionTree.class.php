<?php

  $package= 'oel';

  uses(
    'util.Visitor',
    'oel.iAcceptor'
  );

  class oel·InstructionTree extends Object implements oel·iAcceptor {
    public
      $preInstructions= array(),
      $name=            "",
      $config=          array(),
      $is_root=         0;

    /**
     * Constructor
     *
     * @param   string name
     * @param   array config
     * @param   bool  is_root
     */
    public function __construct($name, Array $config, $is_root= FALSE) {
      $this->name=    $name;
      $this->config=  $config;
      $this->is_root= $is_root;
    }

    /**
     * inset instruction that will be visited before this one
     *
     * @param   self instruction
     */
    public function addPreInstruction(self $instruction) {
      $this->preInstructions[]= $instruction;
    }

    /**
     * visit Instructions
     *
     * @param   util.Visitor visitor
     */
    public function accept(Visitor $visitor) {
      return $visitor->visit($this);
    }
  }

?>
