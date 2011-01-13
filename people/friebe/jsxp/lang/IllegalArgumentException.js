uses('lang.Throwable');

// {{{ IllegalArgumentException
lang.IllegalArgumentException = function(message) {
  {
    lang.Throwable.call(this, message);
    this.__class = 'lang.IllegalArgumentException';
  }
}

lang.IllegalArgumentException.prototype= new lang.Throwable();
// }}}
