uses('lang.Throwable');

// {{{ ClassNotFoundException
lang.ClassNotFoundException = define('lang.ClassNotFoundException', 'lang.Throwable', function ClassNotFoundException(message) {
  lang.Throwable.call(this, message);
});

// }}}
