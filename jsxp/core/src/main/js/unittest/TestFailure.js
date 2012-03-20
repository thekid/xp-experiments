// {{{ TestFailure
unittest.TestFailure = function(test, throwable) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'unittest.TestFailure';
    this.test = test;
    this.throwable = throwable;
  }
}

extend(unittest.TestFailure, lang.Object);

unittest.TestFailure.prototype.test = null;
unittest.TestFailure.prototype.throwable = null;

unittest.TestFailure.prototype.toString = function() {
  return this.getClassName() + 
    '(test= ' + this.test.getClassName() + '::' + this.test.getName() + ") {\n  " + 
    this.throwable.toString() +
    "\n}"
  ;
}
// }}}
