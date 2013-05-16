<?php
  abstract class Performance extends \lang\Enum {
    public static $GENERATOR, $ARRAY;

    static function __static() {
      self::$GENERATOR= newinstance(__CLASS__, array(1, 'GENERATOR'), '{
        static function __static() { }
        protected function methodsWith(XPClass $self, $annotation) {
          $name= substr($annotation, 1);
          foreach ($self->getMethods() as $method) {
            if ($method->hasAnnotation($name)) yield $method;
          }
        }        
      }');
      self::$ARRAY= newinstance(__CLASS__, array(2, 'ARRAY'), '{
        static function __static() { }
        protected function methodsWith(XPClass $self, $annotation) {
          $name= substr($annotation, 1);
          $r= array();
          foreach ($self->getMethods() as $method) {
            if ($method->hasAnnotation($name)) $r[]= $method;
          }
          return $r;
        }        
      }');
    }

    public static function main(array $args) {
      $instance= \lang\Enum::valueOf(new XPClass(__CLASS__), $args[0]);
      $class= XPClass::forName($args[1]);

      // Debug
      Console::write('Using ', $instance, '(', $class->getName(), '): [');
      $list= array();
      foreach ($instance->methodsWith($class, '@test') as $m) {
        $list[]= $m->getName();
      }
      Console::writeLine(implode(', ', $list), ']= ', sizeof($list));      

      // Run
      $t= new \util\profiling\Timer();
      $t->start();
      for ($i= 0; $i < 10000; $i++) {
        foreach ($instance->methodsWith($class, '@test') as $m) {
          // NOOP
        }
      }
      $t->stop();
      $rt= \lang\Runtime::getInstance();
      Console::writeLinef('%d iterations in %.3f seconds', $i, $t->elapsedTime());
      Console::writeLinef('%.3f kB memory used, %.3f kb peak', $rt->memoryUsage() / 1024, $rt->peakMemoryUsage() / 1024);
    }
  }
?>