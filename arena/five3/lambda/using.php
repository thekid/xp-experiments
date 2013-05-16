<?php
  // {{{ using(Closeable* o, Closure block)
  function using() {
    $args= func_get_args();
    if (($block= array_pop($args)) instanceof Closure)  {
      call_user_func_array($block, $args);
      foreach ($args as $arg) {
        $arg->close();
      }
    }
  }
  // }}}

  interface Closeable {
    public function close();
  }
  
  class FileReader implements Closeable {
    protected $fd;
  
    public function __construct($filename) {
      $this->fd= fopen($filename, 'rb');
    }

    public function read() {
      return fgets($this->fd, 0x2000);
    }
  
    public function close() {
      echo '*** Closing file ', $this->fd, ' ***', "\n";
      fclose($this->fd);
    }
  }

  class FileWriter implements Closeable {
    protected $fd;
  
    public function __construct($filename) {
      $this->fd= fopen($filename, 'wb');
    }

    public function write($data) {
      return fputs($this->fd, $data);
    }
  
    public function close() {
      echo '*** Closing file ', $this->fd, ' ***', "\n";
      fclose($this->fd);
    }
  }

  using(new FileReader(__FILE__), new FileWriter('php://stdout'), function($in, $out) {
    $out->write($in->read());
  });
?>
