<?php
  uses('rdbms.sybasex.token.TdsToken');

  $package= 'rdbms.sybasex.token';
  class rdbms·sybasex·token·TdsRowResultToken extends rdbms·sybasex·token·TdsToken {
    public function handle() {

      $record= array();
      foreach ($this->context->columns() as $column) {
        $this->cat && $this->cat->debug('Processing', $column);

        $record[]= $column->getType()->fromWire($this->data, $column);
        continue;

        $size= NULL;
        switch ($column['type']->size()) {
          case 5: {
            $size= $this->data->readLong();
            break;
          }

          case 2: {
            $size= $this->data->readSmallInt();
            break;
          }

          case 1: {
            $size= $this->data->readByte();
            break;
          }

          case 0: {
            // TODO: Why?
            $size= $column['type']->fixedSize();
            break;
          }

          default: {
            throw new SybasexRuntimeException('Invalid column size when reading result row: '.$column['type']->size());
          }
        }
      }
      
      $this->cat && $this->cat->debug('Read row:', $record);
    }
  }

?>
