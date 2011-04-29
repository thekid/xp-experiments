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
   * @purpose  Compiler
   */
  class Compile extends Command {
  
    /**
     * Set origin directory (the directory the XP framework is in)
     *
     * @param   string
     */
    #[@arg(position= 0)]
    public function setOrigin($dir) {
      $this->origin= new FileCollection($dir);
    }

    /**
     * Set name of archive file to create
     *
     * @param   string
     */
    #[@arg(position= 1)]
    public function setArchive($file) {
      $this->archive= new Archive(new File($file));
      $this->archive->open(ARCHIVE_CREATE);
    }

    /**
     * Set build directory
     *
     * @param   string
     */
    #[@arg]
    public function setBuildDir($dir= '.') {
      $this->build= $dir;
    }

    /**
     * Main runner method
     *
     */
    public function run() {
    
      // Fork compiler process - this is necessary because the bcompiler_compile_* 
      // functions will compile the source into the current context, which leads
      // to "cannot redeclare class XXX" messages and other weird sideeffects.
      $compiler= new Process(Runtime::getInstance()->getExecutable()->getFilename(), array('compiler.php', $this->build));

      // Exclude directories and version-control files
      $filter= new NegationOfFilter(new AnyOfFilter(array(
        new CollectionFilter(),
        new RegexFilter('/.svn/')
      )));
      
      // For all files - if it's a class file, compile it, otherwise just add it
      foreach (new FilteredIOCollectionIterator($this->origin, $filter, TRUE) as $e) {
        $name= strtr(substr($e->getUri(), strlen($this->origin->getUri())), DIRECTORY_SEPARATOR, '/');

        if (xp::CLASS_FILE_EXT === substr($e->getUri(), -10)) {
          $compiler->in->write(strtr(substr($name, 0, -10), '/', '_').' '.$e->getUri()."\n");
          sscanf($compiler->out->readLine(), "%c %[^\n]", $status, $data);
          if ('+' !== $status) {
            $this->err->writeLine('*** ', $data);
            continue;
          }
          
          $f= new File($data);
          $delete= TRUE;
        } else {
          $f= new File($e->getUri());
          $delete= FALSE;
        }
        
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
