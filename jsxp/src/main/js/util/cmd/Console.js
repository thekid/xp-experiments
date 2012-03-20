// {{{ Console
util.cmd.Console = function() {
  {
    this.__class = 'util.cmd.Console';
  }
}

util.cmd.Console.write = function() {
  for (var i= 0; i < arguments.length; i++) {
    global.out.write(arguments[i]);
  }
}

util.cmd.Console.writeLine = function() {
  for (var i= 0; i < arguments.length; i++) {
    global.out.write(arguments[i]);
  }
  global.out.writeLines(1);
}

util.cmd.Console.prototype= new Object();
// }}}

