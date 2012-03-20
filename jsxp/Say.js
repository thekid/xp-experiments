// {{{ Say
Say = define('Say', 'lang.Object', function() { });

Say.main = function(args) {
  new Say().hello(args[0]);
}

Say.prototype.greeting = 'Hello';

Say.prototype.hello= function(name) {
  util.cmd.Console.writeLine(this.getClassName() + ': ' + this.greeting, ' ', name);
}
// }}}
