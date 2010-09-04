<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.TextReader');
  
  class PropertiesReader extends Object {
    
    public function __construct(TextReader $reader) {
      $this->reader= $reader;
    }
    
    public function readInto(Properties $prop) {
      $section= NULL;
            
      $line= 0;
      while (NULL !== ($t= $this->reader->readLine())) {
        $line++;
        
        // Skip zero-length or comment-only lines
        if (empty($t)) continue;
        
        // Skip whitespace lines
        if (' ' == $t{0} && '' == trim($t, " \t")) continue;
        
        // Check for new section
        if ('[' == $t{0}) {
          if (FALSE === ($p= strrpos($t, ']')))
            throw new FormatException('Unexpected format for opening section at line '.$line);
          
          $section= substr($t, 1, $p- 1);
          $prop->writeSection($section, TRUE);
          continue;
        }
        
        // Read comments
        if (';' == $t{0} || '#' == $t{0}) {
          $prop->writeComment($section, substr($t, 1));
          continue;
        }

        // Process regular line
        if (FALSE === ($p= strpos($t, '='))) continue;
          
        $key= trim(substr($t, 0, $p));
        $value= trim(substr($t, $p+ 1), ' ');
        
        // Check for string quotations
        if (strlen($value) && ('"' == ($quote= $value{0}))) {
          $value= trim($value, $quote);
          $value= trim(substr($value, 0, ($p= strpos($value, '"')) !== FALSE
            ? $p : strlen($value)
          ));
        
        // Check for comment
        } else if (FALSE !== ($p= strpos($value, ';'))) {
          $value= trim(substr($value, 0, $p));
        }

        $prop->writeString($section, $key, $value);
      }
      
      return $prop;
    }
  }

?>