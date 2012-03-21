lang.reflect.Package = define('lang.reflect.Package', 'lang.Object', function Package(name) {
  this.name = name;
});

lang.reflect.Package.prototype.name = '';

lang.reflect.Package.prototype.getName = function Package$getName() {
  return this.name;
}

lang.reflect.Package.prototype.toString = function Package$toString() {
  return this.getClassName() + '<' + this.name + '>';
}

lang.reflect.Package.prototype.equals = function Package$equals(cmp) {
  return cmp instanceof lang.reflect.Package && cmp.name === this.name;
}
// }}}
