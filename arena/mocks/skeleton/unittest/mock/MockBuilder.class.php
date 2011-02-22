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
   * @purpose  Mockery
   */
  class MockBuilder extends Object {
    /**
     * Builds a stub instance for the specified type.
     *
     * @param   string typeName
     * @return  Object
     */
    public function buildMock($typeName) {
      $type = Type::forName($typeName);

      if (!($type instanceof XPClass)) {
        throw new IllegalArgumentException('Cannot mock other types than XPClass types.');
      }

      $defaultCL= ClassLoader::getDefault();
      $proxyClass= MockProxy::getProxyClass($defaultCL, array($type));
      return $proxyClass->newInstance();
    }
  }
?>