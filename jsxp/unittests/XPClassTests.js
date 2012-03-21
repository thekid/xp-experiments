uses('unittest.TestCase');






;





unittests.XPClassTests= define('unittests.XPClassTests','unittest.TestCase',function XPClassTests(){unittest.TestCase.apply(this, arguments);});






unittests.XPClassTests.prototype.className= function XPClassTests$className(){
this.assertEquals('unittests.XPClassTests',this.getClass().getName());};unittests.XPClassTests.prototype.className['@']= {test:null};







unittests.XPClassTests.prototype.classNameShortCut= function XPClassTests$classNameShortCut(){
this.assertEquals('unittests.XPClassTests',this.getClassName());};unittests.XPClassTests.prototype.classNameShortCut['@']= {test:null};







unittests.XPClassTests.prototype.forName= function XPClassTests$forName(){
this.assertEquals(this.getClass(),lang.XPClass.forName('unittests.XPClassTests'));};unittests.XPClassTests.prototype.forName['@']= {test:null};







unittests.XPClassTests.prototype.forNameNonExistant= function XPClassTests$forNameNonExistant(){
lang.XPClass.forName('non-existant-class');};unittests.XPClassTests.prototype.forNameNonExistant['@']= {test:null,expect:'lang.ClassNotFoundException'};







unittests.XPClassTests.prototype.hasNameField= function XPClassTests$hasNameField(){
this.assertTrue(this.getClass().hasField('name'));};unittests.XPClassTests.prototype.hasNameField['@']= {test:null};







unittests.XPClassTests.prototype.nameField= function XPClassTests$nameField(){
field=this.getClass().getField('name');
this.assertInstanceOf('lang.reflect.Field',field);
this.assertEquals('name',field.getName());};unittests.XPClassTests.prototype.nameField['@']= {test:null};







unittests.XPClassTests.prototype.doesNotHaveNonExistantField= function XPClassTests$doesNotHaveNonExistantField(){
this.assertFalse(this.getClass().hasField('non-existant'));};unittests.XPClassTests.prototype.doesNotHaveNonExistantField['@']= {test:null};







unittests.XPClassTests.prototype.getNonExistantField= function XPClassTests$getNonExistantField(){
this.getClass().getField('non-existant');};unittests.XPClassTests.prototype.getNonExistantField['@']= {test:null,expect:'lang.ElementNotFoundException'};







unittests.XPClassTests.prototype.hasNameMethod= function XPClassTests$hasNameMethod(){
this.assertTrue(this.getClass().hasMethod('name'));};unittests.XPClassTests.prototype.hasNameMethod['@']= {test:null};







unittests.XPClassTests.prototype.nameMethod= function XPClassTests$nameMethod(){
Method=this.getClass().getMethod('name');
this.assertInstanceOf('lang.reflect.Method',Method);
this.assertEquals('name',Method.getName());};unittests.XPClassTests.prototype.nameMethod['@']= {test:null};







unittests.XPClassTests.prototype.doesNotHaveNonExistantMethod= function XPClassTests$doesNotHaveNonExistantMethod(){
this.assertFalse(this.getClass().hasMethod('non-existant'));};unittests.XPClassTests.prototype.doesNotHaveNonExistantMethod['@']= {test:null};







unittests.XPClassTests.prototype.getNonExistantMethod= function XPClassTests$getNonExistantMethod(){
this.getClass().getMethod('non-existant');};unittests.XPClassTests.prototype.getNonExistantMethod['@']= {test:null,expect:'lang.ElementNotFoundException'};







unittests.XPClassTests.prototype.thisIsInstanceofSelf= function XPClassTests$thisIsInstanceofSelf(){
this.assertTrue(this.getClass().isInstance(this));};unittests.XPClassTests.prototype.thisIsInstanceofSelf['@']= {test:null};







unittests.XPClassTests.prototype.thisIsInstanceofParentClass= function XPClassTests$thisIsInstanceofParentClass(){
this.assertTrue(lang.XPClass.forName('unittest.TestCase').isInstance(this));};unittests.XPClassTests.prototype.thisIsInstanceofParentClass['@']= {test:null};







