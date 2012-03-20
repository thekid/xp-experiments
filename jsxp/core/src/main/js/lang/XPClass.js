uses('lang.reflect.Modifiers', 'lang.reflect.Field', 'lang.reflect.Method', 'lang.ElementNotFoundException', 'lang.ClassNotFoundException');

// {{{ XPClass
lang.XPClass = function(name) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'lang.XPClass';
    this.name = name;
    this.reflect = global[name];
  }
}

extend(lang.XPClass, lang.Object);

lang.XPClass.forName = function(name) {
  uses(name);
  if (global[name] === undefined) {
    throw new lang.ClassNotFoundException('Cannot find class "' + name + '"');
  }
  return new lang.XPClass(name);
}

lang.XPClass.prototype.toString = function() {
  return this.getClassName() + '<' + this.name + '>';
}

lang.XPClass.prototype.getName = function() {
  return this.name;
}

lang.XPClass.prototype.newInstance = function() {
  function Instance() { }
  Instance.prototype = this.reflect.prototype;

  var instance = new Instance();
  instance.constructor = this.reflect;
  this.reflect.apply(instance, arguments);
  return instance;
}

lang.XPClass.prototype.hasMethod = function(name) {
  return (name in this.reflect || name in this.reflect.prototype);
}

lang.XPClass.prototype.getMethod = function(name) {
  if (name in this.reflect || name in this.reflect.prototype) {
    return new lang.reflect.Method(this, name);
  }
  throw new lang.ElementNotFoundException('No such method ' + this.name + '::' + name);
}

lang.XPClass.prototype.getMethods = function() {
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

lang.XPClass.prototype.hasField = function(name) {
  return (name in this.reflect || name in this.reflect.prototype);
}

lang.XPClass.prototype.getField = function(name) {
  if (name in this.reflect || name in this.reflect.prototype) {
    return new lang.reflect.Field(this, name);
  }
  throw new lang.ElementNotFoundException('No such field ' + this.name + '::' + name);
}

lang.XPClass.prototype.getFields = function() {
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

lang.XPClass.prototype.equals = function(cmp) {
  return this.name === cmp.name;
}

lang.XPClass.prototype.isInstance = function(instance) {
  return instance instanceof this.reflect;
}

lang.XPClass.prototype.hasAnnotations = function() {
  return typeof(this.reflect['@']) !== 'undefined';
}

lang.XPClass.prototype.getAnnotations = function() {
  return this.hasAnnotations() ? this.reflect['@'] : [];
}

lang.XPClass.prototype.hasAnnotation = function(name) {
  return this.hasAnnotations() && typeof(this.reflect['@'][name]) !== 'undefined';
}

lang.XPClass.prototype.getAnnotation = function(name) {
  if (!this.hasAnnotation(name)) {
    throw new lang.ElementNotFoundException('No such annotation "' + name + '"');
  }
  return this.reflect['@'][name];
}
// }}}
