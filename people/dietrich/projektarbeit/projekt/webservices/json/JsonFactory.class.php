<?php
/* This class is part of the XP framework
 *
 * $Id: JsonFactory.class.php 12499 2008-09-21 21:00:23Z kiesel $ 
 */

  uses('webservices.json.JsonDecoder');

  /**
   * Json decoder factory. Use this class to get instances
   * of decoders.
   *
   * This enables us to use bundled PHP extensions if they're
   * available or use the userland implementation as fallback.
   *
   * @see      http://json.org
   * @purpose  Factory
   */
  class JsonFactory extends Object {
  
    /**
     * Create an instance of a decoder
     *
     * @return  webservices.json.IJsonDecoder
     */
    public static function create() {
      return new JsonDecoder();
    }
  }
?>
