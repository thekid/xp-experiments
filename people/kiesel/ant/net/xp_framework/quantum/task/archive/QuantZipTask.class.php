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
    
    protected function openZip($env) {
      $zip= new ZipArchive();
      if (TRUE !== ($zip->open($env->localUri($env->substitute($this->dest)), ZIPARCHIVE::CREATE)))
        throw new IOException('Could not open zipfile.');
      
      return $zip;
    }
    
    protected function closeZip($env, $zip) {
      if (TRUE !== $zip->close())
        throw new IOException('Could not close zipfile.');
    }
    
    protected function addElement($env, $zip, $element) {
      $env->out->writeLine('Adding '.$element->relativePart());
      
      if ($element->file instanceof FileCollection) {
        return;
        if (TRUE !== $zip->addEmptyDir(rtrim($element->relativePart(), $env->directorySeparator()))) {
          var_dump(xp::registry('errors'));
          throw new IOException('Could not add directory '.$element->relativePart().' to zipfile');;
        }
      }
      
      if (TRUE !== $zip->addFile($element->getURI(), $env->unixUri($element->relativePart())))
        throw new IOException('Could not add "'.$element->relativePart().'" to zipfile');
    }
    
    protected function setArchiveComment($env, $zip) {
      if (TRUE !== $zip->setArchiveComment($env->substitute($this->comment)))
        throw new IOException('Could not set archive comment in zipfile');
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute(QuantEnvironment $env) {
      if (NULL !== $this->basedir) {
        $this->setFileset(new QuantFileset());
        $this->fileset->setDir($this->basedir);
        $this->fileset->addIncludePatternString('**/*');
      }
      
      $zip= $this->openZip($env);
      $iterator= $this->fileset->iteratorFor($env);

      while ($iterator->hasNext()) {
        $element= $iterator->next();
        
        $this->addElement($env, $zip, $element);
      }
      
      $this->closeZip($env, $zip);
    }    
  }
?>
