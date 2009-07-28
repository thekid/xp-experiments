<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.serialization.Format');

  /**
   * (Insert class' description here)
   *
   */
  class DefaultFormat extends Object implements io·serialization·Format {
    
    /**
     * Serialize a given argument to the specified output stream
     *
     * @param   io.streams.OutputStream out
     * @param   var arg
     * @throws  io.serialization.SerializationException
     */
    public function serialize(OutputStream $out, $arg) {
      // TODO: Implement
    }
    
    /**
     * Deserialize from a specified output stream
     *
     * @param   io.streams.InputStream in
     * @return  var
     * @throws  io.serialization.SerializationException
     */
    public function deserialize(InputStream $in) {
      // TODO: Implement
    }
  }
?>
