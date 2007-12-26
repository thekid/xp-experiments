<?php
/* This class is part of the XP framework
 *
 * $Id: QuantJarTask.class.php 8846 2007-04-14 18:46:50Z kiesel $ 
 */

  uses(
    'net.xp_framework.quantum.task.DirectoryBasedTask',
    'lang.archive.Archive',
    'io.File'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantXarTask extends DirectoryBasedTask {
    protected
      $dest       = NULL,
      $basedir    = NULL,
      $update     = FALSE,
      $verbose    = FALSE,
      $whenEmpty  = 'skip';

    #[@xmlmapping(element= '@dest')]
    public function setDest($d) {
      $this->dest= $d; 
    }
    
    #[@xmlmapping(element= '@basedir')]
    public function setBasedir($b) {
      $this->basedir= $b;
    }
    
    #[@xmlmapping(element= '@whenEmpty')]
    public function setWhenEmpty($s) {
      if (!in_array($s, array('skip', 'fail', 'create')))
        throw new IllegalArgumentException('whenempty must be one of "skip", "fail" or "create", but was "'.$s.'"');
      
      $this->whenEmpty= $s;
    }
    
    #[@xmlmapping(element= '@verbose')]
    public function setVerbose($v) {
      $this->verbose= ('true' === $v);
    }
    
    public function setUp() {
      if (NULL === $this->fileset && NULL === $this->basedir)
        throw new IllegalArgumentException('Either basedir or a nested fileset must be given.');
    }
    
    protected function open() {
      $arc= new Archive(new File($this->uriOf($this->dest)));
      $arc->open(ARCHIVE_CREATE);
      return $arc;
    }
    
    protected function close($arc) {
      $arc->create();
      if ($arc->isOpen()) $arc->close();
    }
    
    protected function addElement(Archive $arc, QuantFile $element) {
      $this->verbose && $this->env()->out->writeLine('Adding '.$element->relativePath());
      
      $arc->add(new File($element->getURI()), $this->env()->unixUri($element->relativePath()));
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute() {
      if (NULL !== $this->basedir) {
        $this->setFileset(new QuantFileset());
        $this->fileset->setDir($this->basedir);
        $this->fileset->addIncludePatternString('**/*');
      }
      
      $arc= NULL; $dest= $this->uriOf($this->dest); 
      $arc= $this->open();
      
      $iterator= $this->fileset->iteratorFor($this->env());
      $cnt= 0;
      while ($iterator->hasNext()) {
        $element= $iterator->next();
        
        // XARs do not contain folders
        if ($element instanceof QuantCollection) continue;
        
        $cnt++;
        $this->addElement($arc, $element);
      }
      
      if (0 === $cnt) {
        switch ($this->whenEmpty) {
          case 'fail': throw new QuantBuildException('No files matched when creating xar '.$dest);
          case 'create': $arc->create(); break;
          case 'skip': break; 
        }
      } else {
        $arc->create();
      }
      
      $arc->isOpen() && $arc->close();
      delete($arc);
    }
  }
?>
