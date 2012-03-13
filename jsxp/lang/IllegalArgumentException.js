uses('lang.Throwable');

// {{{ IllegalArgumentException
lang.IllegalArgumentException = function(message) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'lang.IllegalArgumentException';
    lang.Throwable.call(this, message);
  }
}

lang.IllegalArgumentException.prototype= Object.create(lang.Throwable.prototype);
// }}}
