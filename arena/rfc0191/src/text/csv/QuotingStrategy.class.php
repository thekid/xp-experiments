<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Quoting strategy
   *
   */
  interface QuotingStrategy {
    
    /**
     * Tests whether quoting is necessary
     *
     * @param   string value
     * @param   string delimiter
     * @param   string quote
     * @return  bool
     */
    public function necessary($value, $delimiter, $quote);
    
  }
?>
