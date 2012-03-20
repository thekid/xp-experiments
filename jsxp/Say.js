// {{{ Say
Say = define('Say', 'lang.Object', function Say() { });

Say.main = function main(args) {
  new Say().hello(args[0]);
}

Say.prototype.greeting = 'Hello';

Say.prototype.hello= function hello(name) {
  util.cmd.Console.writeLine(this.getClassName() + ': ' + this.greeting, ' ', name);
}
// }}}
