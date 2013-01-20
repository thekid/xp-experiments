Interface evolution
==
Imagine the following interface and implementation:

```php
interface Queue {
  function get();
}

class MemoryQueue extends Object implements Queue {
  protected $messages= [];

  public function __construct($messages) { 
    $this->messages= $messages; 
  }

  public function get() { 
    return array_shift($this->messages); 
  }
}

```

Now if we would to extend this interface and add a `clear()` method, we would
start breaking all existing implementations:

```php
interface Queue {
  function get();
  function clear();
}

class MemoryQueue extends Object implements Queue { ... }    // Fatal: MemoryQueue does not implement clear()!
```

An implementation of this method could be provided by the interface itself 
though, using only previously implemented methods:

```php
interface Queue {
  function get();
  function clear() default {
    while (NULL !== $this->get()) {
      // iterate
    }
  }
}
```