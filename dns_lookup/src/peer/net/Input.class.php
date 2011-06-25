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
    protected $prev= -1;

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
        if (-1 !== $this->prev) {
          $this->offset= $this->prev;
          $this->prev= -1;
        }
        return NULL;
      } else if ($l < 64) {
        return $this->read($l);
      } else {
        $n= (($l & 0x3F) << 8) + ord($this->read(1)) - 12;
        if (-1 === $this->prev) $this->prev= $this->offset;
        $this->offset= $n;
        return $this->readLabel();
      }
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
    
    /**
     * Read a single record
     *
     * @return  peer.net.Record
     */
    public function readRecord() {
      $domain= $this->readDomain();
      $r= unpack('ntype/nclass/Nttl/nlength', $this->read(10));

      switch ($r['type']) {
        case 1:   // A
          $ip= implode('.', unpack('Ca/Cb/Cc/Cd', $this->read(4)));
          return new ARecord($domain, $ip);

        case 2:   // NS
          $target= $this->readDomain();
          return new NSRecord($domain, $target);

        case 5:    // CNAME
          $target= $this->readDomain();
          return new CNAMERecord($domain, $target);

        case 6:    // SOA
          $mname= $this->readDomain();
          $rname= $this->readDomain();
          $data= unpack('Nserial/Nrefresh/Nretry/Nexpire/Nminimum-ttl', $this->read(20));
          return new SOARecord(
            $domain, 
            $mname, 
            $rname,
            sprintf('%u', $data['serial']) + 0,   // convert from unsigned
            $data['refresh'], 
            $data['retry'], 
            $data['expire'], 
            $data['minimum-ttl']
          );

        case 12:  // PTR
          $target= $this->readDomain();
          return new PTRRecord($domain, $target);

        case 15:  // MX
          $pri= unpack('nlevel', $this->read(2));
          $ns= $this->readDomain();
          return new MXRecord($domain, $pri['level'], $ns);

        case 16:  // TXT
          $text= $this->read($r['length']);
          return new TXTRecord($domain, $text);

        case 28:   // AAAA
          $ip= unpack('H*quads', $this->read(16));
          return new AAAARecord($domain, substr(chunk_split($ip['quads'], 4, ':'), 0, -1));

        case 33:  // SRV
          $data= unpack('npri/nweight/nport', $this->read(6));
          $target= $this->readDomain();
          return new SRVRecord($domain, $data['pri'], $data['weight'], $data['port'], $target);

        case 35:  // NAPTR
          $data= unpack('norder/npref', $this->read(4));
          $flags= strtoupper($this->readLabel());
          $services= $this->readLabel();
          $regex= $this->readLabel();
          $replacement= $this->readLabel();
          return new NAPTRRecord($domain, $data['order'], $data['pref'], $flags, $services, $regex, $replacement);

      }
      throw new ProtocolException('Unknown record type '.$r['type']);
    }
    
    /**
     * Creates a string representation where all bytes between ASCII 0..32
     * and 127..255 are escaped in octal escape sequences, the rest is 
     * displayed as is.
     *
     * @see     php://addcslashes
     * @param   string bytes
     * @return  string 
     */
    protected function escaped($bytes) {
      $r= '';
      for ($i= 0, $s= strlen($bytes); $i < $s; $i++) {
        $c= ord($bytes{$i});
        if ($c < 32 || $c > 126) {
          $r.= sprintf('\\%03o', $c);
        } else {
          $r.= $bytes{$i};
        }
      }
      return $r;
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return sprintf(
        '%s(%d,@%d)<%s>',
        $this->getClassName(),
        strlen($this->bytes),
        $this->offset,
        $this->escaped($this->bytes)
      );
    }
  }
?>
