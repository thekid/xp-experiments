<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
 
  $package= 'cmd.convert';
 
  uses(
    'util.cmd.Command',
    'cmd.convert.SourceConverter',
    'io.File',
    'io.FileUtil'
  );

  /**
   * Convert a given class file to XP Language
   *
   */
  class cmd·convert·ToXpLang extends Command {
    protected $file= '';
    protected $converter= NULL;
    
    /**
     * Creates converter
     *
     */
    public function __construct() {
      $this->converter= new SourceConverter();
    }
  
    /**
     * Sets file to convert
     *
     * @param   string file
     */
    #[@arg(position= 0)]
    public function setInput($file) {
      $this->file= new File($file);
    }
    
    /**
     * Determine class
     *
     * @param   io.File f
     * @return  string
     * @throws  lang.IllegalArgumentException
     */
    protected function classNameOf(File $file) {
      $uri= $file->getURI();
      $path= dirname($uri);
      $paths= array_flip(array_map('realpath', xp::$registry['classpath']));
      $class= NULL;
      while (FALSE !== ($pos= strrpos($path, DIRECTORY_SEPARATOR))) { 
        if (isset($paths[$path])) {
          return strtr(substr($uri, strlen($path)+ 1, -10), DIRECTORY_SEPARATOR, '.');
          break;
        }

        $path= substr($path, 0, $pos); 
      }
      throw new IllegalArgumentException('Cannot determine class name from '.$file->toString());
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      try {
        $this->out->writeLine($this->converter->convert(
          $this->classNameOf($this->file), 
          token_get_all(FileUtil::getContents($this->file))
        ));
      } catch (Throwable $e) {
        $this->err->writeLine($e);
      }
    }
  }
?>
