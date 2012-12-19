<?php
  trait LocalExtensions {
    static function __static() {
      xp::extensions(__CLASS__, $scope= __CLASS__);
    }
  }
?>