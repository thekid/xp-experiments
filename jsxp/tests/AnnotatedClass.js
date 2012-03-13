// {{{ XPClassTest
tests.AnnotatedClass = function() {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'tests.AnnotatedClass';
  }
}

tests.AnnotatedClass['@'] = {
  webservice : null
};
tests.AnnotatedClass.prototype= Object.create(lang.Object.prototype);
// }}}
