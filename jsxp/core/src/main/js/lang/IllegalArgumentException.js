uses('lang.Throwable');

// {{{ IllegalArgumentException
lang.IllegalArgumentException = function(message) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'lang.IllegalArgumentException';
    lang.Throwable.call(this, message);
  }
}

extend(lang.IllegalArgumentException, lang.Throwable);
// }}}
