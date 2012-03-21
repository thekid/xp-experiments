uses('unittest.TestCase');






;





unittests.ObjectTests= define('unittests.ObjectTests','unittest.TestCase',function ObjectTests(){unittest.TestCase.apply(this, arguments);});






unittests.ObjectTests.prototype.className= function ObjectTests$className(){
this.assertEquals('lang.Object',new lang.Object().getClass().getName());};unittests.ObjectTests.prototype.className['@']= {test:null};







unittests.ObjectTests.prototype.classNameShortCut= function ObjectTests$classNameShortCut(){
this.assertEquals('lang.Object',new lang.Object().getClassName());};unittests.ObjectTests.prototype.classNameShortCut['@']= {test:null};







unittests.ObjectTests.prototype.equalToItSelf= function ObjectTests$equalToItSelf(){
o=new lang.Object();
this.assertEquals(o,o);};unittests.ObjectTests.prototype.equalToItSelf['@']= {test:null};







unittests.ObjectTests.prototype.notEqualToAnotherInstance= function ObjectTests$notEqualToAnotherInstance(){
this.assertNotEquals(new lang.Object(),new lang.Object());};unittests.ObjectTests.prototype.notEqualToAnotherInstance['@']= {test:null};