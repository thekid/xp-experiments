<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.collections.Map', 'util.collections.HashTable');

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
      $best= -1;
      $result= NULL;
      foreach ($this->backing->keys() as $class) {
        $distance= $this->classDistance($in, $class);
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

    /**
     * Returns distance between two classes from and to
     *
     * Case 1: From and to are both classes
     * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
     * <ul>
     *   <li>If class from equals class to, the distance will be 0</li>
     *   <li>If class from is not a subclass of class to, the distance 
     *       will be -1</li>
     *   <li>If class from is a subclass of to, the distance will be 
     *       one plus the number of classes inbetween</li>
     * </ul>
     *
     * Case 2: From and to are both interfaces
     * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
     * The same rules as described in case 1 apply.
     *
     * Case 3: From is a class, to is an interface
     * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
     * <ul>
     *   <li>If class from does not implement the interface, the 
     *       distance will be -1</li>
     *   <li>If class from implements the interface, the distance
     *       is how many of its parent classes also implement this
     *       interface plus one</li>
     * </ul>
     *
     * @param   lang.XPClass from
     * @param   lang.XPClass to
     * @return  int
     */
    protected function classDistance(Type $from, Type $to) {
      if (!$from->isInterface() && $to->isInterface()) {
        $distance= -1;
        do {
          $implemented= FALSE;
          foreach ($from->getInterfaces() as $i) {
            if (!$i->equals($to)) continue;
            $implemented= TRUE;
          }
          if (!$implemented) break;
          $distance++;
        } while (NULL !== ($from= $from->getParentClass()));
        return $distance+ 1;
      } else {
        $distance= 0;
        do {
          if ($from->equals($to)) return $distance;
          $distance++;
        } while (NULL !== ($from= $from->getParentClass()));
        return -1;
      }
    }
    
    #[region testing]
    protected static function doResolve($t, Type $type) {
      return $type->getName().' => '.xp::stringOf($t->resolve($type));
    }
    
    public static function main(array $args) {
      
      $map= new HashTable();
      $map->put(XPClass::forName('lang.types.Integer'), new String('IntegerMapper'));
      $map->put(XPClass::forName('lang.types.Number'), new String('NumberMapper'));
      $map->put(XPClass::forName('lang.types.String'), new String('StringMapper'));
      $map->put(XPClass::forName('lang.types.ArrayList'), new String('ArrayListMapper'));
      $map->put(XPClass::forName('lang.Generic'), new String('GenericMapper'));
      $map->put(XPClass::forName('lang.Object'), new String('ObjectMapper'));
      $map->put(XPClass::forName('lang.Enum'), new String('EnumMapper'));
      $map->put(XPClass::forName('util.Date'), new String('DateMapper'));
      $map->put(XPClass::forName('lang.Throwable'), new String('ThrowableMapper'));
      
      Console::writeLine($map);
      
      $t= new TypeMap($map);
      foreach ($args as $type) {
        Console::writeLine('* ', self::doResolve($t, Type::forName($type)));
      }
    }
    #[/region]
  }
?>
