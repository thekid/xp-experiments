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
        'position'   => array(4, 13),
        'statements' => array(
          $this->create(new VariableNode(
            '$method', 
            new InvocationNode(array(
              'position'   => array(5, 23),
              'name'       => 'call',
              'parameters' => NULL
            ))
          ), array(5, 11))
        ), 
        'handling'   => array(
          new CatchNode(array(
            'position'   => array(6, 11),
            'type'       => new TypeName('IllegalArgumentException'),
            'variable'   => '$e',
            'statements' => array($this->create(new VariableNode(
              '$this',
              new InvocationNode(array(
                'position'   => array(7, 25),
                'name'       => 'finalize',
                'parameters' => NULL
              ))
            ), array(7, 11))), 
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
        'position'   => array(4, 9),
        'expression' => new InstanceCreationNode(array(
          'position'   => array(4, 15),
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
        'position'   => array(4, 13),
        'statements' => array(
          new ThrowNode(array(
            'position'   => array(5, 11),
            'expression' => new InstanceCreationNode(array(
              'position'   => array(5, 17),
              'type'       => new TypeName('ChainedException'),
              'parameters' => array(
                $this->create(new StringNode(array('value' => 'Hello')), array(5, 38)),
                $this->create(new VariableNode('$e'), array(5, 47)),
              )
            ))
          ))
        ), 
        'handling'   => array(
          new FinallyNode(array(
            'position'   => array(6, 11),
            'statements' => array($this->create(new VariableNode(
              '$this',
              new InvocationNode(array(
                'position'   => array(7, 25),
                'name'       => 'finalize',
                'parameters' => NULL
              ))
            ), array(7, 11))), 
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
        'position'   => array(4, 13),
        'statements' => array(
          new ReturnNode(array(
            'position'   => array(5, 11),
            'expression' => new InstanceCreationNode(array(
              'position'   => array(5, 18),
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
            'position'   => array(6, 11),
            'type'       => new TypeName('IllegalArgumentException'),
            'variable'   => '$e',
            'statements' => NULL, 
          )),
          new CatchNode(array(
            'position'   => array(7, 11),
            'type'       => new TypeName('SecurityException'),
            'variable'   => '$e',
            'statements' => array(new ThrowNode(array(
              'position'   => array(8, 11),
              'expression' => $this->create(new VariableNode(
                '$e',
                new InvocationNode(array(
                  'position'   => array(8, 29),
                  'name'       => 'getCauses',
                  'parameters' => NULL,
                  'chained'    => new ArrayAccessNode(array(
                    'position'   => array(8, 31),
                    'offset'     => new NumberNode(array('position' => array(8, 32), 'value' => '0')),
                  ))
                ))
              ), array(8, 17))
            ))), 
          )),
          new CatchNode(array(
            'position'   => array(9, 11),
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
