<?php echo (20090115 > oel_get_zend_api_no()) ? "array(8) {\n" : "array(7) {\n"; ?>
  [0]=>
  object(OelOpline)#1 (1) {
    ["opcode"]=>
    object(OelOpcode)#2 (2) {
      ["op"]=>
      int(63)
      ["mne"]=>
      string(4) "RECV"
    }
  }
  [1]=>
  object(OelOpline)#3 (1) {
    ["opcode"]=>
    object(OelOpcode)#4 (2) {
      ["op"]=>
      int(38)
      ["mne"]=>
      string(6) "ASSIGN"
    }
  }
  [2]=>
  object(OelOpline)#5 (1) {
    ["opcode"]=>
    object(OelOpcode)#6 (2) {
      ["op"]=>
      int(59)
      ["mne"]=>
      string(18) "INIT_FCALL_BY_NAME"
    }
  }
  [3]=>
  object(OelOpline)#7 (1) {
    ["opcode"]=>
    object(OelOpcode)#8 (2) {
      ["op"]=>
      int(61)
      ["mne"]=>
      string(16) "DO_FCALL_BY_NAME"
    }
  }
  [4]=>
  object(OelOpline)#9 (1) {
    ["opcode"]=>
    object(OelOpcode)#10 (2) {
      ["op"]=>
      int(38)
      ["mne"]=>
      string(6) "ASSIGN"
    }
  }
  [5]=>
  object(OelOpline)#11 (1) {
    ["opcode"]=>
    object(OelOpcode)#12 (2) {
      ["op"]=>
      int(62)
      ["mne"]=>
      string(6) "RETURN"
    }
  }
  [6]=>
  object(OelOpline)#13 (1) {
    ["opcode"]=>
    object(OelOpcode)#14 (2) {
      ["op"]=>
      int(62)
      ["mne"]=>
      string(6) "RETURN"
    }
  }
<?php if (20090115 > oel_get_zend_api_no()) echo '  [7]=>
  object(OelOpline)#15 (1) {
    ["opcode"]=>
    object(OelOpcode)#16 (2) {
      ["op"]=>
      int(149)
      ["mne"]=>
      string(16) "HANDLE_EXCEPTION"
    }
  }
'; ?>
}
