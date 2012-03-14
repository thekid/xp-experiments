// {{{ Say
Say = function() {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'Say';
  }
}

Say.main = function(args) {
  new Say().hello(args[0]);
}

extend(Say, lang.Object);

Say.prototype.greeting = 'Hello';

Say.prototype.hello= function(name) {
  util.cmd.Console.writeLine(this.greeting, ' ', name);
}
// }}}
