<?php 
;

 class DefaultAcceptHandler extends Object{

public function accept(Socket $s){
throw new MethodNotImplementedException('Protocol::accept');}}xp::$registry['class.DefaultAcceptHandler']= 'test.DefaultAcceptHandler';xp::$registry['details.test.DefaultAcceptHandler']= array (
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
  ),
  'class' => 
  array (
    5 => 
    array (
    ),
    4 => NULL,
  ),
);uses('peer.Socket', 'lang.Object', 'lang.MethodNotImplementedException');
?>
