// {{{ XPClassTest
tests.AnnotatedClass = function() {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'tests.AnnotatedClass';
  }
}

tests.AnnotatedClass['@'] = {
  webservice : null
};
extend(tests.AnnotatedClass, lang.Object);
// }}}
