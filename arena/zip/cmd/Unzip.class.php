<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'io.zip.ZipFile',
    'io.File',
    'io.Folder'
  );

  /**
   * Unzips a ZIPfile
   *
   */
  class Unzip extends Command {
    protected $zip= NULL;
  
    /**
     * Sets zip file
     *
     * @param   string file
     */
    #[@arg(position= 0)]
    public function setFile($file) {
      $this->zip= ZipFile::open(create(new File($file))->getInputStream());
    }

    /**
     * Sets folder where files will be extracted to
     *
     * @param   string folder
     */
    #[@arg]
    public function setTarget($folder= '.') {
      $this->target= new Folder($folder);
      $this->target->exists() || $this->target->create();
    }
    
    /**
     * Main runner method
     *
     */
    public function run() {
      foreach ($this->zip->entries() as $entry) {
        $this->out->writeLine('- ', $entry->getName());
        $out= create(new File($this->target, $entry->getName()))->getOutputStream();
        $in= $entry->getInputStream();
        while ($in->available()) {
          $out->write($in->read());
        }
        $in->close();
      }
    }
  }
?>
