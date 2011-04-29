<?php
  define('DETAIL_ARGUMENTS',      1);
  define('DETAIL_RETURNS',        2);
  define('DETAIL_THROWS',         3);
  define('DETAIL_COMMENT',        4);
  define('DETAIL_ANNOTATIONS',    5);
  define('DETAIL_NAME',           6);

  // Change to build directory
  chdir($argv[1]);

  while ($l= fgets(STDIN, 1024)) {
    sscanf($l, "%s %[^\n]", $class, $target);
    
    // Sanity check
    if (!is_file($target)) {
      echo "- Does not exist: <", $target, ">\n";
      continue;
    }
    
    // Extract metadata
    $details= array();
    $tokens= token_get_all($source= file_get_contents($target));
    for ($i= 0, $s= sizeof($tokens); $i < $s; $i++) {
      switch ($tokens[$i][0]) {
        case T_DOC_COMMENT:
          $comment= $tokens[$i][1];
          break;

        case T_COMMENT:

          // Annotations
          if (strncmp('#[@', $tokens[$i][1], 3) == 0) {
            $annotations[0]= substr($tokens[$i][1], 2);
          } else if (strncmp('#', $tokens[$i][1], 1) == 0) {
            $annotations[0].= substr($tokens[$i][1], 1);
          }

          // End of annotations
          if (']' == substr(rtrim($tokens[$i][1]), -1)) {
            $annotations= @eval('return array('.preg_replace(
              array('/@([a-z_]+),/i', '/@([a-z_]+)\(\'([^\']+)\'\)/i', '/@([a-z_]+)\(/i', '/([^a-z_@])([a-z_]+) *= */i'),
              array('\'$1\' => NULL,', '\'$1\' => \'$2\'', '\'$1\' => array(', '$1\'$2\' => '),
              trim($annotations[0], "[]# \t\n\r").','
            ).');');
            if (!is_array($annotations)) $annotations= array();
          }
          break;

        case T_CLASS:
        case T_INTERFACE:
          $details['class']= array(
            DETAIL_COMMENT      => trim(preg_replace('/\n   \* ?/', "\n", "\n".substr(
              $comment, 
              4,                              // "/**\n"
              strpos($comment, '* @')- 2      // position of first details token
            ))),
            DETAIL_ANNOTATIONS  => $annotations
          );
          $annotations= array();
          $comment= NULL;
          break;

        case T_VARIABLE:
          if (!$members) break;

          // Have a member variable
          $name= substr($tokens[$i][1], 1);
          $details[0][$name]= array(
            DETAIL_ANNOTATIONS => $annotations
          );
          $annotations= array();
          break;

        case T_FUNCTION:
          $members= FALSE;
          while (T_STRING !== $tokens[$i][0]) $i++;
          $m= $tokens[$i][1];
          $details[1][$m]= array(
            DETAIL_ARGUMENTS    => array(),
            DETAIL_RETURNS      => 'void',
            DETAIL_THROWS       => array(),
            DETAIL_COMMENT      => trim(preg_replace('/\n     \* ?/', "\n", "\n".substr(
              $comment, 
              4,                              // "/**\n"
              strpos($comment, '* @')- 2      // position of first details token
            ))),
            DETAIL_ANNOTATIONS  => $annotations,
            DETAIL_NAME         => $tokens[$i][1]
          );
          $matches= NULL;
          preg_match_all(
            '/@([a-z]+)\s*([^<\r\n]+<[^>]+>|[^\r\n ]+) ?([^\r\n ]+)?/',
            $comment, 
            $matches, 
            PREG_SET_ORDER
          );
          $annotations= array();
          $comment= NULL;
          foreach ($matches as $match) {
            switch ($match[1]) {
              case 'param':
                $details[1][$m][DETAIL_ARGUMENTS][]= $match[2];
                break;

              case 'return':
                $details[1][$m][DETAIL_RETURNS]= $match[2];
                break;

              case 'throws': 
                $details[1][$m][DETAIL_THROWS][]= $match[2];
                break;
            }
          }
          break;

        default:
          // Empty
      }
    }
    
    // Append meta information function
    $meta= basename($target);
    $m= fopen($meta, 'wb');
    fwrite($m, str_replace('?>', '', rtrim($source)));
    fwrite($m, ' function __'.$class.'() { return '.var_export($details, TRUE).'; } ?>');
    fclose($m);
  
    // Compile it
    $name= tempnam($argv[1], 'comp');
    $f= fopen($name, 'wb');
    bcompiler_write_header($f);
    bcompiler_write_file($f, $meta);
    bcompiler_write_footer($f);
    fclose($f);
    
    // Success!
    unlink($meta);
    echo "+ ", $name, "\n";
  }
?>
