<?php
  class Object {
    public function toString() {
      return var_export($this, 1);
    }
  }
  
  interface Comparable {
    public function compare($a, $b);
  }
  
  function oparray_string($ops, $indent= '  ') {
    if (!is_resource($ops)) {
      echo $indent;
      var_dump($ops);
      return;
    }
    foreach (oel_export_op_array($ops) as $opline) {
      switch ($opline->opcode->mne) {
        case 'FETCH_CLASS': $details= array($opline->op2->value); break;
        case 'DECLARE_INHERITED_CLASS': $details= array($opline->op2->value); break;
        case 'INIT_STATIC_METHOD_CALL': array($opline->op2->value); break;
        default: $details= NULL; // var_dump($opline);
      }
      printf(
        "%s@%-3d: <%03d> %s %s\n", 
        $indent,
        $opline->lineno,
        $opline->opcode->op,
        $opline->opcode->mne,
        $details ? '['.implode(', ', $details).']' : ''
      );
    }
  }
?>
