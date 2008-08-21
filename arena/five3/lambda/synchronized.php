<?php
  interface Lock {
    public function acquire();
    public function release();
  }
  
  class FileLock implements Lock {
    protected $fd;
  
    public function __construct() {
      $this->fd= tmpfile();
    }
  
    public function acquire() {
      flock($this->fd, LOCK_EX);
    }
    
    public function release() {
      flock($this->fd, LOCK_UN);
    }
  
    public function __destruct() {
      fclose($this->fd);
    }
  }
  
  function synchronized(Lock $lock, $block) {
    $lock->acquire();
    try {
      $r= $block();
      $lock->release();
      return $r;
    } catch (Exception $e) { 
      $lock->release();
      throw $e;
    }
  }
  
  synchronized(new FileLock(), function() {
    echo 'Hello', "\n";
  });
?>
