// {{{ Hello
Hello = function() {
  {
    this.__class = 'Hello';
  }
}

Hello.prototype = new lang.Object();

Hello.main = function(args) {
  if (args.length < 1) {
    throw new lang.IllegalArgumentException('Argument required');
  }
  util.cmd.Console.writeLine('Hello ', args[0]);
}
// }}}
