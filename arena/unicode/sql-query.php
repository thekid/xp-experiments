<?php
  require('lang.base.php');
  xp::sapi('cli');
  uses('rdbms.DriverManager', 'xml.Tree');
  
  function treeFrom(ResultSet $r) {
    $t= new Tree('resultset');
    while ($record= $r->next()) {
      $t->addChild(Node::fromArray($record, 'row'));
    }
    return $t->getDeclaration()."\n".$t->getSource(INDENT_DEFAULT);
  }

  // {{{ main
  $p= new ParamString();
  $c= DriverManager::getConnection($p->value(1).'?autoconnect=1');
  Console::writeLine('---> Console: ', Console::$out);
  Console::writeLine('---> Connection: ', $c);
  
  if ($p->exists(2)) {
    $value= $p->value(2);
    Console::writeLine('Writing ', $value);
    $c->insert('into unicode values(%s)', $value);
  }
  
  Console::writeLine(treeFrom($c->query('select * from unicode')));
  Console::writeLine(treeFrom($c->query('select * from latinone')));
  // }}}
?>
