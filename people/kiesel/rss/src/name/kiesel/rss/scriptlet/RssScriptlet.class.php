<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'scriptlet.HttpScriptlet',
    'xml.rdf.RDFNewsFeed',
    'name.kiesel.rss.scriptlet.SvnClient'
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
    protected function configure() {
      // TBI
    }
        
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function doGet($request, $response) {
      $this->configure();
      
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
      $repository= $request->getParam('repository');
      $client= new SvnClient();
      $client->bind($repository);
      
      $result= $client->queryLog($request->getParam('limit', 100));
      $feed= new RDFNewsFeed();
      $feed->setChannel(
        'SVN ChangeLog for '.$repository,
        $repository,
        'SVN Log History'
      );
      
      for ($i= 0; $i < $result->entrySize(); $i++) {
        $feed->addItem(
          '[SVN] Revision '.$result->entry($i)->getRevision().' by '.$result->entry($i)->getAuthor(),
          '',
          $result->entry($i)->getMessage(),
          $result->entry($i)->getDate()
        );
      }
      
      $response->setContentType('text/xml');
      $response->write($feed->getSource(0));
    }
  }
?>
