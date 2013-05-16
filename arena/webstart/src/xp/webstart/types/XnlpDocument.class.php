<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.URL',
    'xp.webstart.types.Application',
    'xp.webstart.types.XarResource',
    'xp.webstart.types.URL'
  );

  /**
   * Represents an XNLP document
   *
   */
  class XnlpDocument extends Object {
    protected $version= '';
    protected $codebase= NULL;
    protected $app= NULL;
    protected $resources= array();
    
    /**
     * Sets version
     *
     * @param   string version
     */
    #[@xmlmapping(element= '@version')]
    public function setVersion($version) {
      $this->version= $version;
    }

    /**
     * Sets codebase
     *
     * @param   xp.webstart.types.URL codebase
     */
    #[@xmlmapping(element= '@codebase', class= 'xp.webstart.types.URL')]
    public function setCodebase(xp·webstart·types·URL $codebase) {
      $this->codebase= $codebase;
    }

    /**
     * Gets codenase
     *
     * @return  xp.webstart.types.URL codebase
     */
    public function getCodebase() {
      return $this->codebase;
    }

    /**
     * Sets app
     *
     * @param   xp.webstart.types.Application app
     */
    #[@xmlmapping(element= 'app', class= 'xp.webstart.types.Application')]
    public function setApp(xp·webstart·types·Application $app) {
      $this->app= $app;
    }

    /**
     * Gets app
     *
     * @return  xp.webstart.types.Application app
     */
    public function getApp() {
      return $this->app;
    }

    /**
     * Adds a resource
     *
     * @param   xp.webstart.types.Resource res
     */
    #[@xmlmapping(element= 'resources/*', factory= 'resourceClass')]
    public function addResource(xp·webstart·types·Resource $res) {
      $this->resources[]= $res;
    }
    
    /**
     * Fetches resource class
     *
     * @param   string name
     * @return  string class name
     */
    public function resourceClass($name) {
      switch ($name) {
        case 'xar': return 'xp.webstart.types.XarResource';
      }
    }

    /**
     * Gets resources
     *
     * @return  xp.webstart.types.Resource[]
     */
    public function getResources() {
      return $this->resources;
    }
    
    /**
     * Creates a string representation
     *
     * @return  string
     */
    public function toString() {
      return sprintf(
        "%s(version=%s)@{\n".
        "  codebase   -> %s\n".
        "  app        -> %s\n".
        "  resources  -> %s\n".
        "}",
        $this->getClassName(),
        $this->version,
        xp::stringOf($this->codebase),
        xp::stringOf($this->app),
        xp::stringOf($this->resources, '  ')
      );
    }
  }
?>
