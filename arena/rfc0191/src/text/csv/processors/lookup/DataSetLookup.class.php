<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('text.csv.CellProcessor', 'rdbms.Peer', 'rdbms.QueryParameter');

  /**
   * Returns cell values as a DataSet
   *
   * @test    xp://net.xp_framework.unittest.text.csv.DataSetCellProcessorTest
   * @see     xp://text.csv.CellProcessor
   */
  class DataSetLookup extends CellProcessor {
    protected $peer= NULL;
    protected $criteria= NULL;

    /**
     * Creates a new instance of this processor.
     *
     * @param  rdbms.Peer peer
     * @param  rdbms.Criteria c if omitted, the peer's primary key is used
     */
    public function __construct(Peer $peer, Criteria $c= NULL) {
      $this->peer= $peer;
      if (!$c) {
        if (1 === sizeof($peer->primary)) {
          $this->criteria= new Criteria(array($peer->primary[0], new QueryParameter(), EQUAL));
        } else {
          throw new IllegalArgumentException($peer->identifier.' has no single primary key, cannot determine criteria');
        }
      } else {
        $this->criteria= $c;
      }
    }
    
    /**
     * Processes cell value
     *
     * @param   var in
     * @return  var
     * @throws  lang.FormatException
     */
    public function process($in) {
      try {
        $it= $this->peer->iteratorFor($this->criteria->bind($in));
        if ($it->hasNext()) {
          $e= $it->next();
          if ($it->hasNext()) {
            throw new FormatException('More than one '.$this->peer->identifier.' returned for '.$this->criteria->toString());
          }
          return $e;
        } else {
          throw new FormatException('No '.$this->peer->identifier.' records found for '.$this->criteria->toString());
        }
      } catch (SQLException $e) {
        throw new FormatException($e->getMessage());
      }
    }
  }
?>
