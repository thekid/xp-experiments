// {{{ TestSuccess
function TestSuccess(test) {
  {
    this.__class = 'TestSuccess';
    this.test = test;
  }
}

TestSuccess.prototype= new Object();

TestSuccess.prototype.test = null;
TestSuccess.prototype.throwable = null;

TestSuccess.prototype.toString = function() {
  return this.getClassName() + '(test= ' + this.test.getClassName() + '::' + this.test.getName() + ')';
}
// }}}
