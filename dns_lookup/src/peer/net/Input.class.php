<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.net';

  /**
   * DNS Input
   *
   */
  class peer·net·Input extends Object {
    protected $bytes= '';
    protected $offset= 0;

    /**
     * (Insert method's description here)
     *
     * @param   
     * @param   
     */
    public function __construct($bytes) {
      $this->bytes= $bytes;
    }

    public function read($length) {
      $chunk= substr($this->bytes, $this->offset, $length);
      $this->offset+= $length;
      return $chunk;
    }

    public function readDomain() {
      $labels= array();
      $l= 1;
      while ($l > 0) {
        $l= ord($this->read(1));
        if ($l <= 0) {
          break;
        } else if ($l < 64) {
          $label= $this->read($l);
        } else {
          $n= (($l & 0x3F) << 8) + ord($this->read(1)) - 12;
          $prev= $this->offset;
          $this->offset= $n;
          $label= $this->readDomain();
          $this->offset= $prev;
          $l= 0;
        }
        $labels[]= $label;
      }
      return implode('.', $labels);
    }

  }
?>
