// {{{ TestFailure
function TestFailure(test, throwable) {
  {
    this.__class = 'TestFailure';
    this.test = test;
    this.throwable = throwable;
  }
}

TestFailure.prototype= new Object();

TestFailure.prototype.test = null;
TestFailure.prototype.throwable = null;

TestFailure.prototype.toString = function() {
  return this.getClassName() + 
    '(test= ' + this.test.getClassName() + '::' + this.test.getName() + ") {\n  " + 
    this.throwable.toString() +
    "\n}"
  ;
}
// }}}
