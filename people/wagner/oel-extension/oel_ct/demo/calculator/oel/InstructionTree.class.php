<?php

  $package= 'oel';

  uses(
    'oel.iVisitor',
    'oel.iAcceptor'
  );

  class oel·InstructionTree extends Object implements oel·iAcceptor {
    private
      $preInstructions= array();
    public
      $name=    "",
      $config=  array(),
      $is_root= 0;

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
     * @param   oel.iVisitor visitor
     */
    public function accept(oel·iVisitor $visitor) {
      foreach ($this->preInstructions as $instruction) $instruction->accept($visitor);
      return $visitor->visit($this);
    }
  }

?>
