// {{{ Field
lang.reflect.Field = define('lang.reflect.Field', 'lang.Object', function(clazz, name, modifiers) {
  this.clazz = clazz;
  this.name = name;
  this.modifiers = modifiers;
});

lang.reflect.Field.prototype.getName = function() {
  return this.name;
}

lang.reflect.Field.prototype.toString = function() {
  return this.getClassName() + '<' + (this.modifiers & 1 ? 'static ' : '') + this.clazz.name + '::' + this.name + '>';
}
// }}}
