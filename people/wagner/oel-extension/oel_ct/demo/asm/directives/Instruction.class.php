<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 
  uses('lang.Enum');

  /**
   * (Insert class' description here)
   *
   * @ext      oel
   * @purpose  purpose
   */
  abstract class Instruction extends Enum {
    public static
      $noop,
      $pushval,
      $pushvar,
      $echo,
      $line,
      $free,
      $assign,
      $beginvar,
      $endvar,
      $begincall,
      $endcall,
      $pass;
    
    static function __static() {
      self::$noop= newinstance(__CLASS__, array(0, 'noop'), '{
        static function __static() { }
        
        public function emit($op, $args) {
          // NOOP
        }
      }');
      self::$pushval= newinstance(__CLASS__, array(1, 'pushval'), '{
        static function __static() { }
        
        public function emit($op, $args) {
          oel_push_value($op, $args[0]);
        }
      }');
      self::$pushvar= newinstance(__CLASS__, array(2, 'pushvar'), '{
        static function __static() { }
        
        public function emit($op, $args) {
          oel_push_variable($op, $args[0]);
        }
      }');
      self::$echo= newinstance(__CLASS__, array(3, 'echo'), '{
        static function __static() { }
        
        public function emit($op, $args) {
          oel_add_echo($op);
        }
      }');
      self::$line= newinstance(__CLASS__, array(4, 'line'), '{
        static function __static() { }
        
        public function emit($op, $args) {
          oel_set_source_line($op, $args[0]);
          oel_set_source_file($op, $args[1]);
        }
      }');
      self::$free= newinstance(__CLASS__, array(5, 'free'), '{
        static function __static() { }
        
        public function emit($op, $args) {
          oel_add_free($op);
        }
      }');
      self::$assign= newinstance(__CLASS__, array(6, 'assign'), '{
        static function __static() { }
        
        public function emit($op, $args) {
          oel_add_assign($op);
        }
      }');
      self::$beginvar= newinstance(__CLASS__, array(7, 'beginvar'), '{
        static function __static() { }
        
        public function emit($op, $args) {
          oel_add_begin_variable_parse($op);
        }
      }');
      self::$endvar= newinstance(__CLASS__, array(8, 'endvar'), '{
        static function __static() { }
        
        public function emit($op, $args) {
          oel_add_end_variable_parse($op);
        }
      }');
      self::$begincall= newinstance(__CLASS__, array(9, 'begincall'), '{
        static function __static() { }
        
        public function emit($op, $args) {
          oel_add_begin_function_call($op, $args[0]);
        }
      }');
      self::$endcall= newinstance(__CLASS__, array(10, 'endcall'), '{
        static function __static() { }
        
        public function emit($op, $args) {
          oel_add_end_function_call($op, $args[0]);
        }
      }');
      self::$pass= newinstance(__CLASS__, array(11, 'pass'), '{
        static function __static() { }
        
        public function emit($op, $args) {
          oel_add_pass_param($op, $args[0]);
        }
      }');
    }

    public abstract function emit($op, $args);
  }
?>
