<?php
  uses('rdbms.sybasex.token.TdsToken');

  $package= 'rdbms.sybasex.token';
  class rdbms·sybasex·token·TdsCapabilityToken extends rdbms·sybasex·token·TdsToken {
    public function handle() {
      $data= $this->data->read($this->readLength());

      $this->cat && $this->cat->debugf('Have TDS_CAPABILITY token. Data: '.$data);
    }
  }

?>