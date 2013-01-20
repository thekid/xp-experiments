<?php 
;

 interface Protocol {

public function accept(Socket $s);

public function connect(Socket $s);

public function data(Socket $s);

public function close(Socket $s);}xp::$registry['class.Protocol']= 'test.Protocol';xp::$registry['details.test.Protocol']= array (
  0 => 
  array (
  ),
  1 => 
  array (
    'accept' => 
    array (
      1 => 
      array (
        0 => 'peer.Socket',
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => NULL,
      5 => 
      array (
      ),
    ),
    'connect' => 
    array (
      1 => 
      array (
        0 => 'peer.Socket',
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => NULL,
      5 => 
      array (
      ),
    ),
    'data' => 
    array (
      1 => 
      array (
        0 => 'peer.Socket',
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => NULL,
      5 => 
      array (
      ),
    ),
    'close' => 
    array (
      1 => 
      array (
        0 => 'peer.Socket',
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => NULL,
      5 => 
      array (
      ),
    ),
  ),
  'class' => 
  array (
    5 => 
    array (
    ),
    4 => NULL,
  ),
);uses('peer.Socket');
?>
