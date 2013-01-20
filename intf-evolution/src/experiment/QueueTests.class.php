<?php
  namespace experiment;

  class QueueTests extends \unittest\TestCase {

    #[@test]
    public function get() {
      $this->assertEquals(1, create(new MemoryQueue([1]))->get());
    }

    #[@test]
    public function get_on_empty() {
      $this->assertNull(create(new MemoryQueue([]))->get());
    }

    #[@test]
    public function clear() {
      $q= new MemoryQueue([1, 2, 3]);
      $q->clear();
      $this->assertNull($q->get());
    }
  }
?>