<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'tests.syntax.php';

  uses('net.xp_lang.tests.syntax.php.ParserTestCase');

  /**
   * TestCase
   *
   */
  class tests新yntax搆hp嵩lassDeclarationTest extends net暖p_lang暗ests新yntax搆hp感arserTestCase {

    /**
     * Parse class source and return statements inside field declaration
     *
     * @param   string src
     * @return  xp.compiler.Node[]
     */
    protected function parse($src) {
      return create(new xp搾ompiler新yntax搆hp感arser())->parse(new xp搾ompiler新yntax搆hp微exer($src, '<string:'.$this->name.'>'))->declaration;
    }
  
    /**
     * Test class declaration
     *
     */
    #[@test]
    public function emtpyClass() {
      $this->assertEquals(
        new ClassNode(
          0,                          // Modifiers
          NULL,                       // Annotations
          new TypeName('Empty'),      // Name
          NULL,                       // Parent
          array(),                    // Implements
          NULL                        // Body
        ), 
        $this->parse('<?php class Empty { } ?>')
      );
    }

    /**
     * Test field declaration
     *
     */
    #[@test]
    public function methodAndField() {
      $this->assertEquals(array(new FieldNode(array(
        'modifiers'       => MODIFIER_PRIVATE | MODIFIER_STATIC,
        'annotations'     => NULL,
        'name'            => 'instance',
        'type'            => new TypeName('var'),
        'initialization'  => new NullNode()
      )), new MethodNode(array(
        'modifiers'   => MODIFIER_PUBLIC | MODIFIER_STATIC,
        'annotations' => NULL,
        'name'        => 'getInstance',
        'returns'     => new TypeName('var'),
        'parameters'  => NULL, 
        'throws'      => NULL,
        'body'        => array(),
        'extension'   => NULL
      ))), $this->parse('<?php class Logger { 
        private static $instance= null;
        public static function getInstance() { /* ... */ }
      } ?>')->body);
    }
  }
?>
