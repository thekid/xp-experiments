uses('tests.AnnotatedClass');

// {{{ AnnotatedClassChild
tests.AnnotatedClassChild = function() {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'tests.AnnotatedClassChild';
  }
}

tests.AnnotatedClassChild['@']= tests.AnnotatedClass['@'];
extend(tests.AnnotatedClassChild, tests.AnnotatedClass);
// }}}
