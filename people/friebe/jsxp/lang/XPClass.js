uses('lang.reflect.Field', 'lang.reflect.Method');

// {{{ XPClass
function XPClass(name) {
  {
    this.__class = 'lang.XPClass';
    this.name = name;
    this.reflect = name.substring(name.lastIndexOf('.')+ 1, name.length);
  }
}

XPClass.forName = function(name) {
  uses(name);
  return new XPClass(name);
}

XPClass.prototype= new Object();

XPClass.prototype.toString = function() {
  return this.getClassName() + '<' + this.name + '>';
}

XPClass.prototype.getName = function() {
  return this.name;
}

XPClass.prototype.newInstance = function() {
  function Instance() { }
  Instance.prototype = $xp[this.reflect].prototype;

  var instance = new Instance();
  instance.constructor = $xp[this.reflect];
  $xp[this.reflect].apply(instance, arguments);
  return instance;
}

XPClass.prototype.getMethod = function(name) {
  if (typeof($xp[this.reflect][name]) !== 'function') {
    if (typeof($xp[this.reflect].prototype[name]) !== 'function') {
      throw new IllegalArgumentException('No such method ' + this.name + '::' + name);
    }
  }
  return new Method(this, name);
}

XPClass.prototype.getMethods = function() {
  var methods = new Array();
  var gather = function(self, object, parent, modifiers) {
    for (var member in object) {
      if ((parent || object.hasOwnProperty(member)) && typeof(object[member]) === 'function') {
        methods.push(new Method(self, member, modifiers));
      }
    }
  };

  gather(this, $xp[this.reflect], false, Modifiers.STATIC);
  gather(this, $xp[this.reflect].prototype, true, 0);
  return methods;
}

XPClass.prototype.getField = function(name) {
  if (typeof($xp[this.reflect][name]) === 'function') {
    throw new IllegalArgumentException('No such field ' + this.name + '::' + name);
  }
  return new Field(this, name);
}

XPClass.prototype.getFields = function() {
  var fields = new Array();
  var gather = function(self, object, parent, modifiers) {
    for (var member in object) {
      if ((parent || object.hasOwnProperty(member)) && typeof(object[member]) !== 'function') {
        fields.push(new Field(self, member, modifiers));
      }
    }
  };

  gather(this, $xp[this.reflect], false, Modifiers.STATIC);
  gather(this, $xp[this.reflect].prototype, true, 0);
  return fields;
}

Object.prototype.equals = function(cmp) {
  return this.name === cmp.name;
}
// }}}
