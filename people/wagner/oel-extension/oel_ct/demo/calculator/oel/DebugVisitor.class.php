<?php

  $package= 'oel';

  uses(
    'oel.iVisitor',
    'oel.iAcceptor'
  );

  class oel·DebugVisitor extends Object implements oel·iVisitor {

    /**
     * dump an instruction
     *
     * @param   oel.iAcceptor acceptor
     */
    public function visit(oel·iAcceptor $acceptor) {
      foreach ($acceptor->preInstructions as $instruction) $instruction->accept($this);
      if (!$acceptor->is_root) {
        printf("op: %s(%s)\n", $acceptor->name, $this->paramString($acceptor->config));
      }
    }

    /**
     * helper to dump param strings from config array
     *
     * @param   array config
     * @return  string
     */
    final protected function paramString(Array $config) {
      $result= array();
      foreach ($config as $conf) {
        switch (gettype($conf)) {
          case "integer": $result[]= sprintf("%s(%u)", gettype($conf), $conf); break;
          case "double":  $result[]= sprintf("%s(%f)", gettype($conf), $conf); break;
          case "string":  $result[]= sprintf("%s(\"%s\")", gettype($conf), $conf); break;
          case "array":   $result[]= sprintf("%s(%s)", gettype($conf), $this->paramString($conf)); break;
          case "object":  $result[]= sprintf("%s(%s)", gettype($conf), $this->paramString($conf)); break;
          default:        $result[]= "unknown type";
        }
      }
      return implode(', ', $result);
    }
  }

?>
