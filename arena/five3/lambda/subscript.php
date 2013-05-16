<?php
  class String {
    protected $buffer;
    
    public function __construct($initial= '') {
      $this->buffer= $initial;
    }
  
    public function __invoke($offset) {
      sscanf($offset, '%d..%d', $begin, $end);
      return new self(substr($this->buffer, $begin, NULL === $end ? 1 : $end- $begin+ 1));
    }

    public function __toString() {
      return $this->buffer;
    }
  }

  class Vector {
    protected $elements;
    
    public function __construct($initial= array()) {
      $this->elements= $initial;
    }
  
    public function __invoke($offset) {
      sscanf($offset, '%d..%d', $begin, $end);
      return new self(array_slice($this->elements, $begin, NULL === $end ? 1 : $end- $begin+ 1));
    }

    public function __toString() {
      return '['.implode(', ', $this->elements).']';
    }
  }
  
  $s= new String('Hello');
  echo $s('0..1'), '/', $s('2..3'), '/', $s('-1'), "\n";
  
  $v= new Vector(array('one', 'two', 'three', 'four', 'five'));
  echo $v('0..1'), '/', $v('2..3'), '/', $v('-1'), "\n";
?>
