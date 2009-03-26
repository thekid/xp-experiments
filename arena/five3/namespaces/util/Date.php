<?php
  namespace util;

  use \operation\Success;
  
  class Date {
  
    public function getTimeZone() {
      return new TimeZone();
    }

    public function setTimeZone(\util\TimeZone $tz) {
      return new Success();
    }
  }
?>
