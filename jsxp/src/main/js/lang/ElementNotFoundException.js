uses('lang.Throwable');

// {{{ ElementNotFoundException
lang.ElementNotFoundException = function(message) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'lang.ElementNotFoundException';
    lang.Throwable.call(this, message);
  }
}

extend(lang.ElementNotFoundException, lang.Throwable);
// }}}
