<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'io.archive.zip.ZipFile',
    'io.Folder',
    'io.streams.StreamTransfer',
    'io.collections.FileCollection',
    'io.collections.FileElement',
    'io.collections.iterate.IOCollectionIterator',
    'io.collections.iterate.RegexFilter'
  );

  /**
   * Creates a ZIPfile
   * 
   */
  class Zip extends Command {
    protected $zip= NULL;
    protected $base= NULL;
    protected $origins= array();
    protected $exclude= NULL;
    
    /**
     * Constructor
     *
     */
    public function __construct() {
      $this->base= new Folder(getcwd());
    }
    
    /**
     * Calculates relative name for use inside ZIP file
     *
     * @param   io.IOElement e
     * @return  string
     */
    protected function relativeName(IOElement $e) {
      return str_replace($this->base->getURI(), '', $e->getURI());
    }
    
    /**
     * Add a single file
     *
     * @param   io.IOElement e
     */
    protected function addFile(IOElement $element) {
      if ($this->exclude && $this->exclude->accept($element)) return;

      $this->out->writeLine('F ', $this->relativeName($element));
      $entry= $this->zip->addFile(new ZipFileEntry($this->relativeName($element)));
      $entry->setLastModified($element->lastModified());
      $entry->setCompression(Compression::$GZ);

      $t= new StreamTransfer($element->getInputStream(), $entry->getOutputStream());
      try {
        $t->transferAll();
      } catch (IOException $e) {
        $this->err->writeLine('*** ', $e);
      }
      $t->close();
    }

    /**
     * Add an entire folder (recursively)
     *
     * @param   io.IOElement e
     */
    protected function addFolder(IOCollection $element) {
      if ($this->exclude && $this->exclude->accept($element)) return;
      
      $this->out->writeLine('D ', $this->relativeName($element));
      $this->zip->addDir(new ZipDirEntry($this->relativeName($element)))
        ->setLastModified($element->lastModified())
      ;
      foreach (new IOCollectionIterator($element, TRUE) as $child) {
        if ($child instanceof IOCollection) {
          $this->addFolder($child);
        } else {
          $this->addFile($child);
        }
      } 
    }
    
    /**
     * Sets zip file
     *
     * @param   string file
     */
    #[@arg(position= 0)]
    public function setFile($file) {
      $this->zip= ZipFile::create(create(new File($file))->getOutputStream());
    }

    /**
     * Sets exclude pattern
     *
     * @param   string pattern
     */
    #[@arg(short= 'x')]
    public function setExclude($pattern= NULL) {
      if (NULL !== $pattern) {
        $this->exclude= new RegexFilter('#'.$pattern.'#');
      }
    }

    /**
     * Sets origins
     *
     * @param   string[] origins
     */
    #[@args(select= '[1..]')]
    public function setOrigins($origins) {
      for ($i= 0, $s= sizeof($origins); $i < $s; $i++) {
        if ('-x' === $origins[$i]) {    // Exclude option
          $i+= 2;
        } else {
          $this->origins[]= $origins[$i];
        }
      }
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      foreach ($this->origins as $origin) {
        if (is_file($origin)) {
          $this->addFile(new FileElement($origin));
        } else if (is_dir($origin)) {
          $this->addFolder(new FileCollection($origin));
        } else {
          throw new IOException('Cannot handle "'.$origin.'"');
        }
      }
      $this->zip->close();
    }
  }
?>
