// {{{ Hello
Hello = define('Hello', 'lang.Object', function Hello () { });

Hello.main = function Hello$main(args) {
  if (args.length < 1) {
    throw new lang.IllegalArgumentException('Argument required');
  }
  util.cmd.Console.writeLine('Hello ', args[0]);
}
// }}}
