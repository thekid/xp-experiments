uses('io.File');

// {{{ FileInputStream
io.streams.FileInputStream = function(origin) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'io.streams.FileInputStream';
    if (origin instanceof io.File) {
      this.file = origin;
      this.file.isOpen() || this.file.open('r');
    } else {
      this.file = new io.File(origin);
      this.file.open('r');
    }
  }
}

extend(io.streams.FileInputStream, lang.Object);

io.streams.FileInputStream.prototype.read = function(max) {
  var b = this.file.read(max);
  return false === b ? '' : b;
}

io.streams.FileInputStream.prototype.close = function() {
  this.file.close();
}
