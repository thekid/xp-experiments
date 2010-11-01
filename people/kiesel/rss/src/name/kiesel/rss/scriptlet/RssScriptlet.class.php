<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'scriptlet.HttpScriptlet',
    'xml.rdf.RDFNewsFeed'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class RssScriptlet extends HttpScriptlet {
    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function doGet($request, $response) {
      try {
        $this->getClass()->getMethod('perform'.ucfirst($request->getParam('action', 'usage')))
          ->invoke($this, array($request, $response))
        ;
      } catch (Throwable $t) {
        $response->setStatus(HttpConstants::STATUS_INTERNAL_SERVER_ERROR);
        return;
      }
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function performUsage($request, $response) {
      $response->setContentType('text/html');
      $response->write('<html><body><h1>Help</h1><p>Here comes the usage.</p></body></html>');
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function performLog($request, $response) {
      $response->setContentType('text/xml');
      $client= new SvnClient($request->getParam('repository'));
      
      $result= $client->diff();
    }    
  }
?>
