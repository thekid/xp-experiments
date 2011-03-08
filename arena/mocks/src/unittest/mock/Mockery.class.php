<?php

  /* This class is part of the XP framework
   *
   * $Id$
   */

  uses('lang.Type',
       'unittest.mock.MockProxy');

  /**
   * Class for creating mock/stub instances of arbitrary types
   *
   * @purpose  Mocking
   */
  class Mockery extends Object {
    /**
     * Builds a stub instance for the specified type.
     *
     * @param   string typeName
     * @return  Object
     */
    public function createMock($typeName) {
      $type = Type::forName($typeName);

      if (!($type instanceof XPClass)) {
        throw new IllegalArgumentException('Cannot mock other types than XPClass types.');
      }

      $parentClass=XPClass::forName('lang.Object');
      $interfaces=array();
      if($type->isInterface())
        $interfaces[]=$type;
      else 
        $parentClass=$type;

      $defaultCL= ClassLoader::getDefault();

      $proxy= new Proxy();
      $proxyClass= $proxy->createProxyClass($defaultCL, $interfaces, $parentClass);
      return $proxyClass->newInstance();
    }
  }

?>