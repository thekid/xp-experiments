<?php
  uses('rdbms.sybasex.token.TdsToken');

  $package= 'rdbms.sybasex.token';
  class rdbms·sybasex·token·TdsLoginAckToken extends rdbms·sybasex·token·TdsToken {
    public function handle() {
      $data= $this->data->read($this->readLength());

      $this->cat && $this->cat->debugf('Have TDS_LOGINACK token. Data: '.$data);

      $login= unpack('Cack/Cmajorver/Cminorver/vproductnamelen/xxa*productname', $data);

      $this->cat && $this->cat->debug('Login information:', $login);

      $this->cat && $this->cat->debug('Login '.(in_array($login['ack'], array(1, 5)) ? 'successfull' : 'failed'));
    }
  }

?>