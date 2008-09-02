<?php

echo sprintf('
Warning: op array must be finalized before executing in %s on line 13
', str_replace('.php', '.oel.php', __FILE__));
var_dump(NULL);

var_dump(TRUE);

?>
