<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('text.csv.CellProcessor');

  /**
   * Formats bools as cell values
   *
   * @test    xp://net.xp_framework.unittest.text.csv.CellProcessorTest
   * @see     xp://text.csv.CellProcessor
   */
  class FormatBool extends CellProcessor {
    protected $true= '';
    protected $false= '';

    /**
     * Creates a new bool formatter
     *
     * @param   string true
     * @param   string false
     */
    public function __construct($true= 'true', $false= 'false') {
      $this->true= $true;
      $this->false= $false;
    }
    
    /**
     * Processes cell value
     *
     * @param   var in
     * @return  var
     * @throws  lang.FormatException
     */
    public function process($in) {
      return $in ? $this->true : $this->false;
    }
  }
?>
