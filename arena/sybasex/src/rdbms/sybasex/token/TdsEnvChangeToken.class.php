<?php
  uses('rdbms.sybasex.token.TdsToken');

  $package= 'rdbms.sybasex.token';
  class rdbms·sybasex·token·TdsEnvChangeToken extends rdbms·sybasex·token·TdsToken {
    public function handle() {
      $size= $this->readSmallInt();
      $this->cat && $this->cat->debug('Reading', $size, 'bytes');
      $data= $this->data->read($size['size']);

      // TODO: Analyze this.
      $this->cat && $this->cat->debug('Have TDS_ENVCHANGE token. Data: '.$data);
    }
  }

?>