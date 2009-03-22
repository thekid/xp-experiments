<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('tests.syntax.xp.ParserTestCase');

  /**
   * TestCase
   *
   */
  class ExceptionExpressionTest extends ParserTestCase {
  
    /**
     * Test try/catch
     *
     */
    #[@test]
    public function singleCatch() {
      $this->assertEquals(array(new TryNode(array(
        'position'   => array(4, 15),
        'statements' => array(
          $this->create(new VariableNode(
            '$method', 
            new InvocationNode(array(
              'position'   => array(5, 25),
              'name'       => 'call',
              'parameters' => NULL
            ))
          ), array(5, 13))
        ), 
        'handling'   => array(
          new CatchNode(array(
            'position'   => array(6, 13),
            'type'       => new TypeName('IllegalArgumentException'),
            'variable'   => '$e',
            'statements' => array($this->create(new VariableNode(
              '$this',
              new InvocationNode(array(
                'position'   => array(7, 27),
                'name'       => 'finalize',
                'parameters' => NULL
              ))
            ), array(7, 13))), 
          ))
        )
      ))), $this->parse('
        try {
          $method.call();
        } catch (IllegalArgumentException $e) {
          $this.finalize();
        }
      '));
    }

    /**
     * Test try/finally
     *
     */
    #[@test]
    public function singleThrow() {
      $this->assertEquals(array(new ThrowNode(array(
        'position'   => array(4, 11),
        'expression' => new InstanceCreationNode(array(
          'position'   => array(4, 17),
          'type'       => new TypeName('IllegalStateException'),
          'parameters' => NULL
        ))
      ))), $this->parse('
        throw new IllegalStateException();
      '));
    }

    /**
     * Test try/finally
     *
     */
    #[@test]
    public function singleFinally() {
      $this->assertEquals(array(new TryNode(array(
        'position'   => array(4, 15),
        'statements' => array(
          new ThrowNode(array(
            'position'   => array(5, 13),
            'expression' => new InstanceCreationNode(array(
              'position'   => array(5, 19),
              'type'       => new TypeName('ChainedException'),
              'parameters' => array(
                $this->create(new StringNode(array('value' => 'Hello')), array(5, 40)),
                $this->create(new VariableNode('$e'), array(5, 47)),
              )
            ))
          ))
        ), 
        'handling'   => array(
          new FinallyNode(array(
            'position'   => array(6, 13),
            'statements' => array($this->create(new VariableNode(
              '$this',
              new InvocationNode(array(
                'position'   => array(7, 27),
                'name'       => 'finalize',
                'parameters' => NULL
              ))
            ), array(7, 13))), 
          ))
        )
      ))), $this->parse('
        try {
          throw new ChainedException("Hello", $e);
        } finally {
          $this.finalize();
        }
      '));
    }

    /**
     * Test try w/ multiple catches
     *
     */
    #[@test]
    public function multipleCatches() {
      $this->assertEquals(array(new TryNode(array(
        'position'   => array(4, 15),
        'statements' => array(
          new ReturnNode(array(
            'position'   => array(5, 13),
            'expression' => new InstanceCreationNode(array(
              'position'   => array(5, 20),
              'type'       => new TypeName('util.collections.HashTable', array(
                new TypeName('lang.types.String'), 
                new TypeName('Object')
              )),
              'parameters' => NULL
            ))
          ))
        ), 
        'handling'   => array(
          new CatchNode(array(
            'position'   => array(6, 13),
            'type'       => new TypeName('IllegalArgumentException'),
            'variable'   => '$e',
            'statements' => NULL, 
          )),
          new CatchNode(array(
            'position'   => array(7, 13),
            'type'       => new TypeName('SecurityException'),
            'variable'   => '$e',
            'statements' => array(new ThrowNode(array(
              'position'   => array(8, 13),
              'expression' => $this->create(new VariableNode(
                '$e',
                new InvocationNode(array(
                  'position'   => array(8, 31),
                  'name'       => 'getCauses',
                  'parameters' => NULL,
                  'chained'    => new ArrayAccessNode(array(
                    'position'   => array(8, 33),
                    'offset'     => new NumberNode(array('position' => array(8, 34), 'value' => '0')),
                  ))
                ))
              ), array(8, 19))
            ))), 
          )),
          new CatchNode(array(
            'position'   => array(9, 13),
            'type'       => new TypeName('Exception'),
            'variable'   => '$e',
            'statements' => NULL, 
          ))
        )
      ))), $this->parse('
        try {
          return new util.collections.HashTable<lang.types.String, Object>();
        } catch (IllegalArgumentException $e) {
        } catch (SecurityException $e) {
          throw $e.getCauses()[0];
        } catch (Exception $e) {
        }
      '));
    }
  }
?>
