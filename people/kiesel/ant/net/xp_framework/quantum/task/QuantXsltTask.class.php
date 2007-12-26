<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'net.xp_framework.quantum.task.DirectoryBasedTask',
    'xml.DomXSLProcessor'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantXsltTask extends DirectoryBasedTask {
    protected
      $destdir    = NULL,
      $extension  = 'xml',
      $style      = NULL,
      $force      = FALSE,
      $in         = NULL,
      $out        = NULL,
      $params     = array();
    
    protected
      $processor  = NULL;
    
    #[@xmlmapping(element= '@destdir')]
    public function setDestdir($d) {
      $this->destdir= $d;
    }
    
    #[@xmlmapping(element= '@extension')]
    public function setExtension($e) {
      $this->extension= $e;
    }
    
    #[@xmlmapping(element= '@style')]
    public function setStyle($s) {
      $this->style= $s;
    }
    
    #[@xmlmapping(element= '@force')]
    public function setForce($f) {
      $this->force= ('true' === $f);
    }
    
    #[@xmlmapping(element= '@in')]
    public function setIn($in) {
      $this->in= $in;
    }
    
    #[@xmlmapping(element= '@out')]
    public function setOut($out) {
      $this->out= $out;
    }
    
    #[@xmlmapping(element= 'param', pass= array('@name', '@expression'))]
    public function addParam($name, $expr) {
      $this->params[$name]= $expr;
    }
    
    public function setUp() {
      if (NULL !== $this->in && NULL === $this->out || NULL === $this->in && NULL !== $this->out)
        throw new IllegalArgumentException('Both in and out must be specified together or omitted');
    }
    
    protected function translateToFile($style, $in, $out) {
      if (NULL === $this->processor) {
        $this->processor= new DomXSLProcessor();
      }
      
      $this->processor->setXSLFile($style);
      $this->processor->setXMLFile($in);
      
      try {
        $f= new File($out);
        $f->open(FILE_MODE_WRITE);
        
        $this->processor->run();
        $f->write($this->processor->output());
        $f->close();
      } catch (TransformerException $e) {
        // What to do?
        throw new QuantBuildException($e->getMessage(), $e);
      }
    }
    
    protected function replaceExtension($out) {
      // Remove file extension and add target extension
      return (FALSE !== strpos(basename($out))
        ? substr($out, 0, strrpos('.'))
        : $out
      ).'.'.$this->extension;
    }
    
    protected function execute() {
      $style= $this->uriOf($this->style);
      
      if ($this->in) {
        $in= $this->uriOf($this->in);
        $out= $this->replaceExtension($this->uriOf($this->out));
        
        $this->translateToFile($style, $in, $out);
        return;
      }
      
      $iterator= $this->fileset->iteratorFor($env);
      while ($iterator->hasNext()) {
        $element= $iterator->next();
        
        $this->translateToFile(
          $style, 
          $element->relativePath(), 
          $this->uriOf($this->destdir.'/'.$element->relativePath())
        );
      }
    }
  }
?>
