<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'util.collections.HashTable', 
    'xp.compiler.types.TypeName',
    'xp.compiler.ast.ArrayNode',
    'xp.compiler.ast.MapNode',
    'xp.compiler.ast.StringNode',
    'xp.compiler.ast.IntegerNode',
    'xp.compiler.ast.HexNode',
    'xp.compiler.ast.DecimalNode',
    'xp.compiler.ast.NullNode',
    'xp.compiler.ast.BooleanNode',
    'xp.compiler.ast.ComparisonNode',
    'xp.compiler.emit.Method',
    'xp.compiler.emit.Types',
    'xp.compiler.emit.TypeReference', 
    'xp.compiler.emit.TypeReflection', 
    'xp.compiler.emit.TypeDeclaration', 
    'xp.compiler.io.FileManager'
  );

  /**
   * Represents the current scope
   *
   * @test    xp://tests.types.ScopeTest
   */
  class Scope extends Object {
    protected $types= NULL;
    protected $extensions= array();
    protected $resolved= array();
    
    public $enclosing= NULL;
    public $importer= NULL;
    public $manager= NULL;
    public $declarations= array();
    public $imports= array();
    public $used= array();
    public $package= NULL;
    public $statics= array();

    /**
     * Constructor
     *
     * @param   xp.compiler.io.FileManager
     */
    public function __construct(FileManager $manager= NULL) {
      $this->manager= $manager;
      $this->types= create('new util.collections.HashTable<xp.compiler.ast.Node, xp.compiler.types.TypeName>()');
      $this->resolved= create('new util.collections.HashTable<lang.types.String, xp.compiler.emit.Types>()');
    }
    
    /**
     * Enter a child scope
     *
     * @param   xp.compiler.types.Scope child
     * @return  xp.compiler.types.Scope child
     */
    public function enter(self $child) {
      $child->enclosing= $this;
      
      // Copy everything except types which are per-scope
      $child->resolved= $this->resolved;
      $child->extensions= $this->extensions;
      $child->importer= $this->importer;
      $child->manager= $this->manager;
      $child->declarations= $this->declarations;
      $child->imports= $this->imports;
      $child->used= $this->declarations;
      $child->package= $this->package;
      $child->statics= $this->statics;
      return $child;
    }

    /**
     * Add a type to resolved
     *
     * @param   string type
     * @param   xp.compiler.emit.Types resolved
     */
    public function addResolved($type, Types $resolved) {
      $this->resolved[$type]= $resolved;
    }
    
    /**
     * Add an extension method
     *
     * @param   xp.compiler.emit.Types type
     * @param   xp.compiler.emit.Method method
     */
    public function addExtension(Types $type, xp·compiler·emit·Method $method) {
      $this->extensions[$type->name().$method->name]= $method;
    }
    
    /**
     * Helper method for hasExtension() and getExtension()
     *
     * @param   xp.compiler.emit.Types type
     * @param   string name method name
     * @return  string
     */
    protected function lookupExtension(Types $type, $name) {
      do {
        $k= $type->name().$name;
        if (isset($this->extensions[$k])) return $k;
      } while ($type= $type->parent());
      return NULL;
    }
    
    /**
     * Return whether an extension method is available
     *
     * @param   xp.compiler.emit.Types type
     * @param   string name method name
     * @return  bool
     */
    public function hasExtension(Types $type, $name) {
      return NULL !== $this->lookupExtension($type, $name);
    }

    /**
     * Get an extension method
     *
     * @param   xp.compiler.emit.Types type
     * @param   string name method name
     * @return  xp.compiler.emit.Method
     */
    public function getExtension(Types $type, $name) {
      if ($k= $this->lookupExtension($type, $name)) {
        return $this->extensions[$k];
      } else {
        return NULL;
      }
    }

    /**
     * Resolve a static call. Return TRUE if the target is a function
     * (e.g. key()), a xp.compiler.emit.Method instance if it's a static 
     * method (Map::key()).
     *
     * @param   string name
     * @return  var
     */
    public function resolveStatic($name) {
      foreach ($this->statics as $lookup => $type) {
        if (TRUE === $type && $this->importer->hasFunction($lookup, $name)) {
          return TRUE;
        } else if ($type instanceof Types && $type->hasMethod($name)) {
          $m= $type->getMethod($name);
          if (Modifiers::isStatic($m->modifiers)) return $m;
        }
      }
      return NULL;
    }
    

    /**
     * Resolve a type name
     *
     * @param   string name
     * @param   var messages
     * @param   bool register
     * @return  xp.compiler.emit.Types resolved
     */
    public function resolve($name, Emitter $messages, $register= TRUE) {
      if (!is_string($name)) {
        throw new IllegalArgumentException('Cannot resolve '.xp::stringOf($name));
      }
      
      $cl= ClassLoader::getDefault();
      if ('self' === $name || $name === $this->declarations[0]->name->name) {
        switch ($decl= $this->declarations[0]) {
          case $decl instanceof ClassNode: 
            $parent= $this->resolve($decl->parent ? $decl->parent->name : 'lang.Object', $messages);
            break;
          case $decl instanceof EnumNode:
            $parent= $this->resolve($decl->parent ? $decl->parent->name : 'lang.Enum', $messages);
            break;
          case $decl instanceof InterfaceNode:
            $parent= NULL;
            break;
        }
        return new TypeDeclaration(new ParseTree($this->package, $this->imports, $decl), $parent);
      } else if ('parent' === $name || 'xp' === $name) {
        return new TypeReference($name, Types::UNKNOWN_KIND);
      } else if (strpos($name, '.')) {
        $qualified= $name;
      } else if (isset($this->imports[$name])) {
        $qualified= $this->imports[$name];
      } else if ($cl->providesClass('lang.'.$name)) {
        $qualified= 'lang.'.$name;
      } else {
        $qualified= ($this->package ? $this->package->name.'.' : '').$name;
      }
      
      // Locate class. If the classloader already knows this class,
      // we can simply use this class. TODO: Use specialized 
      // JitClassLoader?
      if (!$this->resolved->containsKey($qualified)) {
        if ($cl->providesClass($qualified)) {
          $this->resolved[$qualified]= new TypeReflection(XPClass::forName($qualified));
        } else {
          try {
            $tree= $this->manager->parseClass($qualified);
            $this->manager->write($this->emit($tree, $this->manager), $this->manager->getTarget($tree));
            
            switch ($decl= $tree->declaration) {
              case $decl instanceof ClassNode: 
                $t= new TypeDeclaration($tree, $this->resolve($decl->parent ? $decl->parent->name : 'lang.Object'));
                break;
              case $decl instanceof EnumNode:
                $t= new TypeDeclaration($tree, $this->resolve($decl->parent ? $decl->parent->name : 'lang.Enum'));
                break;
              case $decl instanceof InterfaceNode:
                $t= new TypeDeclaration($tree, NULL);
                break;
            }
          } catch (FormatException $e) {
            $messages->error('P424', $e->compoundMessage());
            $t= new TypeReference($qualified, Types::UNKNOWN_KIND);
          } catch (ParseException $e) {
            $messages->error('P400', $e->getCause()->compoundMessage());
            $t= new TypeReference($qualified, Types::UNKNOWN_KIND);
          } catch (ClassNotFoundException $e) {
            $messages->error('T404', $e->compoundMessage());
            $t= new TypeReference($qualified, Types::UNKNOWN_KIND);
          } catch (IOException $e) {
            $messages->error('0507', $e->compoundMessage());
            $t= new TypeReference($qualified, Types::UNKNOWN_KIND);
          }
          $this->resolved[$qualified]= $t;
        }
        $register && $this->used[]= new TypeName($qualified);
      }
      
      return $this->resolved[$qualified];
    }
    
    /**
     * Set type
     *
     * @param   xp.compiler.ast.Node node
     * @param   xp.compiler.types.TypeName type
     */
    public function setType(xp·compiler·ast·Node $node, TypeName $type) {
      $this->types->put($node, $type);
    }
    
    /**
     * Return a type for a given node
     *
     * @param   xp.compiler.ast.Node node
     * @return  xp.compiler.types.TypeName
     */
    public function typeOf(xp·compiler·ast·Node $node) {
      if ($node instanceof ArrayNode) {
        return new TypeName('var[]');       // FIXME: Component type
      } else if ($node instanceof MapNode) {
        return new TypeName('[var:var]');   // FIXME: Component type
      } else if ($node instanceof StringNode) {
        return new TypeName('string');
      } else if ($node instanceof NaturalNode) {
        return new TypeName('int');
      } else if ($node instanceof DecimalNode) {
        return new TypeName('double');
      } else if ($node instanceof NullNode) {
        return new TypeName('lang.Object');
      } else if ($node instanceof BooleanNode) {
        return new TypeName('bool');
      } else if ($node instanceof ComparisonNode) {
        return new TypeName('bool');
      } else if ($this->types->containsKey($node)) {
        return $this->types[$node];
      }
      return TypeName::$VAR;
    }
  }
?>
