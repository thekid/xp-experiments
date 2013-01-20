<?php
  namespace experiment;

  class QueueTests extends \unittest\TestCase {
    protected $impl;

    public function __construct($name, $impl) {
      parent::__construct($name);
      $this->impl= $this->getClass()->getPackage()->loadClass($impl);
    }

    #[@test]
    public function get() {
      $this->assertEquals(1, $this->impl->newInstance([1])->get());
    }

    #[@test]
    public function get_on_empty() {
      $this->assertNull($this->impl->newInstance([])->get());
    }

    #[@test]
    public function clear() {
      $q= $this->impl->newInstance([1, 2, 3]);
      $q->clear();
      $this->assertNull($q->get());
    }
  }
?>