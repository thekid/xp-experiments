uses('unittest.TestSuite', 'lang.reflect.Package');

// {{{ Unittest
Unittest = define('Unittest', 'lang.Object', function Unittest() { });

Unittest.main = function Unittest$main(args) {
  var suite = new unittest.TestSuite();
  for (var i= 0; i < args.length; i++) {
    if (-1 !== (p= args[i].indexOf('.*'))) {
      var classes = lang.reflect.Package.forName(args[i].substring(0, p)).getClasses();
      for (var c in classes) {
        suite.addTestClass(classes[c]);
      }
    } else {
      suite.addTestClass(lang.XPClass.forName(args[i]));
    }
  }
  var start = new Date();
  suite.run();
  var end = new Date();

  util.cmd.Console.writeLine('Memory used: ', process.memoryUsage().rss / 1024, ' kB');
  util.cmd.Console.writeLine('Time taken: ', (end.getMilliseconds() - start.getMilliseconds()) / 1000, ' sec(s)');
}
// }}}
