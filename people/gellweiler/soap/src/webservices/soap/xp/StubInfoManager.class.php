<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('webservices.soap.xp.TypeStubInfo');

  /**
   * Stub info manager. Takes care 
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class StubInfoManager extends Object {
    protected static
      $stubinfo= array();

    /**
     * Get type info for a given class
     *
     * @param   lang.XPClass class
     * @return  webservices.soap.xp.TypeStubInfo
     */
    public static function getTypeStub(XPClass $class) {
      if (isset(self::$stubinfo[$class->getClassname()])) {
        return self::$stubinfo[$class->getClassname()];
      }
     
      $typeInfo= new TypeStubInfo($class);
      self::$stubinfo[$class->getClassname()]= $typeInfo;

      return $typeInfo;
    }
  }
?>
