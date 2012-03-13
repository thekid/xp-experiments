// {{{ TestSuccess
unittest.TestSuccess = function(test) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'unittest.TestSuccess';
    this.test = test;
  }
}

unittest.TestSuccess.prototype= Object.create(lang.Object.prototype);

unittest.TestSuccess.prototype.test = null;
unittest.TestSuccess.prototype.throwable = null;

unittest.TestSuccess.prototype.toString = function() {
  return this.getClassName() + '(test= ' + this.test.getClassName() + '::' + this.test.getName() + ')';
}
// }}}
