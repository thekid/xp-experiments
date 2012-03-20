uses('unittest.TestCase');






;





tests.ObjectTests= define('tests.ObjectTests','unittest.TestCase',function ObjectTests(){unittest.TestCase.apply(this, arguments);});






tests.ObjectTests.prototype.className= function className(){
this.assertEquals('lang.Object',new lang.Object().getClass().getName());};tests.ObjectTests.prototype.className['@']= {test:null};







tests.ObjectTests.prototype.classNameShortCut= function classNameShortCut(){
this.assertEquals('lang.Object',new lang.Object().getClassName());};tests.ObjectTests.prototype.classNameShortCut['@']= {test:null};







tests.ObjectTests.prototype.equalToItSelf= function equalToItSelf(){
o=new lang.Object();
this.assertEquals(o,o);};tests.ObjectTests.prototype.equalToItSelf['@']= {test:null};







tests.ObjectTests.prototype.notEqualToAnotherInstance= function notEqualToAnotherInstance(){
this.assertNotEquals(new lang.Object(),new lang.Object());};tests.ObjectTests.prototype.notEqualToAnotherInstance['@']= {test:null};