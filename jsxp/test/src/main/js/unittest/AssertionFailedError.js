uses('lang.Throwable');

// {{{ AssertionFailedError
unittest.AssertionFailedError = define('unittest.AssertionFailedError', 'lang.Throwable', function(message) {
  lang.Throwable.call(this, message);
});
// }}}
