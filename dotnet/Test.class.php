<?php
  class Test extends Object {

    public static function main(array $args) {
      try {
        $bind= new DOTNET('XP.Bind, Version=1.0.0.0, Culture=neutral, PublicKeyToken=7c57868ceecd5021', 'XP.Bind');
        $type= $bind->assembly('ImageProcessor.dll')->instance('XP.ImageProcessor');
        Console::writeLine($type->getName());
      } catch (Exception $e) {
        Console::$err->writeLine('*** ', $e->getMessage());
      }
    }
  }
?>
