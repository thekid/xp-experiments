<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.Lexer',
    'xp.compiler.Parser',
    'xp.compiler.ast.Node'
  );

  /**
   * Base class for all other parser test cases.
   *
   */
  abstract class ParserTestCase extends TestCase {
  
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
     * Create a node at a given position
     *
     * @param   xp.compiler.ast.Node n
     * @param   int[2] pos
     * @return  xp.compiler.ast.Node
     */
    protected function create(xp·compiler·ast·Node $n, $pos) {
      $n->position= $pos;
      return $n;
    }
  }
?>
