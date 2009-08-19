<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('rdbms.ResultSet');

  /**
   * Result set
   *
   * @ext      pdo
   * @purpose  Resultset wrapper
   */
  class PDOResultSet extends ResultSet {
  
    /**
     * Constructor
     *
     * @param   PDOStatement handle
     */
    public function __construct($result, TimeZone $tz= NULL) {
      $fields= array();
      if (is_object($result)) {
        for ($i= 0, $num= $result->columnCount(); $i < $num; $i++) {
          $field= $result->getColumnMeta($i);
          $fields[$field['name']]= $field;
        }
      }
      parent::__construct($result, $fields, $tz);
    }

    /**
     * Seek
     *
     * @param   int offset
     * @return  bool success
     * @throws  rdbms.SQLException
     */
    public function seek($offset) { 
      if (!mysql_data_seek($this->handle, $offset)) {
        throw new SQLException('Cannot seek to offset '.$offset);
      }
      return TRUE;
    }
    
    /**
     * Iterator function. Returns a rowset if called without parameter,
     * the fields contents if a field is specified or FALSE to indicate
     * no more rows are available.
     *
     * @param   string field default NULL
     * @return  mixed
     */
    public function next($field= NULL) {
      if (
        !is_object($this->handle) ||
        FALSE === ($row= $this->handle->fetch(PDO::FETCH_ASSOC))
      ) {
        return FALSE;
      }
      
      foreach (array_keys($row) as $key) {
        if (NULL === $row[$key] || !isset($this->fields[$key])) continue;
        switch ($this->fields[$key]['native_type']) {
          case 'DATE':
            $row[$key]= Date::fromString($row[$key], $this->tz);
            break;
          
          case 'NEWDECIMAL':
            if ($this->fields[$key]['precision'] > 0) {
              settype($row[$key], 'double');
              break;
            }
            // Fallthrough intended
            
          case 'LONGLONG':
            if ($row[$key] <= LONG_MAX && $row[$key] >= LONG_MIN) {
              settype($row[$key], 'integer');
            } else {
              settype($row[$key], 'double');
            }
            break;
        }
      }
      
      if ($field) return $row[$field]; else return $row;
    }
    
    /**
     * Close resultset and free result memory
     *
     * @return  bool success
     */
    public function close() { 
      return TRUE;
    }

    /**
     * Returns a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.xp::typeOf($this->handle).')@'.xp::stringOf($this->fields);
    }
  }
?>
