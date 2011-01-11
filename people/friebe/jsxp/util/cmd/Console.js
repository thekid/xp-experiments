// {{{ Console
function Console() {
  {
    this.__class = 'Console';
  }
}

Console.write = function() {
  for (var i= 0; i < arguments.length; i++) {
    $xp.out.write(arguments[i]);
  }
}

Console.writeLine = function() {
  for (var i= 0; i < arguments.length; i++) {
    $xp.out.write(arguments[i]);
  }
  $xp.out.writeLines(1);
}

Console.prototype= new Object();
// }}}

