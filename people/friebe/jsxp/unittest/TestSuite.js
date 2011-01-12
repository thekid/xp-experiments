uses('unittest.AssertionFailedError', 'unittest.TestFailure', 'unittest.TestSuccess');

// {{{ TestSuite
function TestSuite() {
  {
    this.__class = 'TestSuite';
  }
}

TestSuite.prototype= new Object();

TestSuite.prototype.tests = new Array();
TestSuite.prototype.outcome = new Array();

TestSuite.prototype.addTestClass = function(clazz) {
  this.tests.push(clazz);
}

TestSuite.prototype.run = function() {

  // Run tests
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
        this.outcome.push(new TestSuccess(instance));
      } catch (e) {
        Console.write('E');
        this.outcome.push(new TestFailure(instance, e));
      }
      instance.tearDown();
    }
  }
  Console.writeLine(']');
  Console.writeLine();
  
  // Display all failures
  var failed= 0;
  var total= 0;
  for (var i= 0; i < this.outcome.length; i++) {
    total++;
    if (!(this.outcome[i] instanceof TestFailure)) continue;
    failed++;
    Console.writeLine('F ', this.outcome[i].toString());
  }
  Console.writeLine(
    failed ? 'FAIL: ' : 'OK: ', 
    total.toString(), ' run, ', 
    (total - failed).toString(), ' succeeded, ', 
    failed.toString(), ' failed'
  );
}
// }}}
