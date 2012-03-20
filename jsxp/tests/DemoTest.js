uses('unittest.TestCase');

// {{{ DemoTest
tests.DemoTest = define('tests.DemoTest', 'unittest.TestCase', function(name) {
  unittest.TestCase.apply(this, arguments);
});

tests.DemoTest.prototype.testSucceeds = function() {
  this.assertEquals(1, 1);
}
tests.DemoTest.prototype.testSucceeds['@']= { test : null };

tests.DemoTest.prototype.testFails = function() {
  this.assertEquals(1, 0);
}
tests.DemoTest.prototype.testFails['@']= { test : null };
// }}}
