<?php
  uses('rdbms.sybasex.token.TdsToken');

  $package= 'rdbms.sybasex.token';
  class rdbms·sybasex·token·TdsIgnoreToken extends rdbms·sybasex·token·TdsToken {
    public function handle() {
      $data= $this->data->read($this->readLength());

      // TODO: Analyze this
      $this->cat && $this->cat->debug('Have TDS_CONTROL token, ignoring', $this->length, 'bytes');
    }
  }

?>
