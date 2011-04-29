uses('unittest.TestCase');

// {{{ XPClassTest
tests.XPClassTest = function(name) {
  {
    unittest.TestCase.call(this, name);
    this.__class = 'tests.XPClassTest';
  }
}

tests.XPClassTest.prototype= new unittest.TestCase();

tests.XPClassTest.prototype.testGetName = function() {
  this.assertEquals('tests.XPClassTest', this.getClass().getName());
}

tests.XPClassTest.prototype.testForName = function() {
  this.assertEquals(this.getClass(), lang.XPClass.forName('tests.XPClassTest'));
}

tests.XPClassTest.prototype.testGetFields = function() {
  var fields= this.getClass().getFields();
  var names= '';
  for (var i= 0; i < fields.length; i++) {
    names += fields[i].getName()+ ',';
  }
  var o= names.indexOf('name');
  this.assertEquals('name', names.substring(o, names.indexOf(',', o)));
}

tests.XPClassTest.prototype.testHasNameField = function() {
  var field= this.getClass().getField('name');
  this.assertInstanceOf('lang.reflect.Field', field);
}

tests.XPClassTest.prototype.testGetMethods = function() {
  var methods= this.getClass().getMethods();
  var names= '';
  for (var i= 0; i < methods.length; i++) {
    names += methods[i].getName()+ ',';
  }
  var o= names.indexOf(this.name);
  this.assertEquals(this.name, names.substring(o, names.indexOf(',', o)));
}

tests.XPClassTest.prototype.testHasThisMethod = function() {
  var method= this.getClass().getMethod(this.name);
  this.assertInstanceOf('lang.reflect.Method', method);
}
// }}}
