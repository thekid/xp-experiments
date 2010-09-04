<?php
/* This class is part of the XP framework
 *
 * $Id: PropertiesReader.class.php 12522 2010-09-04 19:35:03Z kiesel $ 
 */

  uses('io.streams.TextWriter');
  
  class PropertiesWriter extends Object {
    protected
      $writer  = NULL;
      
    public function __construct(TextWriter $writer) {
      $this->writer= $writer;
    }
    
    public function writeFrom(Properties $prop) {
      $section= $prop->getFirstSection();
      while ($section) {
        $this->writer->writeLine('['.$section.']');
        
        foreach ($prop->readSection($section) as $key => $value) {
          if (';' == $key{0}) {
            $this->writer->writeLine('; '.$value);
            continue;
          }
          
          if ($value instanceof Hashmap) {
            $str= '';
            foreach ($value->keys() as $k) {
              $str.= '|'.$k.':'.$value->get($k);
            }
            $value= substr($str, 1);
          }
          if (is_array($value)) $value= implode('|', $value);
          if (is_string($value)) $value= '"'.$value.'"';
          $this->writer->writeLine($key.'='.strval($value));
        }
        
        $section= $prop->getNextSection();
        if ($section) $this->writer->writeLine();
      }
    }
  }
?>