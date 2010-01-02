<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'io.zip.ZipFile',
    'io.File',
    'io.Folder',
    'peer.http.HttpConnection'
  );

  /**
   * Unzips a ZIPfile
   *
   */
  class Unzip extends Command {
    protected $zip= NULL;
    protected $target= NULL;

    /**
     * Ensures a folder exists, creating it otherwise
     *
     * @param   io.Folder f
     * @return  io.Folder the folder given
     */
    protected function ensureFolder(Folder $f) {
      $f->exists() || $f->create();
      return $f;
    }
  
    /**
     * Sets zip file
     *
     * @param   string file
     */
    #[@arg(position= 0)]
    public function setFile($file) {
      if (strstr($file, '://')) {
        $input= create(new HttpConnection($file))->get()->getInputStream();
      } else {
        $input= create(new File($file))->getInputStream();
      }
      $this->zip= ZipFile::open($input);
    }

    /**
     * Sets folder where files will be extracted to
     *
     * @param   string folder
     */
    #[@arg]
    public function setTarget($folder= '.') {
      $this->target= $this->ensureFolder(new Folder($folder));
    }
    
    /**
     * Main runner method
     *
     */
    public function run() {
      foreach ($this->zip->entries() as $entry) {
        $this->out->writeLine('- ', $entry->getName());
        if ($entry->isDirectory()) {
          $this->ensureFolder(new Folder($this->target, $entry->getName()));
        } else {
          $f= new File($this->target, $entry->getName());
          $this->ensureFolder(new Folder($f->getPath()));
          
          $out= $f->getOutputStream();
          $in= $entry->getInputStream();
          while ($in->available()) {
            $out->write($in->read());
          }
          $in->close();
        }
      }
    }
  }
?>
