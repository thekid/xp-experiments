<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.EvaluationError');
  
  /**
   * Function base class
   *
   * @purpose  Base class
   */
  abstract class math·functions·Function extends Object {

    /**
     * Throws an EvaluationError
     *
     * @param   string file
     * @param   int line
     * @throws  math.EvaluationError
     */
    protected static function raiseError($file, $line) {
      throw new EvaluationError(implode(', ', array_keys(xp::$registry['errors'][$file][$line])));
    }
  }
?>
