// {{{ Throwable
lang.Throwable = function(message) {
  {
    this.__class = 'lang.Throwable';
    this.message = message;
    // this.fillInStacktrace(arguments.callee.caller);
  }  
}

lang.Throwable.prototype= new Error();

lang.Throwable.prototype.message = '';
lang.Throwable.prototype.stacktrace = new Array();

lang.Throwable.prototype.fillInStacktrace = function (f) {
  var representation;
  while (f) {
    representation = f.toString();
    this.stacktrace.push(representation.substring(
      0, 
      representation.indexOf(' {')
    ));
    f = f.caller;
  }
}

lang.Throwable.prototype.toString = function() {
  var r = this.__class + '(' + this.message + ")\n";
  for (var i= 0; i < this.stacktrace.length; i++) {
    r += '  at ' + this.stacktrace[i] + "\n";
  }
  r += '  at <main>';
  return r;
}
// }}}
