<?php
  class Enumerable extends Object {

    public static function each(Traversable $self, Closure $closure) {
      foreach ($self as $element) {
        $closure($element);
      }
    }
  
    public static function find(Traversable $self, Closure $closure) {
      foreach ($self as $element) {
        if ($closure($element)) return $element;
      }
      return NULL;
    }

    public static function findAll(Traversable $self, Closure $closure) {
      $r= new ArrayList();
      foreach ($self as $element) {
        if ($closure($element)) $r->values[]= $element;
      }
      return $r;
    }

    public static function get(Traversable $self, Closure $closure) {
      foreach ($self as $element) {
        if ($closure($element)) return $element;
      }
      throw new UnderflowException('No element found');
    }

    public static function getAll(Traversable $self, Closure $closure) {
      $r= new ArrayList();
      foreach ($self as $element) {
        if ($closure($element)) $r->values[]= $element;
      }
      if (0 == sizeof($r->values)) {
         throw new UnderflowException('No element found');
      }
      return $r;
    }

    public static function collect(Traversable $self, Closure $closure) {
      $r= new ArrayList();
      foreach ($self as $element) {
        $r->values[]= $closure($element);
      }
      return $r;
    }

    public static function size(Traversable $self) {
      $s= 0;
      foreach ($self as $element) $s++;
      return $s;
    }

    public static function partition(Traversable $self, Closure $closure) {
      $t= new ArrayList();
      $f= new ArrayList();
      $r= new ArrayList($t, $f);
      foreach ($self as $element) {
        if ($closure($element)) $t->values[]= $element; else $f->values[]= $element;
      }
      return $r;
    }
  }
?>
