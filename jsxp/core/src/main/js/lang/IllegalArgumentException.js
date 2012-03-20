uses('lang.Throwable');

// {{{ IllegalArgumentException
lang.IllegalArgumentException = define('lang.IllegalArgumentException', 'lang.Throwable', function IllegalArgumentException(message) {
  lang.Throwable.call(this, message);
});
// }}}
