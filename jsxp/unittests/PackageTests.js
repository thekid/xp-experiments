uses('unittest.TestCase');






;
;





unittests.PackageTests= define('unittests.PackageTests','unittest.TestCase',function PackageTests(){unittest.TestCase.apply(this, arguments);});






unittests.PackageTests.prototype.packageName= function PackageTests$packageName(){
this.assertEquals('unittests',this.getClass().getPackage().getName());};unittests.PackageTests.prototype.packageName['@']= {test:null};







unittests.PackageTests.prototype.stringRepresentation= function PackageTests$stringRepresentation(){
this.assertEquals('lang.reflect.Package<unittests>',this.getClass().getPackage().toString());};unittests.PackageTests.prototype.stringRepresentation['@']= {test:null};







unittests.PackageTests.prototype.getClassNames= function PackageTests$getClassNames(){
this.assertEquals(
['unittests.classes.A','unittests.classes.B','unittests.classes.C'],
lang.reflect.Package.forName('unittests.classes').getClassNames());};unittests.PackageTests.prototype.getClassNames['@']= {test:null};








unittests.PackageTests.prototype.getClasses= function PackageTests$getClasses(){
this.assertEquals(
[lang.XPClass.forName('unittests.classes.A'),lang.XPClass.forName('unittests.classes.B'),lang.XPClass.forName('unittests.classes.C')],
lang.reflect.Package.forName('unittests.classes').getClasses());};unittests.PackageTests.prototype.getClasses['@']= {test:null};