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
          new ExtensionEqualsFilter(xp::CLASS_FILE_EXT),
          new NegationOfFilter(new RegexFilter('#'.preg_quote(DIRECTORY_SEPARATOR).'(CVS|\.svn)'.preg_quote(DIRECTORY_SEPARATOR).'#')),
          new NegationOfFilter(new CollectionFilter())
        )),
        TRUE
      );
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
        
        $t= token_get_all(file_get_contents($uri));
        for ($i= 0, $s= sizeof($t); $i < $s; $i++) {
          if (T_CLASS === $t[$i][0] || T_INTERFACE === $t[$i][0]) {
            $className= $t[$i+ 2][1];
            foreach ($this->bases as $base) {
              if ($uri->startsWith($base->getUri())) $uri= $uri->substring(strlen($base->getUri()));
            }
            $qualifiedName= new String(str_replace('.', '::', strtr(substr($uri, 0, -strlen(xp::CLASS_FILE_EXT)), '/\\', '..')));
            
            if ($nameMap->containsKey($className)) {
              $messages->add(new String($className.' resolves to '.$nameMap[$className].' and '.$qualifiedName));
            } else {
              $nameMap[$className]= $qualifiedName;
            }
            $this->err->write('.');
            break;
          }
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
