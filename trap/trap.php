<?php
  function trap($block, $raise= 'lang.Error') {
    set_error_handler(function($code, $message, $file, $line, $context) use($raise) {
      if (0 === error_reporting()) {
        return;
      } else if (is_callable($raise)) {
        call_user_func($raise, $message);
      } else {
        raise($raise, $message);
      }
    });
    try {
      $block();
      restore_error_handler();
    } catch (Exception $e) {
      restore_error_handler();
      throw $e;
    }
  }
?>