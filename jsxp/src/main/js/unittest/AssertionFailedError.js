uses('lang.Throwable');

// {{{ AssertionFailedError
unittest.AssertionFailedError = function(message) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'unittest.AssertionFailedError';
    lang.Throwable.call(this, message);
  }
}

extend(unittest.AssertionFailedError, lang.Throwable);
// }}}
