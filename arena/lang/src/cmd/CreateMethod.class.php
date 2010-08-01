<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'xp.compiler.ast.MethodNode',
    'xp.compiler.ast.StaticMethodCallNode',
    'xp.compiler.ast.StringNode',
    'xp.compiler.emit.source.Emitter',
    'xp.compiler.ast.ParseTree',
    'xp.compiler.types.TypeDeclarationScope'
  );

  /**
   * Demonstrates dynamically creating a method
   *
   */
  class CreateMethod extends Command {
  
    /**
     * Generate type
     *
     * @param   xp.compiler.ast.TypeMemberNode[] members
     * @return  lang.XPClass
     */
    protected function generateType(array $members) {
      $emitter= new xp·compiler·emit·source·Emitter();
      $r= $emitter->emit(new ParseTree(
        NULL, 
        array(), 
        new ClassNode(0, array(), new TypeName('Generated'), NULL, NULL, $members)
      ), new TypeDeclarationScope());
      $r->executeWith(array());

      return XPClass::forName($r->type()->name());
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      $method= new MethodNode();
      $method->name= 'sayHello';
      $method->returns= TypeName::$VOID;
      $method->addStatement(new StaticMethodCallNode(
        new TypeName('util.cmd.Console'), 
        'writeLine', 
        array(new StringNode('Hello'))
      ));
      
      $this->generateType(array($method))->newInstance()->sayHello();
    }
  }
?>
