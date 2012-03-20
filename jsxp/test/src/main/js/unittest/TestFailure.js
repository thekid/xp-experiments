// {{{ TestFailure
unittest.TestFailure = define('unittest.TestFailure', 'lang.Object', function(test, throwable) { 
  this.test = test;
  this.throwable = throwable;
});

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
