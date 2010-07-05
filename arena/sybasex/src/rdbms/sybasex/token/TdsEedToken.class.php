<?php
  uses('rdbms.sybasex.token.TdsToken');

  $package= 'rdbms.sybasex.token';
  class rdbms·sybasex·token·TdsEedToken extends rdbms·sybasex·token·TdsToken {
    public function handle() {
      $size= unpack('vsize', $this->read(2));
      $data= $this->read($size['size']);

      // TODO: Analyze this
      $this->cat && $this->cat->debugf('Have TDS_EED token. Data: '.$data);
    }
  }

?>