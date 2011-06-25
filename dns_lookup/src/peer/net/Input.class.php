<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.net';

  /**
   * DNS Input
   *
   * @see     xp://peer.net.DnsResolver
   * @test    xp://net.xp_framework.unittest.peer.net.InputTest
   */
  class peer·net·Input extends Object {
    protected $bytes= '';
    protected $offset= 0;
    protected $offsets= array();

    /**
     * Creates a new input instance
     *
     * @param   string bytes
     */
    public function __construct($bytes) {
      $this->bytes= $bytes;
    }

    /**
     * Read a specified number of bytes
     *
     * @param   int length
     * @return  string
     */
    public function read($length) {
      $chunk= substr($this->bytes, $this->offset, $length);
      $this->offset+= $length;
      return $chunk;
    }
    
    /**
     * Reads a single label
     *
     * @return  string
     */
    public function readLabel() {
      $l= ord($this->read(1));
      if ($l <= 0) {
        if (!empty($this->offsets)) $this->offset= array_pop($this->offsets);
        return NULL;
      } else if ($l < 64) {
        $label= $this->read($l);
      } else {
        $n= (($l & 0x3F) << 8) + ord($this->read(1)) - 12;
        $this->offsets[]= $this->offset;
        $this->offset= $n;
        $label= $this->readLabel();
      }
      return $label;
    }

    /**
     * Reads a domain - consists of multiple labels
     *
     * @return  string
     */
    public function readDomain() {
      $labels= array();
      while (NULL !== ($label= $this->readLabel())) {
        $labels[]= $label;
      }
      return implode('.', $labels);
    }
  }
?>
