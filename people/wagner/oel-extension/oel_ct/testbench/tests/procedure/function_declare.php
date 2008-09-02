<?php

  var_dump(FALSE); /* functions are bound on oel_finalize */

  function funcA() {}

  var_dump(function_exists("funcA"));

?>
