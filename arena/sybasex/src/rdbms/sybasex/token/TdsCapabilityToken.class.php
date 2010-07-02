<?php
  uses('rdbms.sybasex.token.TdsToken');

  $package= 'rdbms.sybasex.token';
  class rdbms·sybasex·token·TdsCapabilityToken extends rdbms·sybasex·token·TdsToken {
    public function handle() {
      $size= unpack('vsize', $this->read(2));
      $data= $this->read($size['size']);

      $this->cat && $this->cat->debugf('Have TDS_CAPABILITY token. Data: '.$data);
    }
  }

?>