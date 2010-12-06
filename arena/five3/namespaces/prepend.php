<?php
  function __autoload($name) {
    $fn= strtr($name, '\\', DIRECTORY_SEPARATOR).'.php';
    fputs(STDERR, "L $fn\n");
    require_once($fn);
  }
?>
