// {{{ TestSuccess
unittest.TestSuccess = function(test) {
  {
    this.__class = 'unittest.TestSuccess';
    this.test = test;
  }
}

unittest.TestSuccess.prototype= new lang.Object();

unittest.TestSuccess.prototype.test = null;
unittest.TestSuccess.prototype.throwable = null;

unittest.TestSuccess.prototype.toString = function() {
  return this.getClassName() + '(test= ' + this.test.getClassName() + '::' + this.test.getName() + ')';
}
// }}}
