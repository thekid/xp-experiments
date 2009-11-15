<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('collections.IDictionary');

  /**
   * Lookup map
   *
   */
  #[@generic(self= 'K, V', IDictionary= 'K, V')]
  abstract class AbstractDictionary extends Object implements IDictionary {
    
    /**
     * Constructor
     *
     * @param   array<string, var> initial
     */
    public function __construct($initial= array()) {
      foreach ($initial as $key => $value) {
        $this->put($key, $value);
      }
    }
  }
?>
