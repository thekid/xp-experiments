<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @see      reference
   * @purpose  purpose
   */
  class ClassDistance extends Object {
    
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
     *       interface</li>
     * </ul>
     *
     * @param   lang.XPClass from
     * @param   lang.XPClass to
     * @return  int
     */
    public static function between(XPClass $from, XPClass $to) {
      if (!$from->isInterface() && $to->isInterface()) {         // Case 3
        $implementor= $from;
        $distance= 1;
        do {
          $parent= $implementor->getParentClass();
          if (NULL === $parent || !$parent->isSubclassOf($to)) return $distance;
          $distance++;
        } while (NULL !== ($implementor= $implementor->getParentClass()));
        return -1;
      } else if ($from->isInterface() && $to->isInterface()) {   // Case 2
        if ($from->equals($to)) return 0;
        $interfaces= $from->getInterfaces();
        $distance= 1;
        while ($interface= array_shift($interfaces)) {
          if ($interface->equals($to)) return $distance;
          $interfaces= array_merge($interfaces, $interface->getInterfaces());
          $distance++;
        }
        return -1;
      } else {                                                   // Case 1
        $distance= 0;
        do {
          if ($from->equals($to)) return $distance;
          $distance++;
        } while (NULL !== ($from= $from->getParentClass()));
        return -1;
      }
    }
  }
?>
