<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('rdbms.ResultSet');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class SybasexResultSet extends ResultSet {
    protected
      $columns  = NULL,
      $rows     = NULL;

    /**
     * Constructor
     *
     * @param   resource handle
     */
    public function __construct($result, TimeZone $tz= NULL) {
      // $result used to by a PHP handle - unused here...
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function setColumns(array $columns) {
      $this->columns= $columns;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function addRow(array $row) {
      $this->rows[]= $row;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function seal($rows, $flags) {
      // TODO
    }

    /**
     * Seek
     *
     * @param   int offset
     * @return  bool success
     * @throws  rdbms.SQLException
     */
    public function seek($offset) {
    }
    
    /**
     * Iterator function. Returns a rowset if called without parameter,
     * the fields contents if a field is specified or FALSE to indicate
     * no more rows are available.
     *
     * @param   string field default NULL
     * @return  var
     */
    public function next($field= NULL) {
      $result= array();
      foreach ($this->columns as $offset => $column) {
        $row= current($this->rows);
        
        $result[$column->name()]= ($row[$offset] instanceof TdsNumeric ? $row[$offset]->getValue() : $row[$offset]);
      }
      
      return (NULL === $field ? $result : $result[$field]);
    }
    
    /**
     * Close resultset and free result memory
     *
     * @return  bool success
     */
    public function close() {
    }
  }
?>
