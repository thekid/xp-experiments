uses('unittest.TestCase');

// {{{ XPClassTest
function XPClassTest(name) {
  {
    TestCase.call(this, name);
    this.__class = 'XPClassTest';
  }
}

XPClassTest.prototype= new TestCase();

XPClassTest.prototype.testGetName = function() {
  this.assertEquals('XPClassTest', this.getClass().getName());
}

XPClassTest.prototype.testForName = function() {
  this.assertEquals(this.getClass(), XPClass.forName('XPClassTest'));
}

XPClassTest.prototype.testGetFields = function() {
  fields= this.getClass().getFields();
  this.assertEquals('name', fields[2].getName());
}
// }}}
