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
        'statements' => array(new ChainNode(array(
          0 => new VariableNode('method'),
          1 => new InvocationNode('call'),
        ))), 
        'handling'   => array(
          new CatchNode(array(
            'type'       => new TypeName('IllegalArgumentException'),
            'variable'   => 'e',
            'statements' => array(new ChainNode(array(
              0 => new VariableNode('this'),
              1 => new InvocationNode('finalize'),
            ))), 
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
        'expression' => new InstanceCreationNode(array(
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
        'statements' => array(
          new ThrowNode(array(
            'expression' => new InstanceCreationNode(array(
              'type'       => new TypeName('ChainedException'),
              'parameters' => array(
                new StringNode('Hello'),
                new VariableNode('e'),
              )
            ))
          ))
        ), 
        'handling'   => array(
          new FinallyNode(array(
            'statements' => array(new ChainNode(array(
              0 => new VariableNode('this'),
              1 => new InvocationNode('finalize'),
            ))), 
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
        'statements' => array(
          new ReturnNode(array(
            'expression' => new InstanceCreationNode(array(
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
            'type'       => new TypeName('IllegalArgumentException'),
            'variable'   => 'e',
            'statements' => NULL, 
          )),
          new CatchNode(array(
            'type'       => new TypeName('SecurityException'),
            'variable'   => 'e',
            'statements' => array(new ThrowNode(array(
              'expression' => new VariableNode('e')
            ))), 
          )),
          new CatchNode(array(
            'type'       => new TypeName('Exception'),
            'variable'   => 'e',
            'statements' => NULL, 
          ))
        )
      ))), $this->parse('
        try {
          return new util.collections.HashTable<lang.types.String, Object>();
        } catch (IllegalArgumentException $e) {
        } catch (SecurityException $e) {
          throw $e;
        } catch (Exception $e) {
        }
      '));
    }

    /**
     * Test try w/ multi catch
     *
     */
    #[@test]
    public function multiCatch() {
      $this->assertEquals(array(new TryNode(array(
        'statements' => array(
          new ReturnNode(array(
            'expression' => new InstanceCreationNode(array(
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
            'type'       => new TypeName('IllegalArgumentException'),
            'variable'   => 'e',
            'statements' => array(new ThrowNode(array(
              'expression' => new VariableNode('e')
            ))), 
          )),
          new CatchNode(array(
            'type'       => new TypeName('SecurityException'),
            'variable'   => 'e',
            'statements' => array(new ThrowNode(array(
              'expression' => new VariableNode('e')
            ))), 
          ))
        )
      ))), $this->parse('
        try {
          return new util.collections.HashTable<lang.types.String, Object>();
        } catch (IllegalArgumentException | SecurityException $e) {
          throw $e;
        }
      '));
    }
  }
?>
