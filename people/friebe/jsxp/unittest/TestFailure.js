// {{{ TestFailure
unittest.TestFailure = function(test, throwable) {
  {
    this.__class = 'unittest.TestFailure';
    this.test = test;
    this.throwable = throwable;
  }
}

unittest.TestFailure.prototype= new Object();

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
