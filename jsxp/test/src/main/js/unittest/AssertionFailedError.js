uses('lang.Throwable');

// {{{ AssertionFailedError
unittest.AssertionFailedError = define('unittest.AssertionFailedError', 'lang.Throwable', function AssertionFailedError(message) {
  lang.Throwable.call(this, message);
});
// }}}
