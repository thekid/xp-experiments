uses('lang.ElementNotFoundException');

// {{{ Method
lang.reflect.Method = function(clazz, name, modifiers) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'lang.reflect.Method';
    this.clazz = clazz;
    if (typeof(clazz.reflect.prototype[name]) !== 'undefined') {
      this.reflect = clazz.reflect.prototype[name];
    } else {
      this.reflect = clazz.reflect[name];
    }
    this.name = name;
    this.modifiers = modifiers;
  }
}

extend(lang.reflect.Method, lang.Object);

lang.reflect.Method.prototype.name = '';

lang.reflect.Method.prototype.getName = function() {
  return this.name;
}

lang.reflect.Method.prototype.toString = function() {
  return this.getClassName() + '<' + (this.modifiers & 1 ? 'static ' : '') + this.clazz.name + '::' + this.name + '>';
}

lang.reflect.Method.prototype.invoke = function(obj, args) {
  return this.reflect.apply(obj, args);
}

lang.reflect.Method.prototype.hasAnnotations = function(name) {
  return typeof(this.reflect['@']) !== 'undefined';
}

lang.reflect.Method.prototype.hasAnnotation = function(name) {
  return this.hasAnnotations() && typeof(this.reflect['@'][name]) !== 'undefined';
}

lang.reflect.Method.prototype.getAnnotation = function(name) {
  if (!this.hasAnnotation(name)) {
    throw new lang.ElementNotFoundException('No such annotation "' + name + '"');
  }
  return this.reflect['@'][name];
}
// }}}
