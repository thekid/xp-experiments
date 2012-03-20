// {{{ Console
util.cmd.Console = define('util.cmd.Console', 'lang.Object', function Console() { });

util.cmd.Console.write = function() {
  for (var i= 0; i < arguments.length; i++) {
    global.out.write(arguments[i]);
  }
}

util.cmd.Console.writeLine = function() {
  for (var i= 0; i < arguments.length; i++) {
    global.out.write(arguments[i]);
  }
  global.out.writeLine();
}
// }}}

