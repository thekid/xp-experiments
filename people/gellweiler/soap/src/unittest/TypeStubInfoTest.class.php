<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'webservices.soap.xp.TypeStubInfo'
  );

  /**
   * TestCase
   *
   * @see      xp://webservices.soap.xp.TypeStubInfo
   * @purpose  purpose
   */
  class TypeStubInfoTest extends TestCase {

    /**
     * Helper method to overwrite cached
     * annotation information
     *
     * @param   string classname
     * @param   mixed[] annotations
     * @return  lang.XPClass
     */
    protected function getClassWithAnnotations($classname, $annotations) {
      $class= XPClass::forName($classname);
      $class->hasAnnotations();
      xp::$registry['details.'.$classname]['class'][DETAIL_ANNOTATIONS]= $annotations;
      
      return $class;
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.ElementNotFoundException')]
    public function clientWithoutNamespace() {
      $class= $this->getClassWithAnnotations('unittest.dummy.DummyService', array(
        'binding' => array('name' => 'irrelevant')
      ));

      $info= new TypeStubInfo($class);
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.ElementNotFoundException')]
    public function clientWithBrokenAnnotation() {
      $class= $this->getClassWithAnnotations('unittest.dummy.DummyService', array('binding' => array()));
      $info= new TypeStubInfo($class);
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.ElementNotFoundException')]
    public function clientWithMissingAnnotation() {
      $class= $this->getClassWithAnnotations('unittest.dummy.DummyService', array());
      $info= new TypeStubInfo($class);
    }

  }
?>
