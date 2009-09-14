<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('text.csv.CellProcessor');

  /**
   * Returns a default value if an empty string is encountered.
   *
   * @test    xp://net.xp_framework.unittest.text.csv.CellProcessorTest
   * @see     xp://text.csv.Required
   * @see     xp://text.csv.CellProcessor
   */
  class Optional extends CellProcessor {
    protected $default= NULL;
    protected $next= NULL;

    /**
     * Creates a new "Required" constraint
     *
     * @param   text.csv.CellProcessor
     */
    public function __construct(CellProcessor $next= NULL) {
      $this->next= $next;
    }

    /**
     * Set default when empty columns are encountered
     *
     * @param   var default
     * @return  text.csv.processors.Optional
     */
    public function withDefault($default) {
      $this->default= $default;
      return $this;
    }

    /**
     * Processes cell value
     *
     * @param   var in
     * @return  var
     * @throws  lang.FormatException
     */
    public function process($in) {
      if ('' === $in) {
        return $this->default;
      }
      return $this->next ? $this->next->process($in) : $in;
    }
  }
?>