unittests.XPClassTests.prototype.thisIsInstanceofObjectClass= function XPClassTests$thisIsInstanceofObjectClass(){
this.assertTrue(lang.XPClass.forName('lang.Object').isInstance(this));};unittests.XPClassTests.prototype.thisIsInstanceofObjectClass['@']= {test:null};







unittests.XPClassTests.prototype.thisIsNotAnInstanceOfThrowable= function XPClassTests$thisIsNotAnInstanceOfThrowable(){
this.assertFalse(lang.XPClass.forName('lang.Throwable').isInstance(this));};unittests.XPClassTests.prototype.thisIsNotAnInstanceOfThrowable['@']= {test:null};







unittests.XPClassTests.prototype.nullIsNotAnInstanceOfObject= function XPClassTests$nullIsNotAnInstanceOfObject(){
this.assertFalse(lang.XPClass.forName('lang.Object').isInstance(null));};unittests.XPClassTests.prototype.nullIsNotAnInstanceOfObject['@']= {test:null};







unittests.XPClassTests.prototype.annotatedClassHasAnnotations= function XPClassTests$annotatedClassHasAnnotations(){
this.assertTrue(lang.XPClass.forName('unittests.AnnotatedClass').hasAnnotations());};unittests.XPClassTests.prototype.annotatedClassHasAnnotations['@']= {test:null};







unittests.XPClassTests.prototype.annotatedClassHasWebserviceAnnotation= function XPClassTests$annotatedClassHasWebserviceAnnotation(){
this.assertTrue(lang.XPClass.forName('unittests.AnnotatedClass').hasAnnotation('webservice'));};unittests.XPClassTests.prototype.annotatedClassHasWebserviceAnnotation['@']= {test:null};







unittests.XPClassTests.prototype.annotatedClassDoesNotHaveTestAnnotation= function XPClassTests$annotatedClassDoesNotHaveTestAnnotation(){
this.assertFalse(lang.XPClass.forName('unittests.AnnotatedClass').hasAnnotation('test'));};unittests.XPClassTests.prototype.annotatedClassDoesNotHaveTestAnnotation['@']= {test:null};







unittests.XPClassTests.prototype.annotatedClassAnnotations= function XPClassTests$annotatedClassAnnotations(){
this.assertEquals({'webservice' : null},lang.XPClass.forName('unittests.AnnotatedClass').getAnnotations());};unittests.XPClassTests.prototype.annotatedClassAnnotations['@']= {test:null};







unittests.XPClassTests.prototype.annotatedClassChildAnnotations= function XPClassTests$annotatedClassChildAnnotations(){
this.assertEquals({'webservice' : null},lang.XPClass.forName('unittests.AnnotatedClassChild').getAnnotations());};unittests.XPClassTests.prototype.annotatedClassChildAnnotations['@']= {test:null};







unittests.XPClassTests.prototype.annotatedClassWebserviceAnnotations= function XPClassTests$annotatedClassWebserviceAnnotations(){
this.assertNull(lang.XPClass.forName('unittests.AnnotatedClass').getAnnotation('webservice'));};unittests.XPClassTests.prototype.annotatedClassWebserviceAnnotations['@']= {test:null};







unittests.XPClassTests.prototype.thisClassHasNoAnnotations= function XPClassTests$thisClassHasNoAnnotations(){
this.assertFalse(this.getClass().hasAnnotations());};unittests.XPClassTests.prototype.thisClassHasNoAnnotations['@']= {test:null};







unittests.XPClassTests.prototype.thisClassAnnotations= function XPClassTests$thisClassAnnotations(){
this.assertEquals([],this.getClass().getAnnotations());};unittests.XPClassTests.prototype.thisClassAnnotations['@']= {test:null};







unittests.XPClassTests.prototype.thisClassWebserviceAnnotation= function XPClassTests$thisClassWebserviceAnnotation(){
this.getClass().getAnnotation('webservice');};unittests.XPClassTests.prototype.thisClassWebserviceAnnotation['@']= {test:null,expect:'lang.ElementNotFoundException'};







unittests.XPClassTests.prototype.thisClassParent= function XPClassTests$thisClassParent(){
this.assertEquals(lang.XPClass.forName('unittest.TestCase'),this.getClass().getParentclass());};unittests.XPClassTests.prototype.thisClassParent['@']= {test:null};