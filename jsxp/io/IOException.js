uses('lang.Throwable');

// {{{ IOException
io.IOException = function(message) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'io.IOException';
    lang.Throwable.call(this, message);
  }
}

io.IOException.prototype= Object.create(lang.Throwable.prototype);
// }}}

