uses('tests.AnnotatedClass');

// {{{ AnnotatedClassChild
tests.AnnotatedClassChild = function() {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'tests.AnnotatedClassChild';
  }
}

tests.AnnotatedClassChild['@']= tests.AnnotatedClass['@'];
tests.AnnotatedClassChild.prototype= Object.create(tests.AnnotatedClass.prototype);
// }}}
