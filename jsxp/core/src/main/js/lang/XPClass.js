uses('lang.reflect.Modifiers', 'lang.reflect.Field', 'lang.reflect.Method', 'lang.ElementNotFoundException', 'lang.ClassNotFoundException');

// {{{ XPClass
lang.XPClass = define('lang.XPClass', 'lang.Object', function XPClass(name) {
  this.name = name;
  this.reflect = global[name];
});

lang.XPClass.forName = function forName(name) {
  uses(name);
  if (global[name] === undefined) {
    throw new lang.ClassNotFoundException('Cannot find class "' + name + '"');
  }
  return new lang.XPClass(name);
}

lang.XPClass.prototype.toString = function toString() {
  return this.getClassName() + '<' + this.name + '>';
}

lang.XPClass.prototype.getName = function getName() {
  return this.name;
}

lang.XPClass.prototype.newInstance = function newInstance() {
  function Instance() { }
  Instance.prototype = this.reflect.prototype;

  var instance = new Instance();
  instance.constructor = this.reflect;
  this.reflect.apply(instance, arguments);
  return instance;
}

lang.XPClass.prototype.getParentclass = function getParentclass() {
  return new lang.XPClass(this.reflect.prototype.__super.__class);
}

lang.XPClass.prototype.hasMethod = function hasMethod(name) {
  return (name in this.reflect || name in this.reflect.prototype);
}

lang.XPClass.prototype.getMethod = function getMethod(name) {
  if (name in this.reflect || name in this.reflect.prototype) {
    return new lang.reflect.Method(this, name);
  }
  throw new lang.ElementNotFoundException('No such method ' + this.name + '::' + name);
}

lang.XPClass.prototype.getMethods = function getMethods() {
  var methods = new Array();
  var gather = function(self, object, parent, modifiers) {
    for (var member in object) {
      if ((parent || object.hasOwnProperty(member)) && typeof(object[member]) === 'function') {
        methods.push(new lang.reflect.Method(self, member, modifiers));
      }
    }
  };

  gather(this, this.reflect, false, lang.reflect.Modifiers.STATIC);
  gather(this, this.reflect.prototype, true, 0);
  return methods;
}

lang.XPClass.prototype.hasField = function hasField(name) {
  return (name in this.reflect || name in this.reflect.prototype);
}

lang.XPClass.prototype.getField = function getField(name) {
  if (name in this.reflect || name in this.reflect.prototype) {
    return new lang.reflect.Field(this, name);
  }
  throw new lang.ElementNotFoundException('No such field ' + this.name + '::' + name);
}

lang.XPClass.prototype.getFields = function getFields() {
  var fields = new Array();
  var gather = function(self, object, parent, modifiers) {
    for (var member in object) {
      if ((parent || object.hasOwnProperty(member)) && typeof(object[member]) !== 'function') {
        fields.push(new lang.reflect.Field(self, member, modifiers));
      }
    }
  };

  gather(this, this.reflect, false, lang.reflect.Modifiers.STATIC);
  gather(this, this.reflect.prototype, true, 0);
  return fields;
}

lang.XPClass.prototype.equals = function equals(cmp) {
  return this.name === cmp.name;
}

lang.XPClass.prototype.isInstance = function isInstance(instance) {
  return instance instanceof this.reflect;
}

lang.XPClass.prototype.hasAnnotations = function hasAnnotations() {
  return typeof(this.reflect['@']) !== 'undefined';
}

lang.XPClass.prototype.getAnnotations = function getAnnotations() {
  return this.hasAnnotations() ? this.reflect['@'] : [];
}

lang.XPClass.prototype.hasAnnotation = function hasAnnotation(name) {
  return this.hasAnnotations() && typeof(this.reflect['@'][name]) !== 'undefined';
}

lang.XPClass.prototype.getAnnotation = function getAnnotation(name) {
  if (!this.hasAnnotation(name)) {
    throw new lang.ElementNotFoundException('No such annotation "' + name + '"');
  }
  return this.reflect['@'][name];
}
// }}}
