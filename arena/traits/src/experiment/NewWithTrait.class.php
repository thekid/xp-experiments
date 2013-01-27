<?php
  namespace experiment;

  function newinstance($spec, $args, $body= '{}') {
    sscanf($spec, "%[^ ] with %[^\r]", $class, $traits);
    $use= $impl= '';
    foreach (explode(',', $traits) as $trait) {
      $name= trim($trait);
      if (FALSE !== ($p= strrpos($name, '.'))) {
        $use.= 'use \\'.strtr(substr($name, 0, $p), '.', '\\').'\\__'.substr($name, $p+ 1).';';
      } else {
        $use.= 'use \\__'.$name.';';
      }
      $impl.= ', \\'.strtr($name, '.', '\\');
    }
    return \newinstance($class, $args, ' implements '.substr($impl, 2).' {'.$use.substr($body, 1));
  }
  
  class NewWithTrait extends \unittest\TestCase {

    #[@test]
    public function is_instanceof() {
      $this->assertInstanceOf('experiment.Enumerable', newinstance('lang.types.ArrayList with experiment.Enumerable', array()));
    }

    #[@test]
    public function map_method_available() {
      $fixture= newinstance('lang.types.ArrayList with experiment.Enumerable', array(1, 2, 3));
      $this->assertEquals(array(2, 4, 6), $fixture->map(function($e) { return $e * 2; }));
    }
  }
?>