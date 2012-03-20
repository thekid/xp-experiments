// {{{ Field
lang.reflect.Field = define('lang.reflect.Field', 'lang.Object', function Field(clazz, name, modifiers) {
  this.clazz = clazz;
  this.name = name;
  this.modifiers = modifiers;
});

lang.reflect.Field.prototype.getName = function getName() {
  return this.name;
}

lang.reflect.Field.prototype.toString = function toString() {
  return this.getClassName() + '<' + (this.modifiers & 1 ? 'static ' : '') + this.clazz.name + '::' + this.name + '>';
}
// }}}
