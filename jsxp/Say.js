// {{{ Say
Say = function() {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'Say';
  }
}

Say.main = function(args) {
  new Say().hello(args[0]);
}

Say.prototype= Object.create(lang.Object.prototype);

Say.prototype.greeting = 'Hello';

Say.prototype.hello= function(name) {
  util.cmd.Console.writeLine(this.greeting, ' ', name);
}
// }}}
