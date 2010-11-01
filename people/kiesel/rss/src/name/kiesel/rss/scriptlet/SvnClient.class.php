<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.URL',
    'lang.Process',
    'xml.meta.Unmarshaller',
    'xml.parser.StringInputSource'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class SvnClient extends Object {
    protected
      $repository = NULL;
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function bind($url) {
      $this->repository= new URL($url);
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function buildCommand($action, array $ext= NULL) {
      $cmd= array($action, '--xml');
      
      foreach ($ext as $k => $v) {
        if (is_numeric($k)) {
          $cmd[]= '--'.$v;
          continue;
        }
        
        $cmd[]= '--'.$k.'='.$v;
      }
      
      $cmd[]= $this->repository->getURL();
      return $cmd;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function queryLogAsString($max= NULL) {
      $cmd= $this->buildCommand('log', array('verbose', 'limit' => $max));
      $out= $this->invokeSvn($cmd);

      return $out;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function queryLog($max= NULL) {
      $um= new Unmarshaller();
      return $um->unmarshalFrom(
        new StringInputSource($this->queryLogAsString($max)),
        'name.kiesel.rss.svn.SvnLog'
      );
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function invokeSvn(array $cmd) {
      $proc= new Process('svn', $cmd);
      $proc->in->close();
      
      $out= '';
      while ($l= $proc->out->readLine()) {
        $out.= $l."\n";
      }
      
      $proc->close();
      return $out;
    }
  }
?>
