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
      }
      
      $this->context->addRowResult($record);
    }
  }
?>
