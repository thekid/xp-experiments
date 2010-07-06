<?php
  uses(
    'rdbms.sybasex.token.TdsToken',
    'rdbms.sybasex.TdsMessage'
  );

  $package= 'rdbms.sybasex.token';
  class rdbms·sybasex·token·TdsEedToken extends rdbms·sybasex·token·TdsToken {
    public function handle() {
      $this->readLength();

      $msg= new TdsMessage();
      $msg->setNumber($this->data->readLong());
      $msg->setState($this->data->readByte());
      $msg->setSeverity($this->data->readByte());

      // Only for EED
      // Read SQL State message
      $msg->setSqlState($this->data->read($this->data->readByte()));

      // Read if more EED coming
      $this->data->readByte();

      // Read "junk status and transaction state"
      $this->readSmallInt();

      // Now comes the read message
      $msg->setMessage($this->data->read($this->data->readSmallInt()));
      $msg->setServername($this->data->read($this->data->readByte()));
      $msg->setProcname($this->data->read($this->data->readByte()));
      $msg->setLine($this->data->readSmallInt());  // readLong() for TDS 9.0

      $this->context->addMessage($msg);
      $this->cat && $this->cat->debug('Read message', $msg);
    }
  }

?>
