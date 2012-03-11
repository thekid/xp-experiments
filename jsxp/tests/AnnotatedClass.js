// {{{ XPClassTest
tests.AnnotatedClass = function() {
  {
    this.__class = 'tests.AnnotatedClass';
  }
}

tests.AnnotatedClass['@'] = {
  webservice : null
};
tests.AnnotatedClass.prototype= new lang.Object();
// }}}
