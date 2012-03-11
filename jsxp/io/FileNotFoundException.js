uses('io.IOException');

// {{{ FileNotFoundException
io.FileNotFoundException = function(message) {
  {
    io.IOException.call(this, message);
    this.__class = 'io.FileNotFoundException';
  }
}

io.FileNotFoundException.prototype= new io.IOException();
// }}}
