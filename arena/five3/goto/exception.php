<?php
  try {
    goto end;
  } catch (Exception $e) {
    die($e);
  }
  
  end: echo 'Jumped out of try';
?>
