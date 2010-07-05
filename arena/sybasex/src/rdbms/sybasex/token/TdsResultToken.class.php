<?php
  uses(
    'rdbms.sybasex.token.TdsToken',
    'rdbms.sybasex.TdsType'
  );

  $package= 'rdbms.sybasex.token';
  class rdbms·sybasex·token·TdsResultToken extends rdbms·sybasex·token·TdsToken {
    public function handle() {
      $headerSize= $this->readLength();
      // $data= $this->data->read($this->readLength());
      
      $numberOfColumns= $this->readSmallInt();
      $this->cat && $this->cat->debug('Have', $numberOfColumns, 'columns');
      
      for ($i= 0; $i < $numberOfColumns; $i++) {
        $name= $this->data->read($this->readByte()); // first byte is length
        $flags= $this->readByte();
        $userType= $this->readLong();
        $columnType= $this->readByte();
        $type= TdsType::byOrdinal($columnType);

        $this->cat && $this->cat->debug('Column', $name,
          'flags=', $flags,
          'usertype=', $userType,
          'columnType=', $columnType,
          'type=', $type
        );

        $columnSize= 0;
        switch ($type->size()) {
          case 4: {
            // TODO: Read table name for SYBTEXT and SYBIMAGE
            $columnSize= $this->readLong();
            break;
          }

          case 5: {
            $columnSize= $this->readLong();
            break;
          }

          case 2: {
            $columnSize= $this->readSmallInt();
            break;
          }

          case 1: {
            $columnSize= $this->readByte();
            break;
          }

          case 0: {
            $columnSize= $type->fixedSize();
            break;
          }
        }

        $this->cat && $this->cat->debug('Column\'s size is', $columnSize, 'bytes');
        
        // Eat locale information
        $this->data->read($this->readByte()); // first byte is length
      }
      
      // TODO: Analyze this
      $this->cat && $this->cat->debugf('Have TDS_RESULT token; Offset='.$this->data->tell());
    }
  }

?>
