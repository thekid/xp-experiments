uses('lang.Throwable');

// {{{ IOException
io.IOException = function(message) {
  {
    lang.Throwable.call(this, message);
    this.__class = 'io.IOException';
  }
}

io.IOException.prototype= new lang.Throwable();
// }}}

