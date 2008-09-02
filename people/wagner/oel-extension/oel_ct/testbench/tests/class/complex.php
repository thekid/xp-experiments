-- init:
<?php

interface IclassA {
  public function methA($a);
}

abstract class AclassA implements IclassA {
  public function methA($a) {}
  abstract public function methB($a);
  public abstract static function methC($a);
}

class classA extends AclassA {

  var $memberA= "memA";
  static $memberB= "memB(stat)";
  const constA= "contA";

  public function setMemA($memA) {
    $this->memberA= $memA;
  }

  public function setMemA2ConstA() {
    $this->memberA= self::constA;
  }

  public function setMemB($memB) {
    self::$memberB= $memB;
  }

  public function getMemA() {
    return $this->memberA;
  }

  public function getMemAMemA() {
    return $this->memberA->memberA;
  }

  public function methA($a) {
    echo "\n--- ";
    echo $a;
    echo " ---\n\n";
    return $a;
  }
  public function methB($a) {}
  public static function methC($a) {}
}

  $f= new classA();
  $g= new classA();
?>

-- memberA:
<?php
  var_dump($f->memberA);
  var_dump($f->getMemA());
  var_dump($f->setMemA($g));
  var_dump($f->getMemA());
  var_dump($f->getMemAMemA());
?>

-- memberB:
<?php
  var_dump(classA::$memberB);
  var_dump($f->setMemB("memB -- neu"));
  var_dump(classA::$memberB);
?>

-- consA:
<?php
  var_dump(classA::constA);
  var_dump($f->getMemA());
  var_dump($f->setMemA2ConstA());
  var_dump($f->getMemA());
?>
