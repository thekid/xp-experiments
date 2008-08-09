<?php
  class Assert {
    public static function exception($class, Closure $block) {
      try {
        $block();
      } catch (Exception $e) {
        if ($e instanceof $class) return;
        throw new UnexpectedValueException('Caught '.get_class($e).' instead of expected '.$class);
      }
      throw new UnexpectedValueException('Expected exception not thrown');
    }
  }
  
  Assert::exception('Exception', function() {
    throw new Exception('Message');
  });
  echo "OK\n";

  try {
    Assert::exception('InvalidArgumentException', function() {
      throw new BadMethodCallException('Message');
    });
  } catch (UnexpectedValueException $expected) {
    echo 'OK, got "', $expected->getMessage(), "\"\n";
  }

  try {
    Assert::exception('Exception', function() {
      return NULL;
    });
  } catch (UnexpectedValueException $expected) {
    echo 'OK, got "', $expected->getMessage(), "\"\n";
  }
?>
