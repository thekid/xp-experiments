<?php 
  // Determine ZEND_MODULE_API_NO - see ext/standard/info.c
  ob_start();
  phpinfo(INFO_GENERAL);
  preg_match('/PHP Extension => ([0-9]+)/', ob_get_contents(), $matches);
  ob_end_clean();
  
  include(__FILE__.'.'.$matches[1]); 
?>
