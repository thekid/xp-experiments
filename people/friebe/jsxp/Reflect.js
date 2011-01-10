// {{{ Reflect
function Reflect() {
  {
    this.__class = 'Reflect';
  }
}

Reflect.main = function(args) {
  clazz= XPClass.forName(args[0]);

  Console.writeLine(clazz);
  Console.writeLine('Methods: ', clazz.getMethods());
  Console.writeLine('Fields:  ', clazz.getFields());

  instance= clazz.newInstance();
  Console.writeLine(instance);
  Console.writeLine(instance.getClass());
}
// }}}
