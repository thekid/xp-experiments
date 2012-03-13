uses('lang.Throwable');

// {{{ ElementNotFoundException
lang.ElementNotFoundException = function(message) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'lang.ElementNotFoundException';
    lang.Throwable.call(this, message);
  }
}

lang.ElementNotFoundException.prototype= Object.create(lang.Throwable.prototype);
// }}}
