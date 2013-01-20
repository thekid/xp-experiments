<?php 
;
;

uses('test.Protocol'); class LegacyProtocol extends Object implements Protocol{

public function connect(Socket $s){
Console::writeLine('Connected');}


public function data(Socket $s){
Console::writeLine('Data');}


public function close(Socket $s){
Console::writeLine('Closed');}}xp::$registry['class.LegacyProtocol']= 'test.LegacyProtocol';xp::$registry['details.test.LegacyProtocol']= array (
  0 => 
  array (
  ),
  1 => 
  array (
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
);uses('peer.Socket', 'util.cmd.Console', 'lang.Object', 'test.Protocol');
?>
