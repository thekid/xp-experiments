<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.text';
  
  uses(
    'xp.ide.resolve.Nedit',
    'util.cmd.Console',
    'xp.ide.text.StreamWorker'
  );

  /**
   * nedit text actions
   *
   * @purpose  IDE
   */
  class xp·ide·text·Nedit extends Object {
    public
      #[@InputStream]
      $inputStream= NULL,

      #[@Cursor]
      $cursor= NULL;
      
    private
      $status= 0;

    /**
     * output all suggestions
     *
     * @param   string[] suggestions
     */
    #[@action(name='grepclassfile')]
    public function grepClassFile() {
      $searchWord= create(new xp·ide·text·StreamWorker($this->inputStream, $this->cursor))->grepClassName();
      $resolver= $this->createResolver();
      try {
        Console::$out->write($resolver->getSourceFileUri($searchWord->getText()));
        $this->status= $resolver->getStatus();
      } catch (IllegalArgumentException $e) {
        $this->status= 2;
      }
    }
    
    /**
     * resolver factory
     *
     * @return  xp.ide.resolve.Resolver
     */
    protected function createResolver() {
      return new xp·ide·resolve·Nedit();
    }
    
    /**
     * Get status
     *
     * @return  int
     */
    #[@status]
    public function getStatus() {
      return $this->status;
    }

  }
?>
