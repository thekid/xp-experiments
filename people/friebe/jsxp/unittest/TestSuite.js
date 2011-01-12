uses('unittest.AssertionFailedError');

// {{{ TestSuite
function TestSuite(name) {
  {
    this.__class = 'TestSuite';
  }
}

TestSuite.prototype= new Object();

TestSuite.prototype.tests = new Array();

TestSuite.prototype.addTestClass = function(clazz) {
  this.tests.push(clazz);
}

TestSuite.prototype.run = function() {
  Console.write('[');
  for (var i= 0; i < this.tests.length; i++) {
    var methods = this.tests[i].getMethods();

    for (var m= 0; m < methods.length; m++) {
      if ('test' !== methods[m].getName().substring(0, 4)) continue;
      var instance = this.tests[i].newInstance(methods[m].getName());
      
      instance.setUp();
      try {
        methods[m].invoke(instance, []);
        Console.write('.');
      } catch (e) {
        Console.write('E');
      }
      instance.tearDown();
    }
  }
  Console.writeLine(']');
}
// }}}
