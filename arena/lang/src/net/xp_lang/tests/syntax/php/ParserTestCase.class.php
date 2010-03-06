<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'net.xp_lang.tests.syntax.php';

  uses(
    'unittest.TestCase',
    'xp.compiler.syntax.php.Lexer',
    'xp.compiler.syntax.php.Parser',
    'xp.compiler.ast.Node'
  );

  /**
   * Base class for all other parser test cases.
   *
   */
  abstract class net暖p_lang暗ests新yntax搆hp感arserTestCase extends TestCase {
  
    /**
     * Parse method source and return statements inside this method.
     *
     * @param   string src
     * @return  xp.compiler.Node[]
     */
    protected function parse($src) {
      try {
        return create(new xp搾ompiler新yntax搆hp感arser())->parse(new xp搾ompiler新yntax搆hp微exer('<?php class Container {
          public function method() {
            '.$src.'
          }
        } ?>', '<string:'.$this->name.'>'))->declaration->body[0]->body;
      } catch (ParseException $e) {
        throw $e->getCause();
      }
    }
  }
?>
