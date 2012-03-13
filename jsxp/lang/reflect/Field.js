// {{{ Field
lang.reflect.Field = function(clazz, name, modifiers) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'lang.reflect.Field';
    this.clazz = clazz;
    this.name = name;
    this.modifiers = modifiers;
  }
}

lang.reflect.Field.prototype= Object.create(lang.Object.prototype);

lang.reflect.Field.prototype.getName = function() {
  return this.name;
}

lang.reflect.Field.prototype.toString = function() {
  return this.getClassName() + '<' + (this.modifiers & 1 ? 'static ' : '') + this.clazz.name + '::' + this.name + '>';
}
// }}}
