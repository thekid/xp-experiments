// {{{ Method
function Method(clazz, name, modifiers) {
  {
    this.__class = 'Method';
    this.clazz = clazz;
    this.name = name;
    this.modifiers = modifiers;
  }
}

Method.prototype= new Object();

Method.prototype.toString = function() {
  return 'lang.reflect.Method<' + (this.modifiers & 1 ? 'static ' : '') + this.clazz.name + '::' + this.name + '>';
}

Method.prototype.invoke = function(obj, args) {
  return $xp[this.clazz.name][this.name].apply(obj, args);
}
// }}}
