<?php
  uses('rdbms.sybasex.token.TdsToken');

  $package= 'rdbms.sybasex.token';
  class rdbms·sybasex·token·TdsResultToken extends rdbms·sybasex·token·TdsToken {
    public function handle() {
      $headerSize= $this->readLength();
      // $data= $this->data->read($this->readLength());
      
      $numberOfColumns= $this->readSmallInt();
      $this->cat && $this->cat->debug('Have', $numberOfColumns, 'columns');
      
      for ($i= 0; $i < $numberOfColumns; $i++) {
        
      }
      
      // TODO: Analyze this
      // $this->cat && $this->cat->debugf('Have TDS_RESULT token. Data: '.$data);
    }
  }

?>