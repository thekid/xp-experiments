<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.Enum');

  /**
   * Aggregations
   *
   * @test     xp://net.xp_framework.unittest.math.AggregationTest
   * @see      http://en.wikipedia.org/wiki/Median
   * @see      php://min
   * @see      php://max
   */
  abstract class Aggregation extends Enum {
    public static
      $AVERAGE,
      $MEDIAN,
      $MAXIMUM,
      $MINIMUM;
    
    static function __static() {
      self::$AVERAGE= newinstance(__CLASS__, array(0, 'AVERAGE'), '{
        static function __static() {}
        public function calculate(array $values) {
          return array_sum($values) / sizeof($values);
        }
      }');
      self::$MEDIAN= newinstance(__CLASS__, array(1, 'MEDIAN'), '{
        static function __static() {}
        public function calculate(array $values) {
          sort($values);
          $s= sizeof($values);
          if ($s % 2 != 0) {
            return $values[(($s+ 1) / 2)- 1];
          } else {
            return 0.5 * ($values[intval($s / 2)- 1] + $values[intval($s / 2)]);
          }
        }
      }');
      self::$MAXIMUM= newinstance(__CLASS__, array(2, 'MAXIMUM'), '{
        static function __static() {}
        public function calculate(array $values) {
          return max($values);
        }
      }');
      self::$MINIMUM= newinstance(__CLASS__, array(3, 'MINIMUM'), '{
        static function __static() {}
        public function calculate(array $values) {
          return min($values);
        }
      }');
    }

    /**
     * Calculates aggregation of a list of values
     *
     * @param   var[] values
     * @return  var
     */
    public abstract function calculate(array $values);
    
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
