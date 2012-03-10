// {{{ Say
Say = function() {
  {
    this.__class = 'Say';
  }
}

Say.main = function(args) {
  new Say().hello(args[0]);
}

Say.prototype= new lang.Object();

Say.prototype.greeting = 'Hello';

Say.prototype.hello= function(name) {
  util.cmd.Console.writeLine(this.greeting, ' ', name);
}
// }}}
