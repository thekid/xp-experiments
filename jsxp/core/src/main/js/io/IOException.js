uses('lang.Throwable');

// {{{ IOException
io.IOException = define('io.IOException', 'lang.Throwable', function(message) {
  lang.Throwable.call(this, message);
});
// }}}

