<?php
  namespace experiment\defaults;
  
  interface Queue {
    function get();
    function clear();
  }

  trait __QueueDefaults {
    public function clear() {
      while (NULL !== $this->get()) {
      }
    }
  }
?>