uses('lang.Throwable');

// {{{ ElementNotFoundException
lang.ElementNotFoundException = define('lang.ElementNotFoundException', 'lang.Throwable', function ElementNotFoundException(message) {
  lang.Throwable.call(this, message);
});
// }}}
