<?php

  try {
    throw new Exception("exeptA");
  } catch (Exception $e) {
    var_dump(
      dirname($e->getFile()),
      $e->getMessage()
    );
  }

?>
