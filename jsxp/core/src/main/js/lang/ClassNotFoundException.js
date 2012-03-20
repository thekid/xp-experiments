uses('lang.Throwable');

// {{{ ClassNotFoundException
lang.ClassNotFoundException = define('lang.ClassNotFoundException', 'lang.Throwable', function(message) {
  lang.Throwable.call(this, message);
});

// }}}
