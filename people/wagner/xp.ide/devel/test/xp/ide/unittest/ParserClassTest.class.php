<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.ide.unittest.TestCase',
    'xp.ide.source.parser.Php52Parser',
    'xp.ide.source.parser.ClassFileLexer',
    'xp.ide.source.Scope',
    'xp.ide.source.element.Classmember',
    'xp.ide.source.element.Classconstant'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class ParserClassTest extends xp·ide·unittest·TestCase {

    /**
     * lexer to do tests with
     *
     * @param string exp
     * @return text.parser.generic.AbstractLexer
     */
    private function getLexer($exp) {
      return new xp·ide·source·parser·ClassFileLexer($exp);
    }

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->p= new xp·ide·source·parser·Php52Parser();
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test, @ignore]
    public function testParseMember() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           * Test class definition
           * 
           */
          class Test extends Object {
            private $member1= 1;
            public $member2= NULL;
            protected $member3= NULL, $member4;
            $member5;
          }
         ?>
       '));
       $this->assertEquals(array(
         new xp·ide·source·element·Classmember('member1', xp·ide·source·Scope::$PRIVATE),
         new xp·ide·source·element·Classmember('member2', xp·ide·source·Scope::$PUBLIC),
         new xp·ide·source·element·Classmember('member3', xp·ide·source·Scope::$PROTECTED),
         new xp·ide·source·element·Classmember('member4', xp·ide·source·Scope::$PROTECTED),
         new xp·ide·source·element·Classmember('member5', xp·ide·source·Scope::$PUBLIC),
       ), $tree->getClassDef()->getMembers());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test, @ignore]
    public function testParseConst() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           * Test class definition
           * 
           */
          class Test extends Object {
            const CONST1= 1;
            const
              CONST2= 2,
              CONST3= 3;
          }
         ?>
       '));
       $this->assertEquals(array(
         new xp·ide·source·element·Classconstant('CONST1'),
         new xp·ide·source·element·Classconstant('CONST2'),
         new xp·ide·source·element·Classconstant('CONST3'),
       ), $tree->getClassDef()->getConstants());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test, @ignore]
    public function testParseConstMember() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           * Test class definition
           * 
           */
          class Test extends Object {
            const CONST1= 1;
            protected $member3= NULL, $member4;
          }
         ?>
       '));
       $this->assertEquals(array(
         new xp·ide·source·element·Classconstant('CONST1'),
       ), $tree->getClassDef()->getConstants());
       $this->assertEquals(array(
         new xp·ide·source·element·Classmember('member3', xp·ide·source·Scope::$PROTECTED),
         new xp·ide·source·element·Classmember('member4', xp·ide·source·Scope::$PROTECTED),
       ), $tree->getClassDef()->getMembers());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test, @ignore]
    public function testParseStaticMember() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           * Test class definition
           * 
           */
          class Test extends Object {
            protected $member1;
            protected static $member2;
            static protected $member2;
          }
         ?>
       '));
       $this->assertEquals(
         array(FALSE, TRUE, TRUE),
         array_map(create_function('$e', 'return $e->isStatic();'), $tree->getClassDef()->getMembers())
       );
    }
  }
?>
