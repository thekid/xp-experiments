<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.collections.Map', 'util.collections.HashTable', 'util.invoke.ClassDistance');

  /**
   * (Insert class' description here)
   *
   * @see      reference
   * @purpose  purpose
   */
  class TypeMap extends Object {
    
    /**
     * Constructor
     *
     * @param   util.collections.Map<lang.XPClass, lang.Generic> backing
     */
    public function __construct(Map $backing) {
      $this->backing= $backing;
    }
    
    /**
     * Resolves a type
     *
     * @param   lang.Type in
     * @return  lang.Generic resolved or NULL if this type cannot be resolved
     */
    public function resolve(Type $in) {
      if ($in instanceof Primitive) $in= $in->asClass();
      
      // Short-circuit the most obvious case
      if ($this->backing->containsKey($in)) return $this->backing->get($in);
      
      // Search for most specific type
      $best= -1;
      $result= NULL;
      foreach ($this->backing->keys() as $class) {
        $distance= ClassDistance::between($in, $class);
        Console::$err->writeLine('- Distance(', $in, ', ', $class, ')= ', $distance);
        if (-1 === $distance) {
          continue;
        } else if (0 === $distance) {
          return $this->backing->get($class);
        } else if ($distance < $best || -1 === $best) {
          $best= $distance;
          $result= $this->backing->get($class);
        }
      }
      return $result;
    }
    
    #[region testing]
    protected static function doResolve($t, Type $type) {
      return $type->getName().' => '.xp::stringOf($t->resolve($type));
    }
    
    public static function main(array $args) {
      
      $map= new HashTable();
      $map->put(XPClass::forName('lang.Generic'), new String('GenericMapper'));
      $map->put(XPClass::forName('lang.types.Integer'), new String('IntegerMapper'));
      $map->put(XPClass::forName('lang.types.Number'), new String('NumberMapper'));
      $map->put(XPClass::forName('lang.types.String'), new String('StringMapper'));
      $map->put(XPClass::forName('lang.types.ArrayList'), new String('ArrayListMapper'));
      $map->put(XPClass::forName('lang.Object'), new String('ObjectMapper'));
      $map->put(XPClass::forName('lang.Enum'), new String('EnumMapper'));
      $map->put(XPClass::forName('util.Date'), new String('DateMapper'));
      $map->put(XPClass::forName('lang.Throwable'), new String('ThrowableMapper'));
      $map->put(XPClass::forName('util.collections.Map'), new String('MapMapper'));
      
      Console::writeLine($map);
      
      $t= new TypeMap($map);
      foreach ($args as $type) {
        Console::writeLine('* ', self::doResolve($t, Type::forName($type)));
      }
    }
    #[/region]
  }
?>
