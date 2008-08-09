<?php
  function __autoload($name) {
    include(str_replace('::', DIRECTORY_SEPARATOR, $name).'.php');
  }

  function create($o) {
    return $o;
  }

  use scriptlet::Session;
  use scriptlet::Exception;
  
  var_dump(
    new Session(), 
    new util::Date(), 
    new Exception(), 
    new ::Exception(),
    create(new util::Date())->getTimeZone()
  );
?>
