// {{{ Hello
function Hello() {
  {
    this.__class = 'Hello';
  }
}

Hello.prototype = new Object();

Hello.main = function(args) {
  if (args.length < 1) {
    throw new IllegalArgumentException('Argument required');
  }
  Console.writeLine('Hello ', args[0]);
}
// }}}
