<?php
  uses('rdbms.sybasex.token.TdsToken');

  $package= 'rdbms.sybasex.token';
  class rdbms·sybasex·token·TdsEnvChangeToken extends rdbms·sybasex·token·TdsToken {
    const
      TDS_ENV_DATABASE        = 1,
      TDS_ENV_LANG      	  = 2,
      TDS_ENV_CHARSET   	  = 3,
      TDS_ENV_PACKSIZE  	  = 4,
      TDS_ENV_LCID        	  = 5,
      TDS_ENV_SQLCOLLATION	  = 7,
      TDS_ENV_BEGINTRANS	  = 8,
      TDS_ENV_COMMITTRANS	  = 9,
      TDS_ENV_ROLLBACKTRANS	  = 10;


    public function handle() {
      $this->readLength();

      $type= $this->data->readByte();
      $newValue= $oldValue= NULL;
      switch ($type) {
        case self::TDS_ENV_BEGINTRANS:
        case self::TDS_ENV_COMMITTRANS:
        case self::TDS_ENV_ROLLBACKTRANS: {
          throw new SybasexRuntimeException('Unknown envchange token: '.sprintf('0x%02x', $type));
        }

        default: {
          $newValue= $this->data->read($this->data->readByte());
          $oldValue= $this->data->read($this->data->readByte());
          break;
        }
      }

      $this->cat && $this->cat->debugf('Received TDS_ENVCHANGED. Changed section 0x%02x from "%s" to "%s"',
        $type,
        $oldValue,
        $newValue
      );
    }
  }

?>
