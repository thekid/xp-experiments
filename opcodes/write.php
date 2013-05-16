<?php
  define('ZVAL_PTR_DTOR',           1);
  define('ZEND_FUNCTION_DTOR',      2);
  define('ZEND_CLASS_DTOR',         3);
  define('ZEND_MODULE_DTOR',        4);
  define('ZEND_CONSTANT_DTOR',      5);
  define('free_estring',            6);
  define('list_entry_destructor',   7);
  define('plist_entry_destructor',  8);

  function apc_serialize_int($i) {
    return pack('i', $i);
  }

  function apc_serialize_uint($i) {
    return pack('I', $i);
  }

  function apc_serialize_ulong($i) {
    return pack('L', $i);
  }

  function apc_serialize_long($i) {
    return pack('I', $i);
  }

  function apc_serialize_ushort($s) {
    return pack('S', $s);
  }

  function apc_serialize_char($c) {
    return pack('c', $c);
  }

  function apc_serialize_uchar($c) {
    return pack('C', $c);
  }

  function apc_serialize_bool($b) {
    return $b ? "\1" : "\0";
  }

  function apc_serialize_string($str) {
    return (0 == ($l= strlen($str))) 
      ? apc_serialize_int(-1) 
      : apc_serialize_int($l).$str
    ;
  }
  
  function apc_serialize_arg_info($arg_info) {
    // XXX
  }
  
  function apc_serialize_zval($zval, $node= NULL) {
    switch (gettype($zval)) {
      case 'NULL': 
        $s= apc_serialize_uchar('0');   // IS_NULL
        if ($node) {
          $s.= apc_serialize_uint(0).apc_serialize_uint(0);   // u.EA.var & u.EA.type
        }
        $s.= apc_serialize_long(0);
        break;
      
      // XXX TBI
      
      default:
        die('Unknown type '.gettype($zval));
    }
    
    $s.= apc_serialize_uchar('1');   // is_ref    XXX
    $s.= apc_serialize_ushort(2);    // refcount  XXX
    return $s;
  }
  
  function apc_serialize_znode($node) {
    if (NULL === $node) $node= array('type' => 8);

    $s= apc_serialize_int($node['type']);
    switch ($node['type']) {
      case 1:       // IS_CONST
        return $s.apc_serialize_zval($node['constant'], $node);
      
      case 2:       // IS_TMP_VAR
      case 4:       // IS_VAR
      case 8:       // IS_UNUSED
      case 16:      // IS_CV
        $s.= apc_serialize_uint(0);   // u.EA.var
        $s.= apc_serialize_uint(0);   // u.EA.type
        return $s;
    }
  }
  
  function apc_serialize_op($opcode) {
    $s= apc_serialize_char($opcode['number']);
    $s.= apc_serialize_znode($opcode['result']);
    $s.= apc_serialize_znode($opcode['op1']);
    $s.= apc_serialize_znode($opcode['op2']);
    $s.= apc_serialize_ulong($opcode['extended_value']);
    $s.= apc_serialize_uint($opcode['lineno']);
    
    return $s;
  }

  function apc_serialize_op_array($op_array) {
    $s= apc_serialize_char('2');        // oparray_type

    // Arguments
    $s.= apc_serialize_int(sizeof($op_array['args']));
    foreach ($op_array['args'] as $arg) {
      $s.= apc_serialize_arg_info($op_array['args']);
    }
    
    // Function
    $s.= apc_serialize_string($op_array['function_name']);

    // Some details
    $s.= apc_serialize_int(1);                   // refcount
    
    // Opcodes
    $size= sizeof($op_array['opcodes']);
    $s.= apc_serialize_uint($size);              // last
    $s.= apc_serialize_uint($size);              // size

    for ($i= 0; $i < $size; $i++) {
      $s.= apc_serialize_op($op_array['opcodes'][$i]);
    }
    
    $s.= apc_serialize_uint(0);                  // T
    $s.= apc_serialize_uint(0);                  // last_brk_cont
    $s.= apc_serialize_uint(-1);                 // current_brk_cont
    $s.= apc_serialize_bool(FALSE);              // uses_globals
    $s.= apc_serialize_char('0');                // brk_cont_array != NULL ? 1 : 0
    // FIXME TOO MUCH? $s.= '*'; apc_serialize_hash(NULL, ZVAL_PTR_DTOR, 'apc_serialize_zval');
    $s.= apc_serialize_bool(FALSE);              // return_reference
    $s.= apc_serialize_bool(TRUE);               // done_pass_two
    $s.= apc_serialize_string($op_array['filename']);
    $s.= apc_serialize_string($op_array['scope']);
    $s.= apc_serialize_uint(65792);              // fn_flags (65792 = XXX?!)
    $s.= apc_serialize_uint(0);                  // required_num_args
    $s.= apc_serialize_bool(FALSE);              // pass_rest_by_reference
    $s.= apc_serialize_int(0);                   // backpatch_count
    $s.= apc_serialize_bool(FALSE);              // uses_this
    
    $s.= apc_serialize_int(0);                   // last_var
    $s.= apc_serialize_int(0);                   // size_var
    
    // Try/catch
    if (0) {
      // SERIALIZE_SCALAR(zoa->last_try_catch, int);
      // STORE_BYTES(zoa->try_catch_array, zoa->last_try_catch * sizeof(zend_try_catch_element));
    } else {
      $s.= apc_serialize_int(0);
    }
    
    return $s;
  }
  
  function apc_serialize_method($value) {
    $s= apc_serialize_char('2');    // ZEND_USER_FUNCTION
    
    // ftype (a bitfield)
    //   constructor      ftype |= 0x01
    //   destructor       ftype |= 0x02
    //   clone            ftype |= 0x04
    //   __get            ftype |= 0x08
    //   __set            ftype |= 0x10
    //   __call           ftype |= 0x20
    //   __unset          ftype |= 0x40
    //   __isset          ftype |= 0x80
    //   serialize_func   ftype |= 0x100
    //   unserialize_func ftype |= 0x200
    $s.= apc_serialize_int(0);

    $s.= apc_serialize_op_array($value['op_array']);
    return $s;
  }

  // DJBX33A (Daniel J. Bernstein, Times 33 with Addition)
  function hashof($str) {
    $hash= 5381;
    $offset= 0;
    for ($len= strlen($str); $len >= 8; $len-= 8) {
      $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      $hash= (($hash << 5) + $hash) + ord($str{$offset++});
    }

    switch ($len) {
      case 7: $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      case 6: $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      case 5: $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      case 4: $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      case 3: $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      case 2: $hash= (($hash << 5) + $hash) + ord($str{$offset++});
      case 1: $hash= (($hash << 5) + $hash) + ord($str{$offset++});
    }
    return $hash;
  }
  
  function apc_serialize_hash($hash, $dtor, $func) {
    if (NULL === $hash) return apc_serialize_char('0');
    $s= apc_serialize_char('1');
    
    $s.= apc_serialize_uint(8);             // nTableSize
    $s.= apc_serialize_ulong($dtor);        // pDestructor_idx
    $s.= apc_serialize_uint(sizeof($hash)); // nNumOfElements
    $s.= apc_serialize_int(0);              // persistent
    
    foreach ($hash as $key => $value) {
      $s.= apc_serialize_ulong(hashof($key."\0"));
      $s.= apc_serialize_uint(strlen($key)+ 1);
      $s.= apc_serialize_string($key."\0");
      
      $s.= $func($value);
    }

    // TODO
    return $s;
  }

  $fd= fopen('input.Try.class', 'wb');
  
  // Header
  fwrite($fd, apc_serialize_string('bcompiler v0.18s'));
  fwrite($fd, apc_serialize_char('1'));   // ?
  
  // Class
  fwrite($fd, apc_serialize_char('2'));   // ZEND_USER_CLASS
  fwrite($fd, apc_serialize_string('input·Try'));
  fwrite($fd, apc_serialize_uint(strlen('input·Try')));
  
  // Extends
  if (1) {
    fwrite($fd, apc_serialize_char('1'));
    fwrite($fd, apc_serialize_string('Object'));
  } else {
    fwrite($fd, apc_serialize_char('0'));
  }
  
  // Some details
  fwrite($fd, apc_serialize_int(1));      // refcount
  fwrite($fd, apc_serialize_bool(FALSE)); // constants_updated
  fwrite($fd, apc_serialize_uint(0));     // ce_flags
  
  // Function table
  $methods= array(
    'main' => array(
      'op_array' => array(
        'args'              => array(),
        'function_name'     => 'main',
        'filename'          => 'Command line code',
        'scope'             => 'InputTry',
        'static_variables'  => array(),
        'opcodes'           => array(
          array(
            'number'          => 62,            // ZEND_RETURN
            'op1'             => array('type' => 1, 'constant' => NULL),    // 1 == IS_CONST
            'op2'             => NULL,
            'result'          => NULL,
            'extended_value'  => 0,
            'lineno'          => 1
          ),
          array(
            'number'          => 149,           // ZEND_HANDLE_EXCEPTION
            'op1'             => NULL,
            'op2'             => NULL,
            'result'          => NULL,
            'extended_value'  => 0,
            'lineno'          => 1
          )
        )
      )
    )
  );
  fwrite($fd, apc_serialize_hash($methods, ZEND_FUNCTION_DTOR, 'apc_serialize_method'));  

  // Variables
  fwrite($fd, apc_serialize_hash(array(), ZVAL_PTR_DTOR, 'apc_serialize_zval'));  

  // Property-info
  fwrite($fd, apc_serialize_hash(array(), 0, 'apc_serialize_zval'));  

  // Default static members
  fwrite($fd, apc_serialize_hash(array(), ZVAL_PTR_DTOR, 'apc_serialize_zval'));  

  // Statics
  fwrite($fd, apc_serialize_hash(NULL, ZVAL_PTR_DTOR, 'apc_serialize_zval'));  

  // Constants
  fwrite($fd, apc_serialize_hash(array(), ZVAL_PTR_DTOR, 'apc_serialize_zval'));
  
  // Builtin functions none, this is a userland class)
  fwrite($fd, apc_serialize_int(0));
  
  // Number of Interfaces
  fwrite($fd, apc_serialize_uint(0));

  // force_key ???
  fwrite($fd, apc_serialize_char('0'));

  // Footer
  fwrite($fd, apc_serialize_char('0'));
  
  fclose($fd);
?>
