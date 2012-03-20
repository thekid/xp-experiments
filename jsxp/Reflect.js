// {{{ Reflect
Reflect = define('Reflect', 'lang.Object', function() { });

Reflect.prototype.toString = function() {
  return "Reflect instance";
};

Reflect.main = function(args) {
  clazz= lang.XPClass.forName(args[0]);

  util.cmd.Console.writeLine(clazz);
  util.cmd.Console.writeLine('Methods: ', clazz.getMethods());
  util.cmd.Console.writeLine('Fields:  ', clazz.getFields());

  instance= clazz.newInstance();
  util.cmd.Console.writeLine(instance);
  util.cmd.Console.writeLine(instance.getClass());
}
// }}}
