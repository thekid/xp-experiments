uses('unittest.TestCase');

// {{{ DemoTest
tests.DemoTest = function(name) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'tests.DemoTest';
    unittest.TestCase.call(this, name);
  }
}

extend(tests.DemoTest, unittest.TestCase);

tests.DemoTest.prototype.testSucceeds = function() {
  this.assertEquals(1, 1);
}
tests.DemoTest.prototype.testSucceeds['@']= { test : null };

tests.DemoTest.prototype.testFails = function() {
  this.assertEquals(1, 0);
}
tests.DemoTest.prototype.testFails['@']= { test : null };
// }}}
