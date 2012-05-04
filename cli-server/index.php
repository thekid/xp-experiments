<?php
  putenv('DOCUMENT_ROOT='.getcwd().'/0');
  putenv('REQUEST_URI='.$_SERVER['REQUEST_URI']);
  putenv('HTTP_HOST=localhost');
  putenv('SERVER_PROTOCOL=HTTP/1.1');
  putenv('REQUEST_METHOD='.$_SERVER['REQUEST_METHOD']);
  ini_set('date.timezone', 'Europe/Berlin');
  set_include_path('../../xp.thekid.core/tools/;../../xp.thekid.core/core/;;.');
  include('../../xp.thekid.core/tools/tools/web.php');
?>