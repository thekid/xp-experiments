uses('lang.Throwable');

// {{{ IllegalArgumentException
function IllegalArgumentException(message) {
  {
    Throwable.call(this, message);
    this.__class = 'IllegalArgumentException';
  }
}

IllegalArgumentException.prototype= new Throwable();
// }}}
