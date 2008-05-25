<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'math';
  
  uses('lang.Enum', 'math.Expression');

  /**
   * Constant
   *
   * @purpose  Expression
   */
  abstract class math·Constant extends Enum implements math·Expression {
    public static 
      $PI     = NULL,
      $E      = NULL,
      $EULER  = NULL;

    static function __static() {
      self::$PI= newinstance(__CLASS__, array(0, 'PI'), '{
        static function __static() { }
        public function evaluate() { return new Real(M_PI); }
      }');
      self::$E= newinstance(__CLASS__, array(1, 'E'), '{
        static function __static() { }
        public function evaluate() { return new Real(M_E); }
      }');
      self::$EULER= newinstance(__CLASS__, array(2, 'EULER'), '{
        static function __static() { }
        public function evaluate() { return new Real(M_EULER); }
      }');
    }

    /**
     * Returns all enum members
     *
     * @return  lang.Enum[]
     */
    public static function values() {
      return parent::membersOf(__CLASS__);
    }
  }
?>
