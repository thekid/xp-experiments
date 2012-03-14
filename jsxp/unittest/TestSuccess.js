// {{{ TestSuccess
unittest.TestSuccess = function(test) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'unittest.TestSuccess';
    this.test = test;
  }
}

extend(unittest.TestSuccess, lang.Object);

unittest.TestSuccess.prototype.test = null;
unittest.TestSuccess.prototype.throwable = null;

unittest.TestSuccess.prototype.toString = function() {
  return this.getClassName() + '(test= ' + this.test.getClassName() + '::' + this.test.getName() + ')';
}
// }}}
