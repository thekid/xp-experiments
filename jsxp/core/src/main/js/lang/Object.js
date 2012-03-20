// {{{ Object
lang.Object = define('lang.Object', null, function Object() { });

// root-trait
lang.Object.prototype.getClass = function getClass() {
  return new lang.XPClass(this.__class);
}
lang.Object.prototype.getClassName = function getClassName() {
  return this.__class;
}
lang.Object.prototype.equals = function equals(cmp) {
  return this == cmp;
}
// root-trait

lang.Object.prototype.toString = function toString() {
  return stringOf(this);
}
// }}}
