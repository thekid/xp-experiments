<?php
  function __autoload($name) {
    include(str_replace('::', DIRECTORY_SEPARATOR, $name).'.php');
  }

  function create($o) {
    return $o;
  }

  use scriptlet::Session;
  use scriptlet::Exception;
  use operation::Success as S;
  
  var_dump(
    new Session(), 
    new util::Date(), 
    new Exception(), 
    new ::Exception(),
    create(new util::Date())->getTimeZone(),
    create(new util::Date())->setTimeZone(new util::TimeZone()),
    new S()
  );
?>
