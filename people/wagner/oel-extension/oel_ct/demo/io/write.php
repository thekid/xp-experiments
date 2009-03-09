<?php
  require('common.inc.php');

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
  
  // {{{ void add_declare_class(resource op, string class, string parent, array<string, array> methods) 
  //     class class { <<methods>> }
  function add_declare_class($op, $class, $parent= NULL, $interfaces= array(), $methods= array()) {
    echo $class, " {\n";
    oel_add_begin_class_declaration($op, $class, $parent);
    
    foreach ($interfaces as $interface) {
      oel_add_implements_interface($op, $interface);
    }
    
    foreach ($methods as $name => $def) {
      $mop= oel_new_method($op, $name, FALSE, is($def[0], M_STATIC), $def[0], is($def[0], M_FINAL)); {
        oel_set_source_file($mop, $def[1]);
        oel_set_source_line($mop, $def[2]);
        
        // Args
        foreach ($def[3] as $i => $arg) {
          oel_add_receive_arg($mop, $i + 1, $arg);
        }
        
        // Create body from "closure"
        if (sizeof($def) > 4) {
          array_unshift($def[5], $mop);
          call_user_func_array($def[4], $def[5]);
        }
      }
      oel_finalize($mop);
      
      echo '  ::', $name, "() {\n", oparray_string($mop, '    '), "  }\n";
    }
    oel_add_end_class_declaration($op);
    
    echo "}\n";
  }
  // }}}

  // {{{ main
  $op= oel_new_op_array();
  oel_set_source_file($op, $argv[1]);
  oel_set_source_line($op, 1);

  switch ($argv[1]) {
    case 'reflect.php': {
      add_declare_class($op, 'HelloWorld', 'Object', array('Comparable'), array(
        '__construct' => array(M_PRIVATE | M_FINAL, $argv[1], 3, array('param', 'default')),
        'main'        => array(M_STATIC | M_PUBLIC, $argv[1], 5, array()),
        'compare'     => array(M_PUBLIC, $argv[1], 6, array('a', 'b'))
      ));
      oel_set_source_line($op, 3);
      add_reflection_export($op, 'HelloWorld');
      break;
    }

    case 'class.php': {
      add_declare_class($op, 'HelloWorld', NULL, array(), array(
        'main' => array(M_STATIC | M_PUBLIC, $argv[1], 3, array(), 'add_echoln', array('Hello Class'))
      ));
      oel_set_source_line($op, 5);
      oel_add_call_method_static($op, 0, 'main', 'HelloWorld');
      oel_add_free($op);
      break;
    }

    case 'parent.php': {
      add_declare_class($op, 'HelloWorld', 'Object', array(), array(
        'main'    => array(M_STATIC | M_PUBLIC, $argv[1], 3, array(), 'add_echoln', array('Hello Parent')),
        'compare' => array(M_PUBLIC, $argv[1], 5, array('a', 'b'))
      ));
      oel_set_source_line($op, 7);
      oel_add_call_method_static($op, 0, 'main', 'HelloWorld');
      oel_add_free($op);
      break;
    }

    case 'interface.php': {
      add_declare_class($op, 'HelloWorld', NULL, array('Comparable'), array(
        'main'    => array(M_STATIC | M_PUBLIC, $argv[1], 3, array(), 'add_echoln', array('Hello Interface')),
        'compare' => array(M_PUBLIC, $argv[1], 5, array('a', 'b'))
      ));
      oel_set_source_line($op, 7);
      oel_add_call_method_static($op, 0, 'main', 'HelloWorld');
      oel_add_free($op);
      break;
    }
    
    case 'hello.php': {
      add_echoln($op, 'Hello World');
    }
  }

  oel_finalize($op);
  echo "<main> {\n", oparray_string($op), "}\n";
  
  $fd= fopen($argv[1], 'wb');
  oel_write_header($fd);
  oel_write_op_array($fd, $op);
  fclose($fd);
  // }}}
?>
