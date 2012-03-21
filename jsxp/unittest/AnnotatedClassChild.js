uses('tests.AnnotatedClass');

// {{{ AnnotatedClassChild
tests.AnnotatedClassChild = define('tests.AnnotatedClassChild', 'tests.AnnotatedClass', function() { });
tests.AnnotatedClassChild['@']= tests.AnnotatedClass['@'];
// }}}
