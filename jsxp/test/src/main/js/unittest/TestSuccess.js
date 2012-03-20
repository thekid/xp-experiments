// {{{ TestSuccess
unittest.TestSuccess = define('unittest.TestSuccess', 'lang.Object', function(test) { 
  this.test = test;
});

unittest.TestSuccess.prototype.test = null;
unittest.TestSuccess.prototype.throwable = null;

unittest.TestSuccess.prototype.toString = function() {
  return this.getClassName() + '(test= ' + this.test.getClassName() + '::' + this.test.getName() + ')';
}
// }}}
