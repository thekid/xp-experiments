// {{{ Console
function Console() {
  {
    this.__class = 'Console';
  }
}

Console.write = function() {
  for (var i= 0; i < arguments.length; i++) {
    WScript.StdOut.Write(arguments[i]);
  }
}

Console.writeLine = function() {
  for (var i= 0; i < arguments.length; i++) {
    WScript.StdOut.Write(arguments[i]);
  }
  WScript.StdOut.WriteBlankLines(1);
}

Console.prototype= new Object();
// }}}

