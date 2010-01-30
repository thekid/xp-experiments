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
  class EnumDeclarationTest extends TestCase {
  
    /**
     * Parse enum source and return body.
     *
     * @param   string src
     * @return  xp.compiler.Node
     */
    protected function parse($src) {
      return create(new xp·compiler·syntax·xp·Parser())->parse(new xp·compiler·syntax·xp·Lexer($src, '<string:'.$this->name.'>'))->declaration;
    }

    /**
     * Test enum declaration
     *
     */
    #[@test]
    public function daysEnum() {
      $this->assertEquals(array(
        new EnumMemberNode(array('name' => 'monday', 'body' => NULL)),
        new EnumMemberNode(array('name' => 'tuesday', 'body' => NULL)),
        new EnumMemberNode(array('name' => 'wednedsday', 'body' => NULL)),
        new EnumMemberNode(array('name' => 'thursday', 'body' => NULL)),
        new EnumMemberNode(array('name' => 'friday', 'body' => NULL)),
        new EnumMemberNode(array('name' => 'saturday', 'body' => NULL)),
        new EnumMemberNode(array('name' => 'sunday', 'body' => NULL)),
      ), $this->parse('enum Days { monday, tuesday, wednedsday, thursday, friday, saturday, sunday }')->body);
    }

    /**
     * Test enum declaration
     *
     */
    #[@test]
    public function coinEnum() {
      $this->assertEquals(new EnumNode(array(
        'modifiers'   => 0,
        'annotations' => NULL,
        'name'        => new TypeName('Coin'),
        'parent'      => NULL,
        'implements'  => array(),
        'body'        => array(
          new EnumMemberNode(array(
            'name'      => 'penny', 
            'value'     => new IntegerNode(array('value' => '1')),
            'body'      => NULL
          )),
          new EnumMemberNode(array(
            'name'      => 'nickel', 
            'value'     => new IntegerNode(array('value' => '2')),
            'body'      => NULL
          )),
          new EnumMemberNode(array(
            'name'      => 'dime', 
            'value'     => new IntegerNode(array('value' => '10')),
            'body'      => NULL
          )),
          new EnumMemberNode(array(
            'name'      => 'quarter', 
            'value'     => new IntegerNode(array('value' => '25')),
            'body'      => NULL
          )),
          new MethodNode(array(
            'modifiers'    => MODIFIER_PUBLIC,
            'annotations'  => NULL,
            'returns'      => new TypeName('string'),
            'name'         => 'color',
            'arguments'    => NULL,
            'throws'       => NULL,
            'body'         => array(),
            'extension'    => NULL
          ))
        )
      )), $this->parse('enum Coin { 
        penny(1), nickel(2), dime(10), quarter(25);
        
        public string color() {
          // TBI
        }
      }'));
    }
  }
?>
