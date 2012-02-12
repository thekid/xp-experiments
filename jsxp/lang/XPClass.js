uses('lang.reflect.Field', 'lang.reflect.Method');

// {{{ XPClass
lang.XPClass = function(name) {
  {
    this.__class = 'lang.XPClass';
    this.name = name;
    this.reflect = global[name];
  }
}

lang.XPClass.forName = function(name) {
  uses(name);
  return new lang.XPClass(name);
}

lang.XPClass.prototype= new Object();

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

lang.XPClass.prototype.getMethod = function(name) {
  if (typeof(this.reflect[name]) !== 'function') {
    if (typeof(this.reflect.prototype[name]) !== 'function') {
      throw new lang.IllegalArgumentException('No such method ' + this.name + '::' + name);
    }
  }
  return new lang.reflect.Method(this, name);
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

  gather(this, this.reflect, false, Modifiers.STATIC);
  gather(this, this.reflect.prototype, true, 0);
  return methods;
}

lang.XPClass.prototype.getField = function(name) {
  if (typeof(this.reflect[name]) === 'function') {
    throw new lang.IllegalArgumentException('No such field ' + this.name + '::' + name);
  }
  return new lang.reflect.Field(this, name);
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

  gather(this, this.reflect, false, Modifiers.STATIC);
  gather(this, this.reflect.prototype, true, 0);
  return fields;
}

lang.XPClass.prototype.equals = function(cmp) {
  return this.name === cmp.name;
}
// }}}
