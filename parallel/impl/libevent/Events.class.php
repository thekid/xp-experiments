<?php namespace impl\libevent;

class Events extends \lang\Object {
  protected $base;

  public function __construct() {
    $this->base= event_base_new();
  }

  public function setTimeout($closure, $ms) {
    $event= event_new();
    event_timer_set(
      $event,
      function($_, $m, $args) use($closure) { $closure($args[0], $args[1]); },
      [$this, $event]
    );
    event_base_set($event, $this->base);
    event_add($event, $ms * 1000);
  }

  public function poll($fd, $flags, $closure) {
    if (!is_resource($fd)) throw new \lang\IllegalArgumentException('Not a file descriptor: '.$fd);

    $event= event_new();
    event_set(
      $event,
      $fd,
      $flags,
      function($fd, $flags, $args) use($closure) { $closure($args[0], $args[1], $fd, $flags); },
      [$this, $event]
    );
    event_base_set($event, $this->base);
    event_add($event);
  }

  public function cancel($event) {
    event_del($event);
  }

  public function loop() {
    return event_base_loop($this->base);
  }

  public function __destruct() {
    event_base_free($this->base);
  }

  public function toString() {
    return $this->getClassName().'('.get_resource_type($this->base).' res#'.(int)$this->base.')';
  }
}
