<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses(
    'util.cmd.Command',
    'io.collections.FileCollection',
    'io.collections.iterate.FilteredIOCollectionIterator',
    'io.collections.iterate.CollectionFilter',
    'io.collections.iterate.RegexFilter',
    'io.collections.iterate.AnyOfFilter',
    'io.collections.iterate.NegationOfFilter',
    'io.File',
    'io.TempFile',
    'io.FileUtil',
    'lang.Process',
    'lang.Runtime',
    'lang.archive.Archive'
  );

  /**
   * Compiles the XP framework
   *
   * @ext      bcompiler
   * @purpose  purpose
   */
  class Compile extends Command {
  
    /**
     * (Insert method's description here)
     *
     * @param   string
     */
    #[@arg(position= 0)]
    public function setOrigin($dir) {
      $this->origin= new FileCollection($dir);
    }

    /**
     * (Insert method's description here)
     *
     * @param   string
     */
    #[@arg(position= 1)]
    public function setArchive($file) {
      $this->archive= new Archive(new File($file));
      $this->archive->open(ARCHIVE_CREATE);
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      $compiler= new Process(Runtime::getInstance()->getExecutable()->getFilename(), array('compiler.php'));

      $filter= new NegationOfFilter(new AnyOfFilter(array(
        new CollectionFilter(),
        new RegexFilter('/.svn/')
      )));
      foreach (new FilteredIOCollectionIterator($this->origin, $filter, TRUE) as $e) {
        if (xp::CLASS_FILE_EXT === substr($e->getUri(), -10)) {
          $compiler->in->write($e->getUri()."\n");
          sscanf($compiler->out->readLine(), "%c %[^\n]", $status, $data);
          if ('-' === $status) {
            $this->err->writeLine('*** ', $data);
            continue;
          }
          
          $f= new File($data);
          $delete= TRUE;
        } else {
          $f= new File($e->getUri());
          $delete= FALSE;
        }
        
        $name= strtr(substr($e->getUri(), strlen($this->origin->getUri())), DIRECTORY_SEPARATOR, '/');
        $this->archive->addFileBytes(
          $name, 
          basename($name), 
          dirname($name), 
          FileUtil::getContents($f)
        );
        $this->out->writeLine('- ', $name);
        
        $delete && $f->unlink();
      }
      
      $this->archive->create();
      $compiler->close();
    }
  }
?>
