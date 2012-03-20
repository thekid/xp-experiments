// {{{ TestSuccess
unittest.TestSuccess = define('unittest.TestSuccess', 'lang.Object', function TestSuccess(test) { 
  this.test = test;
});

unittest.TestSuccess.prototype.test = null;
unittest.TestSuccess.prototype.throwable = null;

unittest.TestSuccess.prototype.toString = function TestSuccess$toString() {
  return this.getClassName() + '(test= ' + this.test.getClassName() + '::' + this.test.getName() + ')';
}
// }}}
