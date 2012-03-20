uses('lang.Throwable');

// {{{ ClassNotFoundException
lang.ClassNotFoundException = function(message) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'lang.ClassNotFoundException';
    lang.Throwable.call(this, message);
  }
}

extend(lang.ClassNotFoundException, lang.Throwable);
// }}}
