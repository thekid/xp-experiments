<?php

trait CreateWith {
  public static function with() {
    return Creation::of(__CLASS__);
  }
}