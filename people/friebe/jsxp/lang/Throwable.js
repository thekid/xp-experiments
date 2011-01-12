// {{{ Throwable
function Throwable(message) {
  {
    this.__class = 'Throwable';
    this.message = message;
    // this.fillInStacktrace(arguments.callee.caller);
  }  
}

Throwable.prototype= new Error();

Throwable.prototype.message = '';
Throwable.prototype.stacktrace = new Array();

Throwable.prototype.fillInStacktrace = function (f) {
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

Throwable.prototype.toString = function() {
  var r = this.__class + '(' + this.message + ")\n";
  for (var i= 0; i < this.stacktrace.length; i++) {
    r += '  at ' + this.stacktrace[i] + "\n";
  }
  r += '  at <main>';
  return r;
}
// }}}
