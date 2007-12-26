<?php
/* This class is part of the XP framework
 *
 * $Id: QuantJarTask.class.php 8846 2007-04-14 18:46:50Z kiesel $ 
 */

  uses('net.xp_framework.quantum.task.DirectoryBasedTask');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantZipTask extends DirectoryBasedTask {
    protected
      $dest       = NULL,
      $basedir    = NULL,
      $compress   = TRUE,
      $filesOnly  = FALSE,
      $update     = FALSE,
      $whenEmpty  = 'skip',
      $comment    = NULL;

    #[@xmlmapping(element= '@dest')]
    public function setDest($d) {
      $this->dest= $d; 
    }
    
    #[@xmlmapping(element= '@basedir')]
    public function setBasedir($b) {
      $this->basedir= $b;
    }
    
    #[@xmlmapping(element= '@compress')]
    public function setCompress($c) {
      $this->compress= ('true' === $c);
    }
    
    #[@xmlmappping(element= '@filesOnly')]
    public function setFilesOnly($f) {
      $this->filesOnly= ('true' === $f);
    }
    
    #[@xmlmapping(element= '@whenEmpty')]
    public function setWhenEmpty($s) {
      if (!in_array($s, array('skip', 'fail', 'create')))
        throw new IllegalArgumentException('whenempty must be one of "skip", "fail" or "create", but was "'.$s.'"');
      
      $this->whenEmpty= $s;
    }
    
    #[@xmlmapping(element= '@comment')]
    public function setComment($c) {
      $this->comment= trim($c);
    }
    
    public function setUp() {
      if (NULL === $this->fileset && NULL === $this->basedir)
        throw new IllegalArgumentException('Either basedir or a nested fileset must be given.');
    }
    
    protected function openZip() {
      $zip= new ZipArchive();
      if (TRUE !== ($zip->open($this->uriOf($this->dest), ZIPARCHIVE::CREATE)))
        throw new IOException('Could not open zipfile.');
      
      return $zip;
    }
    
    protected function closeZip($zip) {
      if (TRUE !== $zip->close())
        throw new IOException('Could not close zipfile.');
    }
    
    protected function addElement($zip, $element) {
      $this->env()->out->writeLine('Adding '.$element->relativePath());
      
      if (TRUE !== $zip->addFile($element->getURI(), $this->env()->unixUri($element->relativePath())))
        throw new IOException('Could not add "'.$element->relativePath().'" to zipfile');
    }
    
    protected function setArchiveComment($zip) {
      if (TRUE !== $zip->setArchiveComment($this->valueOf($this->comment)))
        throw new IOException('Could not set archive comment in zipfile');
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
      
      $zip= $this->openZip();
      $iterator= $this->fileset->iteratorFor($this->env());

      while ($iterator->hasNext()) {
        $element= $iterator->next();
        
        if ($element instanceof QuantCollection) continue;
        $this->addElement($zip, $element);
      }
      
      $this->closeZip($zip);
    }
  }
?>
