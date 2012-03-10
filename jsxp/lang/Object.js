// {{{ Object
lang.Object = function() {
  {
    this.__class = 'lang.Object';
  }  
}

lang.Object.prototype= new Object();

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

// }}}
