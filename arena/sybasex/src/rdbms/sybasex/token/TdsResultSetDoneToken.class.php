<?php
  uses('rdbms.sybasex.token.TdsToken');

  $package= 'rdbms.sybasex.token';
  class rdbms·sybasex·token·TdsResultSetDoneToken extends rdbms·sybasex·token·TdsToken {
    public function handle() {
      $flags= $this->data->readSmallInt();
      
      // Unknown data
      $this->data->readSmallInt();
      
      $rowcount= $this->data->readLong();
      
      $this->cat && $this->cat->debug('Got TDS_RESULTSET_DONE, got', $rowcount, 
        'rows, flags', $flags
      );
    }
  }

?>