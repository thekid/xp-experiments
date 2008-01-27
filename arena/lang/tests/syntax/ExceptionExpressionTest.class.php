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
  class ExceptionExpressionTest extends TestCase {
  
    /**
     * Parse method source and return statements inside this method.
     *
     * @param   string src
     * @return  xp.compiler.Node[]
     */
    protected function parse($src) {
      return create(new Parser())->parse(new xp·compiler·Lexer('class Container {
        public void method() {
          '.$src.'
        }
      }', '<string:'.$this->name.'>'))->declaration->body['methods'][0]->body;
    }

    /**
     * Test try/catch
     *
     */
    #[@test]
    public function singleCatch() {
      $this->assertEquals(array(new TryNode(array(
        'position'   => array(4, 15),
        'statements' => NULL, 
        'handling'   => array(
          new CatchNode(array(
            'position'   => array(6, 13),
            'type'       => new TypeName('IllegalArgumentException'),
            'variable'   => '$e',
            'statements' => array(new VariableNode(array(
              'position'   => array(7, 13),
              'name'       => '$this',
              'chained'    => new InvocationNode(array(
                'position'   => array(7, 28),
                'name'       => 'finalize',
                'parameters' => NULL
              ))
            ))), 
          ))
        )
      ))), $this->parse('
        try {
          $method->call();
        } catch (IllegalArgumentException $e) {
          $this->finalize();
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
        'statements' => NULL, 
        'handling'   => array(
          new FinallyNode(array(
            'position'   => array(6, 13),
            'statements' => array(new VariableNode(array(
              'position'   => array(7, 13),
              'name'       => '$this',
              'chained'    => new InvocationNode(array(
                'position'   => array(7, 28),
                'name'       => 'finalize',
                'parameters' => NULL
              ))
            ))), 
          ))
        )
      ))), $this->parse('
        try {
          throw new ChainedException("Hello", new IOException($message));
        } finally {
          $this->finalize();
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
        'statements' => NULL, 
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
              'expression' => new VariableNode(array(
                'position'   => array(8, 19),
                'name'       => '$e',
                'chained'    => new InvocationNode(array(
                  'position'   => array(8, 32),
                  'name'       => 'getCauses',
                  'parameters' => NULL,
                  'chained'    => new ArrayAccessNode(array(
                    'position'   => array(8, 34),
                    'offset'     => new NumberNode(array('position' => array(8, 35), 'value' => '0')),
                  ))
                ))
              ))
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
          throw $e->getCauses()[0];
        } catch (Exception $e) {
        }
      '));
    }
  }
?>
