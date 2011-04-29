<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.net';

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class peer·net·Message extends Object {
    protected $id= 0;
    protected $flags= 0;
    protected $opcode= 0;
    protected $type= 0;
    protected $records= array();

    protected static function id() {
      static $id= 1;

      if (++$id > 65535) $id= 1;
      return $id;
    }
  
    public function __construct($id= NULL) {
      $this->id= (NULL === $id) ? self::id() : $id;
    }

    public function getId() {
      return $this->id;
    }

    public function setId($id) {
      $this->id= $id;
    }

    public function getFlags() {
      return $this->flags;
    }

    public function setFlags($flags) {
      $this->flags= $flags;
    }
    
    public function getOpcode() {
      return $this->opcode;
    }

    public function setOpcode($opcode) {
      $this->opcode= $opcode;
    }

    public function getType() {
      return $this->type;
    }

    public function setType($type) {
      $this->type= $type;
    }

    public function addRecord($record) {
      $this->records[]= $record;
    }

    public function getRecords() {
      return $this->records;
    }
  }
?>
