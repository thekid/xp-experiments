<?php
  namespace whatever;

  use \remote\Handler;
  use \remote\Remote;
  
  var_dump(new Handler());
  var_dump(Remote::forName('xp://example.com'));
?>
