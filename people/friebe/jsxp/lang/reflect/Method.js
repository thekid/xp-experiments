// {{{ Method
lang.reflect.Method = function(clazz, name, modifiers) {
  {
    this.__class = 'lang.reflect.Method';
    this.clazz = clazz;
    this.name = name;
    this.modifiers = modifiers;
  }
}

lang.reflect.Method.prototype= new Object();

lang.reflect.Method.prototype.name = '';

lang.reflect.Method.prototype.getName = function() {
  return this.name;
}

lang.reflect.Method.prototype.toString = function() {
  return this.getClassName() + '<' + (this.modifiers & 1 ? 'static ' : '') + this.clazz.name + '::' + this.name + '>';
}

lang.reflect.Method.prototype.invoke = function(obj, args) {
  var handle = this.clazz.reflect;
  if (typeof(handle.prototype[this.name]) !== 'undefined') {
    return handle.prototype[this.name].apply(obj, args);
  } else {
    return handle[this.name].apply(obj, args);
  }
}
// }}}
