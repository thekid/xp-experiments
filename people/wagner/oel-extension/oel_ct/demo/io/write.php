<?php
  if (!isset($argv[1])) $argv[1]= 'hello.php';
  
  define('M_STATIC', ReflectionMethod::IS_STATIC);
  define('M_FINAL', ReflectionMethod::IS_FINAL);
  define('M_PUBLIC', ReflectionMethod::IS_PUBLIC);
  define('M_PRIVATE', ReflectionMethod::IS_PRIVATE);
  define('M_PROTECTED', ReflectionMethod::IS_PROTECTED);

  // {{{ bool is(int modifiers, int mod)
  //     Returns whether mod is contained in modifiers
  function is($modifiers, $mod) {
    return ($modifiers & $mod) != 0;
  }
  // }}}

  // {{{ void add_reflection_export(resource op, string class) 
  //     Reflection::export(new ReflectionClass(class))
  function add_reflection_export($op, $class) {
    oel_push_value($op, $class);
    oel_add_new_object($op, 1, 'ReflectionClass');
    oel_add_call_method_static($op, 1, 'export', 'Reflection');
    oel_add_free($op);
  }
  // }}}
  
  // {{{ void add_echoln(resource op, string text) 
  //     echo $text."\n";
  function add_echoln($op, $text) {
    oel_push_value($op, $text."\n");
    oel_add_echo($op);
  }
  // }}}
  
  // {{{ void add_declare_class(resource op, string class, array<string, array> methods) 
  //     class class { <<methods>> }
  function add_declare_class($op, $class, $methods) {
    oel_add_begin_class_declaration($op, $class);
    
    foreach ($methods as $name => $def) {
      $mop= oel_new_method($op, $name, FALSE, is($def[0], M_STATIC), $def[0], is($def[0], M_FINAL)); {
        oel_set_source_file($mop, $def[1]);
        oel_set_source_line($mop, $def[2]);

        if (sizeof($def) > 3) {
          array_unshift($def[4], $mop);
          call_user_func_array($def[3], $def[4]);
        }
      }
      oel_finalize($mop);
    }
    oel_add_end_class_declaration($op);
  }
  // }}}

  // {{{ main
  $op= oel_new_op_array();
  oel_set_source_file($op, $argv[1]);
  oel_set_source_line($op, 1);

  switch ($argv[1]) {
    case 'reflect.php': {
      add_declare_class($op, 'HelloWorld', array(
        '__construct' => array(M_PRIVATE | M_FINAL, $argv[1], 3),
        'main'        => array(M_STATIC | M_PUBLIC, $argv[1], 5)
      ));
      add_reflection_export($op, 'HelloWorld');
      break;
    }

    case 'class.php': {
      add_declare_class($op, 'HelloWorld', array(
        'main' => array(M_STATIC | M_PUBLIC, $argv[1], 3, 'add_echoln', array('Hello Class'))
      ));
      oel_add_call_method_static($op, 0, 'main', 'HelloWorld');
      oel_add_free($op);
      break;
    }
    
    case 'hello.php': {
      add_echoln($op, 'Hello World');
    }
  }

  oel_finalize($op);
  
  $fd= fopen($argv[1], 'wb');
  oel_write_header($fd);
  oel_write_op_array($fd, $op);
  fclose($fd);
  // }}}
?>
