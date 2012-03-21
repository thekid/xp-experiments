uses('unittest.TestCase');

// {{{ DemoTest
unittests.demo.DemoTest = define('unittests.demo.DemoTest', 'unittest.TestCase', function DemoTest(name) {
  unittest.TestCase.apply(this, arguments);
});

unittests.demo.DemoTest.prototype.testSucceeds = function DemoTest$testSucceeds() {
  this.assertEquals(1, 1);
}
unittests.demo.DemoTest.prototype.testSucceeds['@']= { test : null };

unittests.demo.DemoTest.prototype.testFails = function DemoTest$testFails() {
  this.assertEquals(1, 0);
}
unittests.demo.DemoTest.prototype.testFails['@']= { test : null };
// }}}
