-- init:
<?php
  $op_a= oel_new_op_array();

// --interface IclassA {
  oel_add_begin_interface_declaration($op_a, "IclassA");
// --  public function methA($a);
    $meth_ia= oel_new_method($op_a, "methA");
    oel_add_receive_arg($meth_ia, 1, "a");
// --}
  oel_add_end_interface_declaration($op_a);


// --abstract class AclassA implements IclassA {
  oel_add_begin_abstract_class_declaration($op_a, "AclassA");
    oel_add_implements_interface($op_a, "IclassA");

// --  public function methA($a) {}
    $meth_aa= oel_new_method($op_a, "methA");
    oel_add_receive_arg($meth_aa, 1, "a");

// --  abstract public function methB($a);
    $meth_ab= oel_new_abstract_method($op_a, "methB");
    oel_add_receive_arg($meth_ab, 1, "a");

// --  abstract public static function methC($a);
    $meth_ac= oel_new_abstract_method($op_a, "methC", FALSE, TRUE);
    oel_add_receive_arg($meth_ac, 1, "a");

// --}
  oel_add_end_abstract_class_declaration($op_a);


// --class classA extends AclassA {
  oel_add_begin_class_declaration($op_a, "classA", "AclassA");
// --  var $memberA= "memA";
    oel_add_declare_property($op_a, "memberA", "memA");
// --  static $memberB= "memB(stat)";
    oel_add_declare_property($op_a, "memberB", "memB(stat)", TRUE);
// --  const constA= "contA";
    oel_add_declare_class_constant($op_a, "constA", "contA");

// --  public function setMemA($memA) {
    $meth_a= oel_new_method($op_a, "setMemA");
    oel_add_receive_arg($meth_a, 1, "memA");
// --    $memA->memberA= $memA;
    oel_add_begin_variable_parse($meth_a);
    oel_push_variable($meth_a, "memA");
    oel_add_end_variable_parse($meth_a);
    oel_add_begin_variable_parse($meth_a);
    oel_push_variable($meth_a, "this");
    oel_push_property($meth_a, "memberA");
    oel_add_assign($meth_a);
    oel_add_free($meth_a);
// --  }

// --  public function setMemA2ConstA() {
    $meth_b= oel_new_method($op_a, "setMemA2ConstA");
// --    $memA->memberA= self::constA;
    oel_push_constant($meth_b, "constA", "self");

    oel_add_begin_variable_parse($meth_b);
    oel_push_variable($meth_b, "this");
    oel_push_property($meth_b, "memberA");

    oel_add_assign($meth_b);
    oel_add_free($meth_b);
// --  }

// --  public function setMemB($memB) {
    $meth_c= oel_new_method($op_a, "setMemB");
    oel_add_receive_arg($meth_c, 1, "memB");
// --    self::memberB= $memB;
    oel_add_begin_variable_parse($meth_c);
    oel_push_variable($meth_c, "memB");
    oel_add_end_variable_parse($meth_c);
    oel_add_begin_variable_parse($meth_c);
    oel_push_variable($meth_c, "memberB", "self");
    oel_add_assign($meth_c);
    oel_add_free($meth_c);
// --  }

// --  public function getMemA() {
    $meth_d= oel_new_method($op_a, "getMemA");
// --    return $this->memberA;
    oel_add_begin_variable_parse($meth_d);
    oel_push_variable($meth_d, "this");
    oel_push_property($meth_d, "memberA");
    oel_add_return($meth_d);
// --  }

// --  public function getMemAMemA() {
    $meth_e= oel_new_method($op_a, "getMemAMemA");
// --    return $this->memberA->memberA;
    oel_add_begin_variable_parse($meth_e);
    oel_push_variable($meth_e, "this");
    oel_push_property($meth_e, "memberA");
    oel_push_property($meth_e, "memberA");
    oel_add_return($meth_e);
// --  }

// --  public function methA($a) {
    $meth_f= oel_new_method($op_a, "methA");
    oel_add_receive_arg($meth_f, 1, "a");
// --    echo "\n--- ";
    oel_push_value($meth_f, "-- ");
    oel_add_echo($meth_f);
// --    echo $a;
    oel_add_begin_variable_parse($meth_f);
    oel_push_variable($meth_f, "a");
    oel_add_end_variable_parse($meth_f);
    oel_add_echo($meth_f);
// --    echo " ---\n\n";
    oel_push_value($meth_f, " ---\n\n");
    oel_add_echo($meth_f);
// --    return $a;
    oel_add_begin_variable_parse($meth_f);
    oel_push_variable($meth_f, "a");
    oel_add_return($meth_f);
// --  }

// --  public function methB($a) {}
    $meth_g= oel_new_method($op_a, "methB");
    oel_add_receive_arg($meth_g, 1, "a");

// --  public static function methC($a) {}
    $meth_h= oel_new_method($op_a, "methC", FALSE, TRUE);
    oel_add_receive_arg($meth_h, 1, "a");

// --}
  oel_add_end_class_declaration($op_a);

  oel_finalize($op_a);
  oel_execute($op_a);

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
