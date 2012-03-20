uses('unittest.TestSuite');

// {{{ Unittest
Unittest = define('Unittest', 'lang.Object', function() { });

Unittest.main = function(args) {
  var suite = new unittest.TestSuite();
  for (var i= 0; i < args.length; i++) {
    suite.addTestClass(lang.XPClass.forName(args[i]));
  }
  suite.run();
}
// }}}
