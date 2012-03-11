// {{{ Method
lang.reflect.Method = function(clazz, name, modifiers) {
  {
    this.__class = 'lang.reflect.Method';
    this.clazz = clazz;
    this.name = name;
    this.modifiers = modifiers;
  }
}

lang.reflect.Method.prototype= new lang.Object();

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

lang.reflect.Method.prototype.hasAnnotations = function(name) {
  var handle = this.clazz.reflect;
  if (typeof(handle.prototype[this.name]) !== 'undefined') {
    return typeof(handle.prototype[this.name]['@']) !== 'undefined';
  } else {
    return typeof(handle[this.name]['@']) !== 'undefined';
  }
}

lang.reflect.Method.prototype.hasAnnotation = function(name) {
  if (!this.hasAnnotations()) return false;
  var handle = this.clazz.reflect;
  if (typeof(handle.prototype[this.name]) !== 'undefined') {
    return typeof(handle.prototype[this.name]['@'][name]) !== 'undefined';
  } else {
    return typeof(handle[this.name]['@'][name]) !== 'undefined';
  }
}

lang.reflect.Method.prototype.getAnnotation = function(name) {
  if (!this.hasAnnotation(name)) return false;
  var handle = this.clazz.reflect;
  if (typeof(handle.prototype[this.name]) !== 'undefined') {
    return handle.prototype[this.name]['@'][name];
  } else {
    return handle[this.name]['@'][name];
  }
}
// }}}
