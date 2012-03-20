uses('lang.ElementNotFoundException');

// {{{ Method
lang.reflect.Method = define('lang.reflect.Method', 'lang.Object', function Method(clazz, name, modifiers) {
  this.clazz = clazz;
  if (typeof(clazz.reflect.prototype[name]) !== 'undefined') {
    this.reflect = clazz.reflect.prototype[name];
  } else {
    this.reflect = clazz.reflect[name];
  }
  this.name = name;
  this.modifiers = modifiers;
});

lang.reflect.Method.prototype.name = '';

lang.reflect.Method.prototype.getName = function getName() {
  return this.name;
}

lang.reflect.Method.prototype.toString = function toString() {
  return this.getClassName() + '<' + (this.modifiers & 1 ? 'static ' : '') + this.clazz.name + '::' + this.name + '>';
}

lang.reflect.Method.prototype.invoke = function invoke(obj, args) {
  return this.reflect.apply(obj, args);
}

lang.reflect.Method.prototype.hasAnnotations = function hasAnnotations(name) {
  return typeof(this.reflect['@']) !== 'undefined';
}

lang.reflect.Method.prototype.hasAnnotation = function hasAnnotation(name) {
  return this.hasAnnotations() && typeof(this.reflect['@'][name]) !== 'undefined';
}

lang.reflect.Method.prototype.getAnnotation = function getAnnotation(name) {
  if (!this.hasAnnotation(name)) {
    throw new lang.ElementNotFoundException('No such annotation "' + name + '"');
  }
  return this.reflect['@'][name];
}
// }}}
