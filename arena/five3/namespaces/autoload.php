<?php
  function __autoload($name) {
    include(str_replace('::', DIRECTORY_SEPARATOR, $name).'.php');
  }

  use scriptlet::Session;
  use scriptlet::Exception;
  
  var_dump(
    new Session(), 
    new util::Date(), 
    new Exception(), 
    new ::Exception()
  );
?>
