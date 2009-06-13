<?php
  class ClassStream {
    private $fd, $buffer, $offset;
    
    public function stream_open($urn, $mode) {
      $cn= substr($urn, 8);
      if ('·' === $cn{0}) {
        sscanf($cn, '·%[0-9·]\\%[^ ]', $version, $name);
        $fn= strtr($version, '·', '.').DIRECTORY_SEPARATOR.$name;
      } else {
        $fn= $cn;
      }
      if (!$this->fd= fopen('classes'.DIRECTORY_SEPARATOR.$fn.'.php', $mode)) return FALSE;
      $versions= array();
      do {
        $chunk= fgets($this->fd, 1024);
        if ($r= strstr($chunk, '#requires ')) {
          sscanf($r, '#requires %[^ ] @ %[0-9.]', $namespace, $version);
          $versions[$namespace]= $version;
        } else if ($r= strstr($chunk, 'use ')) {
          $namespace= substr($r, 4, strrpos($r, '\\')- 4);
          if (isset($versions[$namespace])) {
            $this->buffer.= 'require(\'class://·'.strtr($versions[$namespace], '.', '·').substr($r, 4, strrpos($r, ';')- 4).'\');';
          }
          $this->buffer.= $chunk;
        } else {
          $this->buffer.= $chunk;
        }
      } while (!feof($this->fd));
      return TRUE;
    }
    
    public function stream_read($bytes) {
      $chunk= substr($this->buffer, $this->offset, $bytes);
      $this->offset+= strlen($chunk);
      return $chunk;
    }

    public function stream_eof() {
      return $this->offset > strlen($this->buffer);
    }

    public function stream_stat() {
      return array();
    }
  }
  
  function __autoload($cn) {
    require('class://'.strtr($cn, '\\', DIRECTORY_SEPARATOR));
  }
  
  stream_wrapper_register('class', 'ClassStream');

  Log::main($argv);
?>
