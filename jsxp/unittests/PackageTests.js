uses('unittest.TestCase');






;
;





unittests.PackageTests= define('unittests.PackageTests','unittest.TestCase',function PackageTests(){unittest.TestCase.apply(this, arguments);});






unittests.PackageTests.prototype.packageName= function PackageTests$packageName(){
this.assertEquals('unittests',this.getClass().getPackage().getName());};unittests.PackageTests.prototype.packageName['@']= {test:null};







unittests.PackageTests.prototype.stringRepresentation= function PackageTests$stringRepresentation(){
this.assertEquals('lang.reflect.Package<unittests>',this.getClass().getPackage().toString());};unittests.PackageTests.prototype.stringRepresentation['@']= {test:null};