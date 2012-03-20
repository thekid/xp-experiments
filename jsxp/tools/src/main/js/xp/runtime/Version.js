uses('util.cmd.Console');

// {{{ xp.runtime.Version
xp.runtime.Version = define('xp.runtime.Version', 'lang.Object', function() { });

xp.runtime.Version.main = function(args) {
  util.cmd.Console.writeLine('XP JS Microkernel ' + global.version + ' { ' + process.runtime() + ' } @ ' + process.os());
  util.cmd.Console.writeLine('Copyright (c) 2011-2012 the XP group');
  for (i = 0; i < global.classpath.length; i++) {
    util.cmd.Console.writeLine(global.classpath[i]);
  }
}
// }}}
