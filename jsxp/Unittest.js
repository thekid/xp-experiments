uses('unittest.TestSuite');

// {{{ Unittest
Unittest = function() {
  {
    this.__class = 'Unittest';
  }
}

Unittest.prototype = new Object();

Unittest.main = function(args) {
  var suite = new unittest.TestSuite();
  for (var i= 0; i < args.length; i++) {
    suite.addTestClass(lang.XPClass.forName(args[i]));
  }
  suite.run();
}
// }}}
