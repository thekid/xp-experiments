// {{{ Object
lang.Object = define('lang.Object', null, function() { });

// root-trait
lang.Object.prototype.getClass = function() {
  return new lang.XPClass(this.__class);
}
lang.Object.prototype.getClassName = function() {
  return this.__class;
}
lang.Object.prototype.equals = function(cmp) {
  return this == cmp;
}
// root-trait

lang.Object.prototype.toString = function() {
  return stringOf(this);
}
// }}}
