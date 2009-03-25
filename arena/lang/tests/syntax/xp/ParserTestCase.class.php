<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.syntax.xp.Lexer',
    'xp.compiler.syntax.xp.Parser',
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
      try {
        return create(new xp搾ompiler新yntax暖p感arser())->parse(new xp搾ompiler新yntax暖p微exer('class Container {
          public void method() {
            '.$src.'
          }
        }', '<string:'.$this->name.'>'))->declaration->body['methods'][0]->body;
      } catch (ParseException $e) {
        throw $e->getCause();
      }
    }

    /**
     * Create a node at a given position
     *
     * @param   xp.compiler.ast.Node n
     * @param   int[2] pos
     * @return  xp.compiler.ast.Node
     */
    protected function create(xp搾ompiler戢st意ode $n, $pos) {
      $n->position= $pos;
      return $n;
    }
  }
?>
