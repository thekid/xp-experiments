uses('lang.Throwable');

// {{{ AssertionFailedError
function AssertionFailedError(message) {
  {
    Throwable.call(this, message);
    this.__class = 'AssertionFailedError';
  }
}

AssertionFailedError.prototype= new Throwable();
// }}}
