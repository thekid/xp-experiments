uses('lang.Throwable');

// {{{ AssertionFailedError
unittest.AssertionFailedError = function(message) {
  {
    lang.Throwable.call(this, message);
    this.__class = 'unittest.AssertionFailedError';
  }
}

unittest.AssertionFailedError.prototype= new lang.Throwable();
// }}}
