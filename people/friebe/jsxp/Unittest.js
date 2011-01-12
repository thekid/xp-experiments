uses('unittest.TestSuite');

// {{{ Unittest
function Unittest() {
  {
    this.__class = 'Unittest';
  }
}

Unittest.prototype = new Object();

Unittest.main = function(args) {
  var suite = new TestSuite();
  for (var i= 0; i < args.length; i++) {
    suite.addTestClass(XPClass.forName(args[i]));
  }
  suite.run();
}
// }}}
