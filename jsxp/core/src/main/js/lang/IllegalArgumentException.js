uses('lang.Throwable');

// {{{ IllegalArgumentException
lang.IllegalArgumentException = define('lang.IllegalArgumentException', 'lang.Throwable', function(message) {
  lang.Throwable.call(this, message);
});
// }}}
