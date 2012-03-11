uses('lang.Throwable');

// {{{ ElementNotFoundException
lang.ElementNotFoundException = function(message) {
  {
    lang.Throwable.call(this, message);
    this.__class = 'lang.ElementNotFoundException';
  }
}

lang.ElementNotFoundException.prototype= new lang.Throwable();
// }}}
