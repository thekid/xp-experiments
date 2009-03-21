<?php
  uses('lang.Primitive');
  
  class TestCreator extends Object {
  
    protected static function writeComment() {
      $args= func_get_args();
      Console::writeLine();
      Console::writeLine('    /**');
      Console::writeLine('     * ', implode('', $args));
      Console::writeLine('     *');
      Console::writeLine('     */');
    }
    
    protected static function valuesFor(Type $t) {
      if ($t instanceof Primitive) {
        switch ($t) {
          case Primitive::$STRING: return array(
            'null'     => 'NULL',
            'empty'    => "''"
          );
          case Primitive::$INTEGER: return array(
            'zero'     => '0'
          );
          case Primitive::$ARRAY: return array(
            'empty'    => 'array()'
          );
          case Primitive::$DOUBLE: return array(
            'zero'     => '0.0'
          );
          case Primitive::$BOOLEAN: return array(
            'true'     => 'TRUE',
            'false'    => 'FALSE'
          );
        }
      } else if ($t instanceof XPClass) {
        if ($t->isInterface()) {
          // Fall through
        } else if ($t->isEnum()) {
          $v= array('null' => 'NULL');
          foreach (Enum::valuesOf($t) as $v) {
            $v[$v->getName()]= $t->getSimpleName().'::$'.$v->getName();
          }
          return $v;
        } else if (!$t->hasConstructor()) {
          return array(
            'null'                    => 'NULL',
            'new'.$t->getSimpleName() => 'new '.$t->getSimpleName().'()'
          );
        } else {
          $c= $t->getConstructor();
          if (0 == $c->numParameters()) {
            return array(
              'null'                    => 'NULL',
              'new'.$t->getSimpleName() => 'new '.$t->getSimpleName().'()'
            );
          }
        }
      }
      return array('null' => 'NULL');
    }
  
    public static function main(array $args) {
      $class= XPClass::forName($args[0]);
      
      Console::writeLine('<?php');
      Console::writeLine('  uses(\'unittest.TestCase\', \'', $class->getName(), '\');');
      Console::writeLine();
      Console::writeLine('  /**');
      Console::writeLine('   * Tests ', $class->getSimpleName(), ' class');
      Console::writeLine('   *');
      Console::writeLine('   * @see xp://', $class->getName());
      Console::writeLine('   */');
      Console::writeLine('  class ', $class->getSimpleName(), 'Test extends TestCase {');
      foreach ($class->getMethods() as $method) {
      
        // Exclude methods not declared in this class and non-public ones.
        if (
          !Modifiers::isPublic($method->getModifiers()) ||
          !$method->getDeclaringClass()->equals($class)
        ) {
          continue;
        }
        
        if (Modifiers::isStatic($method->getModifiers())) {
          $inv= $class->getSimpleName().'::'.$method->getName();
        } else if (!$class->hasConstructor()) {
          $inv= 'create(new '.$class->getSimpleName().'())->'.$method->getName();
        } else if (0 == $class->getConstructor()->numParameters()) {
          $inv= 'create(new '.$class->getSimpleName().'())->'.$method->getName();
        } else {
          continue;
        }
        
        $args= array();
        $m= 0;
        foreach ($method->getParameters() as $i => $param) {
          $values= self::valuesFor($param->getType());
          $args[$i]= array('name' => $param->getName());
          foreach ($values as $name => $value) {
            $args[$i][]= array($name, $value);
          }
          $m= max(sizeof($values), $m);
        }
        Console::$err->writeLine($method->getName(), ': ', $m, ' => ', $args);
        
        // Create permutations
        $i= 0; {

          // Argument #name: For each possibility, create one permutation
          Console::$err->writeLine("\n", '# ', $i, ': ', $args[$i]['name']);
          for ($j= 0; $j < sizeof($args[$i])- 1; $j++) {
            $possibility= $args[$i][$j];
            Console::$err->writeLine('- ', $i, '.', $j, ': ', $args[$i]['name'], '=', $possibility[0]);
            
            $sig= array();
            $sig[ucfirst($possibility[0]).ucfirst($args[$i]['name'])]= $possibility[1];
            for ($k= 1; $k < sizeof($args); $k++) {
              $combination= $args[$k][min($j, sizeof($args[$k])- 2)];
              
              Console::$err->writeLine('- ', $i, '.', $j, '.', $k, ' [', sizeof($args[$k]), ']: &', $args[$k]['name'], '=', $combination[0]);
              $sig[ucfirst($combination[0]).ucfirst($args[$k]['name'])]= $combination[1];
            }
            Console::$err->writeLine('---> ', $sig);

            self::writeComment('Tests ', $class->getSimpleName(), '::', $method->getName());
            Console::writeLine('    #[@test]');
            Console::writeLine('    public function ', $method->getName(), implode('', array_keys($sig)), '() {');
            Console::writeLine('      $this->assertEquals(NULL, ', $inv, '(', implode(', ', $sig), '));');
            Console::writeLine('    }');
          }
        }
      }
      Console::writeLine('  }');
      Console::writeLine('?>');
    }
  }
?>
