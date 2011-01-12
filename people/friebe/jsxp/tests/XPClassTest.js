uses('unittest.TestCase');

// {{{ XPClassTest
function XPClassTest(name) {
  {
    TestCase.call(this, name);
    this.__class = 'tests.XPClassTest';
  }
}

XPClassTest.prototype= new TestCase();

XPClassTest.prototype.testGetName = function() {
  this.assertEquals('tests.XPClassTest', this.getClass().getName());
}

XPClassTest.prototype.testForName = function() {
  this.assertEquals(this.getClass(), XPClass.forName('tests.XPClassTest'));
}

XPClassTest.prototype.testGetFields = function() {
  var fields= this.getClass().getFields();
  var names= '';
  for (var i= 0; i < fields.length; i++) {
    names += fields[i].getName()+ ',';
  }
  var o= names.indexOf('name');
  this.assertEquals('name', names.substring(o, names.indexOf(',', o)));
}

XPClassTest.prototype.testHasNameField = function() {
  var field= this.getClass().getField('name');
  this.assertInstanceOf('lang.reflect.Field', field);
}

XPClassTest.prototype.testGetMethods = function() {
  var methods= this.getClass().getMethods();
  var names= '';
  for (var i= 0; i < methods.length; i++) {
    names += methods[i].getName()+ ',';
  }
  var o= names.indexOf(this.name);
  this.assertEquals(this.name, names.substring(o, names.indexOf(',', o)));
}

XPClassTest.prototype.testHasThisMethod = function() {
  var method= this.getClass().getMethod(this.name);
  this.assertInstanceOf('lang.reflect.Method', method);
}
// }}}
