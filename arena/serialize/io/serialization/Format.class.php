<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'io.serialization';
  
  uses('io.streams.OutputStream', 'io.streams.InputStream');

  /**
   * Serialization format
   *
   */
  interface io·serialization·Format {
    
    /**
     * Serialize a given argument to the specified output stream
     *
     * @param   io.streams.OutputStream out
     * @param   var arg
     * @throws  io.serialization.SerializationException
     */
    public function serialize(OutputStream $out, $arg);
    
    /**
     * Deserialize from a specified output stream
     *
     * @param   io.streams.InputStream in
     * @return  var
     * @throws  io.serialization.SerializationException
     */
    public function deserialize(InputStream $in);
  }
?>
