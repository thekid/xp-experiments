uses('unittest.TestCase', 'tests.AnnotatedClass', 'tests.AnnotatedClassChild');

// {{{ XPClassTest
tests.XPClassTest = function(name) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'tests.XPClassTest';
    unittest.TestCase.call(this, name);
  }
}

extend(tests.XPClassTest, unittest.TestCase);

tests.XPClassTest.prototype.getName = function() {
  this.assertEquals('tests.XPClassTest', this.getClass().getName());
}
tests.XPClassTest.prototype.getName['@']= { test : null };

tests.XPClassTest.prototype.forName = function() {
  this.assertEquals(this.getClass(), lang.XPClass.forName('tests.XPClassTest'));
}
tests.XPClassTest.prototype.forName['@']= { test : null };

tests.XPClassTest.prototype.getFields = function() {
  var fields= this.getClass().getFields();
  var names= '';
  for (var i= 0; i < fields.length; i++) {
    names += fields[i].getName()+ ',';
  }
  var o= names.indexOf('name');
  this.assertEquals('name', names.substring(o, names.indexOf(',', o)));
}
tests.XPClassTest.prototype.getFields['@']= { test : null };

tests.XPClassTest.prototype.hasNameField = function() {
  var field= this.getClass().getField('name');
  this.assertInstanceOf('lang.reflect.Field', field);
}
tests.XPClassTest.prototype.hasNameField['@']= { test : null };

tests.XPClassTest.prototype.getMethods = function() {
  var methods= this.getClass().getMethods();
  var names= '';
  for (var i= 0; i < methods.length; i++) {
    names += methods[i].getName()+ ',';
  }
  var o= names.indexOf(this.name);
  this.assertEquals(this.name, names.substring(o, names.indexOf(',', o)));
}
tests.XPClassTest.prototype.getMethods['@']= { test : null };

tests.XPClassTest.prototype.hasThisMethod = function() {
  var method= this.getClass().getMethod(this.name);
  this.assertInstanceOf('lang.reflect.Method', method);
}
tests.XPClassTest.prototype.hasThisMethod['@']= { test : null };

tests.XPClassTest.prototype.thisIsInstanceofSelf = function() {
  this.assertEquals(true, this.getClass().isInstance(this));
}
tests.XPClassTest.prototype.thisIsInstanceofSelf['@']= { test : null };

tests.XPClassTest.prototype.thisIsInstanceofParentClass = function() {
  this.assertEquals(true, lang.XPClass.forName('unittest.TestCase').isInstance(this));
}
tests.XPClassTest.prototype.thisIsInstanceofParentClass['@']= { test : null };

tests.XPClassTest.prototype.objectClassHasAnnotations = function() {
  this.assertEquals(false, lang.XPClass.forName('lang.Object').hasAnnotations());
}
tests.XPClassTest.prototype.objectClassHasAnnotations['@']= { test : null };

tests.XPClassTest.prototype.objectClassHasAnnotation = function() {
  this.assertEquals(false, lang.XPClass.forName('lang.Object').hasAnnotation('webservice'));
}
tests.XPClassTest.prototype.objectClassHasAnnotation['@']= { test : null };

tests.XPClassTest.prototype.objectClassAnnotation = function() {
  lang.XPClass.forName('lang.Object').getAnnotation('webservice');
}
tests.XPClassTest.prototype.objectClassAnnotation['@']= { test : { expect : 'lang.ElementNotFoundException' } };

tests.XPClassTest.prototype.annotatedClassHasAnnotations = function() {
  this.assertEquals(true, lang.XPClass.forName('tests.AnnotatedClass').hasAnnotations());
}
tests.XPClassTest.prototype.annotatedClassHasAnnotations['@']= { test : null };

tests.XPClassTest.prototype.annotatedClassHasAnnotation = function() {
  this.assertEquals(true, lang.XPClass.forName('tests.AnnotatedClass').hasAnnotation('webservice'));
}
tests.XPClassTest.prototype.annotatedClassHasAnnotation['@']= { test : null };

tests.XPClassTest.prototype.annotatedClassChildHasAnnotations = function() {
  this.assertEquals(true, lang.XPClass.forName('tests.AnnotatedClassChild').hasAnnotations());
}
tests.XPClassTest.prototype.annotatedClassChildHasAnnotations['@']= { test : null };

tests.XPClassTest.prototype.annotatedClassAnnotation = function() {
  this.assertEquals(null, lang.XPClass.forName('tests.AnnotatedClass').getAnnotation('webservice'));
}
tests.XPClassTest.prototype.annotatedClassAnnotation['@']= { test : null };

tests.XPClassTest.prototype.annotatedClassChildHasAnnotation = function() {
  this.assertEquals(true, lang.XPClass.forName('tests.AnnotatedClassChild').hasAnnotation('webservice'));
}
tests.XPClassTest.prototype.annotatedClassChildHasAnnotation['@']= { test : null };
// }}}
