<?php
  function __error($code, $message, $file, $line, $scope) {
    static $primitives= array(    // Mapping notation in source -> string produced by gettype() 
      'string' => 'string',
      'int'    => 'integer',
      'bool'   => 'boolean',
      'float'  => 'float'
    );
    
    if (E_RECOVERABLE_ERROR === $code) {
      sscanf($message, 'Argument %d passed to %s must be an instance of %[^,], %s given', 
        $offset,
        $callable,
        $restriction,
        $type
      );
      
      if (isset($primitives[$restriction]) && $primitives[$restriction] == $type) return TRUE;
      throw new InvalidArgumentException(
        $callable.': Argument '.$offset.' must be of type '.$restriction.', '.$type.' given'
      );
    }
  }
  set_error_handler('__error');
?>
