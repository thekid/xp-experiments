<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('text.csv.CellProcessor');

  /**
   * Returns cell values as booleans. The following mappings exist per
   * default:
   * <ul>
   *   <li>TRUE: true, 1, Y</li>
   *   <li>FALSE: false, 0, N</li>
   * </ul>
   *
   * Note: The values are recognized case-sensitively!
   *
   * @test    xp://net.xp_framework.unittest.text.csv.CellProcessorTest
   * @see     xp://text.csv.CellProcessor
   */
  class AsBool extends CellProcessor {
    protected $true= array();
    protected $false= array();
    
    /**
     * Creates a new instance of this processor.
     *
     * @param   string[] true
     * @param   string[] false
     */
    public function __construct($true= array('true', '1', 'Y'), $false = array('false', '0', 'N')) {
      $this->true= $true;
      $this->false= $false;
    }

    /**
     * Processes cell value
     *
     * @param   var in
     * @return  var
     * @throws  lang.FormatException if the string cannot be parsed
     */
    public function process($in) {
      if (in_array($in, $this->true, TRUE)) return TRUE;
      if (in_array($in, $this->false, TRUE)) return FALSE;
      throw new FormatException('Cannot parse "'.$in.'"');
    }
  }
?>
