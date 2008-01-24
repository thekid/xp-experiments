<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'io.collections.FileCollection',
    'io.collections.iterate.FilteredIOCollectionIterator',
    'io.collections.iterate.ExtensionEqualsFilter'
  );

  /**
   * Analyzes sourcecode to find function calls
   *
   * @purpose  purpose
   */
  class Analyze extends Command {
    protected
      $scan = NULL;

    /**
     * Set directory to scan
     *
     * @param   string dir
     */
    #[@arg(position= 0)]
    public function setDirToScan($dir) {
      $this->scan= new FilteredIOCollectionIterator(
        new FileCollection($dir),
        new ExtensionEqualsFilter(xp::CLASS_FILE_EXT),
        TRUE
      );
      $this->out->writeLine('---> ', $this->scan);
    }
    
    /**
     * Main runner method
     *
     */
    public function run() {
      $functions= array();
      $total= 0;
      $this->out->write('[');
      foreach ($this->scan as $element) {
        $t= token_get_all(file_get_contents($element->getUri()));
        for ($i= 0, $l= 1, $s= sizeof($t); $i < $s; $i++) {
          is_array($t) && $l+= substr_count($t[$i]{1}, "\n");
          if (
            T_FUNCTION !== $t[$i]{0} &&             // Omit function declarations
            T_NEW !== $t[$i]{0} &&                  // Omit instance creation
            T_OBJECT_OPERATOR !== $t[$i+ 1]{0} &&   // Omit chains and member calls
            T_DOUBLE_COLON !== $t[$i+ 1]{0} &&      // Omit static calls
            T_STRING === $t[$i+ 2]{0} && 
            '(' === $t[$i+ 3]{0}
          ) {
            // $this->out->writeLine($t[$i+ 2]{1}, '() @ ', $l, ' of ', $element);
            $functions[$t[$i+ 2]{1}]++;
            $total++;
          } 
        }
        $this->out->write('.');
      }
      $this->out->writeLine(']');
      arsort($functions);
      $this->out->write('---> Found a total of ', $total, ' function calls, ', sizeof($functions), ' distinct: ');
      $this->out->writeLine($functions);
    }
  }
?>
