<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Abstract base class
   *
   */
  abstract class Types extends Object {
    const 
      CLASS_KIND        = 1,
      INTERFACE_KIND    = 2,
      ENUM_KIND         = 3;
    
    const
      UNKNOWN_KIND      = 0;

    /**
     * Returns name
     *
     * @return  string
     */
    public abstract function name();

    /**
     * Returns literal for use in code
     *
     * @return  string
     */
    public abstract function literal();

    /**
     * Returns literal for use in code
     *
     * @return  string
     */
    public abstract function kind();
  }
?>
