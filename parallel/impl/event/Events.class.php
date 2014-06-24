<?php namespace impl\event;

class Events extends \lang\Object {
  protected $base, $events;

  public function __construct() {
    $this->base= new \EventBase();
    $this->events= [];
  }

  public function setTimeout($closure, $ms) {
    $id= sizeof($this->events);
    $event= \Event::timer(
      $this->base,
      function() use($closure, $id) { $closure($this, $id); }
    );
    $event->add($ms / 1000);
    $this->events[$id]= $event;
  }

  public function poll($fd, $flags, $closure) {
    if (!is_resource($fd)) throw new \lang\IllegalArgumentException('Not a file descriptor: '.$fd);

    $id= sizeof($this->events);
    $event= new \Event(
      $this->base,
      $fd,
      $flags,
      function($fd, $flags, $args) use($closure, $id) { $closure($this, $id, $fd, $flags); }
    );
    $event->add();
    $this->events[$id]= $event;
  }

  public function cancel($id) {
    $this->events[$id]->del();
  }

  public function loop() {
    return $this->base->loop();
  }

  public function __destruct() {
    foreach ($this->events as $event) {
      $event->free();
    }
    $this->base->stop();
  }

  public function toString() {
    return $this->getClassName().'(supported: '.implode(', ', \Event::getSupportedMethods()).')';
  }
}
