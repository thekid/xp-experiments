<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.Lexer',
    'xp.compiler.Parser'
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
      return create(new Parser())->parse(new xp·compiler·Lexer($src, '<string:'.$this->name.'>'))->declaration;
    }

    /**
     * Test enum declaration
     *
     */
    #[@test]
    public function daysEnum() {
      $this->assertEquals(array(
        new EnumMemberNode(array('position' => array(1, 19), 'name' => 'monday', 'body' => NULL)),
        new EnumMemberNode(array('position' => array(1, 28), 'name' => 'tuesday', 'body' => NULL)),
        new EnumMemberNode(array('position' => array(1, 40), 'name' => 'wednedsday', 'body' => NULL)),
        new EnumMemberNode(array('position' => array(1, 50), 'name' => 'thursday', 'body' => NULL)),
        new EnumMemberNode(array('position' => array(1, 58), 'name' => 'friday', 'body' => NULL)),
        new EnumMemberNode(array('position' => array(1, 68), 'name' => 'saturday', 'body' => NULL)),
        new EnumMemberNode(array('position' => array(1, 77), 'name' => 'sunday', 'body' => NULL)),
      ), $this->parse('enum Days { monday, tuesday, wednedsday, thursday, friday, saturday, sunday }')->body['members']);
    }

    /**
     * Test enum declaration
     *
     */
    #[@test]
    public function coinEnum() {
      $this->assertEquals(new EnumNode(array(
        'position'    => array(1, 1),
        'modifiers'   => 0,
        'annotations' => NULL,
        'name'        => new TypeName('Coin'),
        'parent'      => NULL,
        'implements'  => array(),
        'body'        => array(
          'members'   => array(
            new EnumMemberNode(array(
              'position'  => array(2, 16), 
              'name'      => 'penny', 
              'value'     => new NumberNode(array('position' => array(2, 17), 'value' => '1')),
              'body'      => NULL
            )),
            new EnumMemberNode(array(
              'position'  => array(2, 27), 
              'name'      => 'nickel', 
              'value'     => new NumberNode(array('position' => array(2, 28), 'value' => '2')),
              'body'      => NULL
            )),
            new EnumMemberNode(array(
              'position'  => array(2, 36), 
              'name'      => 'dime', 
              'value'     => new NumberNode(array('position' => array(2, 37), 'value' => '10')),
              'body'      => NULL
            )),
            new EnumMemberNode(array(
              'position'  => array(2, 49), 
              'name'      => 'quarter', 
              'value'     => new NumberNode(array('position' => array(2, 50), 'value' => '25')),
              'body'      => NULL
            )),
          ),
          'methods'   => array(
            new MethodNode(array(
              'position'     => array(4, 30), 
              'modifiers'    => MODIFIER_PUBLIC,
              'annotations'  => NULL,
              'returns'      => new TypeName('string'),
              'name'         => 'color',
              'arguments'    => NULL,
              'throws'       => NULL,
              'body'         => NULL,
            ))
          )
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
