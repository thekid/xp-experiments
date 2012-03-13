uses('io.IOException');

// {{{ FileNotFoundException
io.FileNotFoundException = function(message) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'io.FileNotFoundException';
    io.IOException.call(this, message);
  }
}

io.FileNotFoundException.prototype= Object.create(io.IOException.prototype);
// }}}
