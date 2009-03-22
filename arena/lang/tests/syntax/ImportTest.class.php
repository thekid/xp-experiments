<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.syntax.xp.Lexer',
    'xp.compiler.syntax.xp.Parser'
  );

  /**
   * TestCase
   *
   */
  class ImportTest extends TestCase {
  
    /**
     * Parse method source and return statements inside this method.
     *
     * @param   string src
     * @return  xp.compiler.Node
     */
    protected function parse($src) {
      return create(new xp·compiler·syntax·xp·Parser())->parse(new xp·compiler·syntax·xp·Lexer($src, '<string:'.$this->name.'>'))->imports;
    }

    /**
     * Test single-type import
     *
     */
    #[@test]
    public function singleTypeImport() {
      $this->assertEquals(array(new ImportNode(array(
          'position' => array(1, 1),
          'name'     => 'util.collections.HashTable'
        ))), 
        $this->parse('import util.collections.HashTable; public class Test { }')
      );
    }

    /**
     * Test type-import-on-demand
     *
     */
    #[@test]
    public function typeImportOnDemand() {
      $this->assertEquals(array(new ImportNode(array(
          'position' => array(1, 1),
          'name'     => 'util.collections.*'
        ))), 
        $this->parse('import util.collections.*; public class Test { }')
      );
    }

    /**
     * Test static import
     *
     */
    #[@test]
    public function staticImport() {
      $this->assertEquals(array(new StaticImportNode(array(
          'position' => array(1, 1),
          'name'     => 'rdbms.criterion.Restrictions.*'
        ))), 
        $this->parse('import static rdbms.criterion.Restrictions.*; public class Test { }')
      );
    }

    /**
     * Test native import
     *
     */
    #[@test]
    public function nativeImport() {
      $this->assertEquals(array(new NativeImportNode(array(
          'position' => array(1, 1),
          'name'     => 'standard.*'
        ))), 
        $this->parse('import native standard.*; public class Test { }')
      );
    }

    /**
     * Test multiple imports
     *
     */
    #[@test]
    public function multipleImports() {
      $this->assertEquals(array(new ImportNode(array(
          'position' => array(2, 12),
          'name'     => 'util.collections.*'
        )), new ImportNode(array(
          'position' => array(3, 13),   // XXX Why is this 13 vs. 12 for the first?
          'name'     => 'util.Date'
        )), new ImportNode(array(
          'position' => array(4, 13),   // XXX -"-
          'name'     => 'unittest.*'
        ))), 
        $this->parse('
          import util.collections.*; 
          import util.Date; 
          import unittest.*; 

          public class Test { }
        ')
      );
    }

    /**
     * Test "import *" is not valid
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function noImportAll() {
      $this->parse('import *; public class Test { }');
    }

    /**
     * Test "import test" is not valid
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function noImportNothing() {
      $this->parse('import test; public class Test { }');
    }
  }
?>
