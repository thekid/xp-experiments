uses('unittest.TestCase');

// {{{ DemoTest
function DemoTest(name) {
  {
    TestCase.call(this, name);
    this.__class = 'DemoTest';
  }
}

DemoTest.prototype= new TestCase();

DemoTest.prototype.testSucceeds = function() {
  this.assertEquals(1, 1);
}

DemoTest.prototype.testFails = function() {
  this.assertEquals(1, 0);
}
// }}}
