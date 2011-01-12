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

Method.prototype.name = '';

Method.prototype.getName = function() {
  return this.name;
}

Method.prototype.toString = function() {
  return 'lang.reflect.Method<' + (this.modifiers & 1 ? 'static ' : '') + this.clazz.name + '::' + this.name + '>';
}

Method.prototype.invoke = function(obj, args) {
  var handle = $xp[this.clazz.reflect];
  if (typeof(handle.prototype[this.name]) !== 'undefined') {
    return handle.prototype[this.name].apply(obj, args);
  } else {
    return handle[this.name].apply(obj, args);
  }
}
// }}}
