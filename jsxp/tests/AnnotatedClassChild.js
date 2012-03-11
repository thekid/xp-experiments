uses('tests.AnnotatedClass');

// {{{ AnnotatedClassChild
tests.AnnotatedClassChild = function() {
  {
    this.__class = 'tests.AnnotatedClassChild';
  }
}

tests.AnnotatedClassChild['@']= tests.AnnotatedClass['@'];
tests.AnnotatedClassChild.prototype= new tests.AnnotatedClass();
// }}}
