uses('io.IOException');

// {{{ FileNotFoundException
io.FileNotFoundException = define('io.FileNotFoundException', 'io.IOException', function(message) {
  lang.Throwable.call(this, message);
});
// }}}
