<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'lang.archive.Archive',
    'io.collections.FileCollection',
    'io.collections.CollectionComposite',
    'io.collections.iterate.FilteredIOCollectionIterator',
    'io.collections.iterate.NegationOfFilter',
    'io.collections.iterate.AllOfFilter',
    'io.collections.iterate.AnyOfFilter',
    'io.collections.iterate.CollectionFilter',
    'io.collections.iterate.NegationOfFilter',
    'io.collections.iterate.RegexFilter',
    'io.collections.iterate.ExtensionEqualsFilter',
    'util.collections.HashTable',
    'util.collections.Vector',
    'lang.types.String'
  );

  /**
   * Compiles name mapping
   * =====================
   *
   * Usage:
   * <pre>
   *   $ xpcli convert.NameMapping 
   *     ../../../../../xp/trunk/tools/ 
   *     ../../../../../xp/trunk/skeleton/ 
   *     ../../../../../xp/trunk/ports/classes/
   * </pre>
   *
   * @purpose  purpose
   */
  class NameMapping extends Command {
    protected
      $bases    = array(),
      $iterator = NULL;

    /**
     * Set origin directory
     *
     * @param   string origin
     */
    #[@args]
    public function setOrigins($origins) {
      foreach ($origins as $origin) {
        $this->bases[]= new FileCollection($origin);
      }
      $this->iterator= new FilteredIOCollectionIterator(
        new CollectionComposite($this->bases),
        new AllOfFilter(array(
          new AnyOfFilter(array(
            new ExtensionEqualsFilter(xp::CLASS_FILE_EXT),
            new ExtensionEqualsFilter('xar')
          )),
          new NegationOfFilter(new RegexFilter('#'.preg_quote(DIRECTORY_SEPARATOR).'(CVS|\.svn)'.preg_quote(DIRECTORY_SEPARATOR).'#')),
          new NegationOfFilter(new CollectionFilter())
        )),
        TRUE
      );
    }
    
    /**
     * Parse classname as declared in sourcecode
     *
     * @param   string sourceCode
     * @return  string name
     */
    protected function classNameOf($sourceCode) {
      $t= token_get_all($sourceCode);
      for ($i= 0, $s= sizeof($t); $i < $s; $i++) {
        if (T_CLASS === $t[$i][0] || T_INTERFACE === $t[$i][0]) {
          return $t[$i+ 2][1];
        }
      }
      return NULL;
    }
    
    /**
     * Add a name to the name mapping
     *
     * @param   util.collections.HashTable<String, String> nameMap
     * @param   string className
     * @param   string qualifiedName
     * @param   util.collections.Vector<String> messages
     * @return  bool
     */
    protected function mapName($nameMap, $className, $qualifiedName, $messages) {
      if ($nameMap->containsKey($className) && $nameMap[$className] != $qualifiedName) {
        $messages->add(new String($className.' resolves to '.$nameMap[$className].' and '.$qualifiedName));
        return FALSE;
      } else {
        $nameMap[$className]= new String($qualifiedName);
        return TRUE;
      }
    }
    
    /**
     * Main runner method
     *
     */
    public function run() {
      $this->err->writeLine('---> Building name map from ', $this->iterator);

      // Build name map
      $nameMap= create('new util.collections.HashTable<String, String>()');
      $messages= create('new util.collections.Vector<String>()');
      
      // Classes from origin
      $this->err->write('[');
      foreach ($this->iterator as $file) {
        $uri= new String($file->getUri());
        
        if ($uri->endsWith('.xar')) {
          $a= new Archive(new File($uri));
          $a->open(ARCHIVE_READ);
          while ($entry= $a->getEntry()) {
            if (xp::CLASS_FILE_EXT != substr($entry, -strlen(xp::CLASS_FILE_EXT))) continue;
            
            if (NULL === ($className= $this->classNameOf($a->extract($entry)))) {
              $messages->add(new String('Could not determine classname from '.$entry.' in '.$uri));
              $this->err->write('F');
              continue;
            }
            
            $qualifiedName= str_replace('/', '.', substr($entry, 0, -strlen(xp::CLASS_FILE_EXT)));
            $this->err->write($this->mapName($nameMap, $className, $qualifiedName, $messages) ? '.' : '!');
          }
          $a->close();
        } else if ($uri->endsWith(xp::CLASS_FILE_EXT)) {
          if (NULL === ($className= $this->classNameOf(file_get_contents($uri)))) {
            $messages->add(new String('Could not determine classname from '.$uri));
            $this->err->write('F');
            continue;
          }
          foreach ($this->bases as $base) {
            if ($uri->startsWith($base->getUri())) $uri= $uri->substring(strlen($base->getUri()));
          }
          $qualifiedName= strtr(substr($uri, 0, -strlen(xp::CLASS_FILE_EXT)), '/\\', '..');
          $this->err->write($this->mapName($nameMap, $className, $qualifiedName, $messages) ? '.' : '!');
        } else {
          $messages->add(new String('Could not determine what to do with '.$uri));
          $this->err->writeLine('F');
          continue;
        }
      }

      $this->err->writeLine(']');
      $this->err->writeLine('---> Done, ', $nameMap->size(), ' names mapped ');
      $this->err->writeLine($messages);
      
      foreach ($nameMap->keys() as $name) {
        $this->out->writeLine($name, '=', $nameMap->get($name));
      }
    }
  }
?>
