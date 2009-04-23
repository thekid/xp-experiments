<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.compiler.Syntax',
    'xp.compiler.emit.Emitter',
    'io.streams.FileInputStream',
    'io.streams.FileOutputStream',
    'io.File'
  );

  /**
   * (Insert class' description here)
   *
   */
  class FileManager extends Object {

    /**
     * Get parse tree for a given qualified class name by looking it
     * up in the source path.
     *
     * @param   string qualified
     * @return  xp.compiler.ast.ParseTree
     */
    public function parseClass($qualified) {
      $name= DIRECTORY_SEPARATOR.strtr($qualified, '.', DIRECTORY_SEPARATOR);
      foreach (xp::$registry['classpath'] as $path) {
        foreach (Syntax::available() as $ext => $syntax) {
          if (!file_exists($uri= $path.$name.'.'.$ext)) continue;
          return $this->parseFile(new File($uri), $syntax);
        }
      }
      throw new ClassNotFoundException('Cannot find class '.$qualified);
    }
  
    /**
     * Get parse tree for a given file
     *
     * @param   io.File in
     * @param   xp.compiler.Syntax s Syntax to use, determined via file extension if null
     * @return  xp.compiler.ast.ParseTree
     */
    public function parseFile(File $in, Syntax $s= NULL) {
      if (NULL === $s) {
        $s= Syntax::forName($in->getExtension());
      }
      return $s->parse(new FileInputStream($in), $in->getURI());
    }

    /**
     * Write compilation result to a given target
     *
     * @param   xp.compiler.emit.Result r
     * @param   io.File target
     */
    public function write($r, File $target) {
      $r->writeTo(new FileOutputStream($target));
    }

    /**
     * Get target
     *
     * @param   var in
     * @return  io.File target
     */
    public function getTarget($in) {
      if ($in instanceof ParseTree) {
        $origin= new File($in->origin);
      } else if ($in instanceof File) {
        $origin= $in;
      } else {
        throw new IllegalArgumentException('In is expected to be either a File or a ParseTree, '.xp::typeOf($in).' given');
      }
      return new File($origin->getPath(), str_replace(
        strstr($origin->getFileName(), '.'), 
        xp::CLASS_FILE_EXT, 
        $origin->getFileName())
      );
    }
  }
?>
