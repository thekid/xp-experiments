<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.ide.unittest.TestCase',
    'xp.ide.source.parser.ClassParser',
    'xp.ide.source.parser.ClassLexer',
    'xp.ide.source.Scope',
    'xp.ide.source.element.Classmember',
    'xp.ide.source.element.Classconstant',
    'io.streams.MemoryInputStream'
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
     * @return xp.ide.source.parser.Lexer
     */
    private function getLexer($exp) {
      return new xp·ide·source·parser·ClassLexer($exp);
    }

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->p= new xp·ide·source·parser·ClassParser();
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMember() {
      $tree= $this->p->parse($this->getLexer(new MemoryInputStream('
          private $member1= 1;
          public $member2= NULL;
          protected $member3= NULL, $member4;
          $member5;
       ')));
       $this->assertEquals(array(
         new xp·ide·source·element·Classmember('member1', xp·ide·source·Scope::$PRIVATE),
         new xp·ide·source·element·Classmember('member2', xp·ide·source·Scope::$PUBLIC),
         new xp·ide·source·element·Classmember('member3', xp·ide·source·Scope::$PROTECTED),
         new xp·ide·source·element·Classmember('member4', xp·ide·source·Scope::$PROTECTED),
         new xp·ide·source·element·Classmember('member5', xp·ide·source·Scope::$PUBLIC),
       ), $tree->getMembers());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testConst() {
      $tree= $this->p->parse($this->getLexer(new MemoryInputStream('
          const CONSTANT1= 1;
          const
            CONSTANT2= 2,
            CONSTANT3= 3;
       ')));
       $this->assertEquals(array(
         new xp·ide·source·element·Classconstant('CONSTANT1'),
         new xp·ide·source·element·Classconstant('CONSTANT2'),
         new xp·ide·source·element·Classconstant('CONSTANT3'),
       ), $tree->getConstants());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testConstMember() {
      $tree= $this->p->parse($this->getLexer(new MemoryInputStream('
          const CONST1= 1;
          protected $member3= NULL, $member4;
       ')));
       $this->assertEquals(array(
         new xp·ide·source·element·Classconstant('CONST1'),
       ), $tree->getConstants());
       $this->assertEquals(array(
         new xp·ide·source·element·Classmember('member3', xp·ide·source·Scope::$PROTECTED),
         new xp·ide·source·element·Classmember('member4', xp·ide·source·Scope::$PROTECTED),
       ), $tree->getMembers());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testStaticMember() {
      $tree= $this->p->parse($this->getLexer(new MemoryInputStream('
          protected $member1;
          protected static $member2;
          static protected $member3;
       ')));
       $this->assertEquals(
         array(FALSE, TRUE, TRUE),
         array_map(create_function('$e', 'return $e->isStatic();'), $tree->getMembers())
       );
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMemberTypes() {
      $tree= $this->p->parse($this->getLexer(new MemoryInputStream('
          $member1= 1;
          $member2= FALSE;
          $member3= TRUE;
          $member5= NULL;
          $member6= "";
       ')));
       $this->assertEquals(
         array("1", "FALSE", "TRUE", "NULL", '""'),
         array_map(create_function('$e', 'return $e->getInit();'), $tree->getMembers())
       );
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMemberStrings() {
      $tree= $this->p->parse($this->getLexer(new MemoryInputStream('
        $member1= "sdfggsd\"jh";
        $member1= \'sdfggsd\\\'jh\';
        $member2= "";
        $member3= \'\';
      ')));
      $this->assertEquals(
        array('"sdfggsd\"jh"', "'sdfggsd\\'jh'", '""', "''"),
        array_map(create_function('$e', 'return $e->getInit();'), $tree->getMembers())
      );
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMemberArray() {
      $tree= $this->p->parse($this->getLexer(new MemoryInputStream('
          $member1= array();
       ')));
       $this->assertClass(
         $tree->getMember(0)->getInit(),
         "xp.ide.source.element.Array"
       );
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMemberArrayAssoc() {
      $tree= $this->p->parse($this->getLexer(new MemoryInputStream('
        $member1= array(4 => TRUE);
      ')));
      $this->assertEquals(
        array("4" => "TRUE"),
        $tree->getMember(0)->getInit()->getValues()
      );
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMemberArrayValues() {
      $tree= $this->p->parse($this->getLexer(new MemoryInputStream('
        $member4= array(NULL, TRUE, 1);
      ')));
      $this->assertEquals(
        array("NULL", "TRUE", "1"),
        $tree->getMember(0)->getInit()->getValues()
      );
    }
  }
?>
