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
  function clear();   // This is the new method
}

class MemoryQueue extends Object implements Queue { ... }    // Fatal: MemoryQueue does not implement clear()!
```

An implementation of this method could be provided by the interface itself 
though, using only previously implemented methods:

```php
function clear() {
  while (NULL !== $this->get()) {
    // iteratively remove elements
  }
}
```
So in essence, we'd wish we were able to write something like the following:

```php
interface Queue {
  function get();
  function clear() default {
    while (NULL !== $this->get()) { }
  }
}
```

Traits
------
Entering the stage: PHP Traits - "horizontal reuse", or: "compiler-assisted 
copy&paste", two phrases used during its motivation. 
See [the PHP Traits RFC](https://wiki.php.net/rfc/horizontalreuse) for details.

Back to our example: To ensure any implementing class also implements our 
new `clear()` method, we could simply copy&paste the default implementation
to any implementing class (using a combination of `find`, `grep` and `sed`
for example). Or we let ourselves be assisted by PHP!

For each interface, we define its default methods inside a trait:

```php
interface Queue {
  function get();
  function clear();
}

trait __QueueDefaults {
  function clear() default {
    while (NULL !== $this->get()) { }
  }
}
```

Unfortunately, the PHP compiler doesn't know where to paste the source to,
so we'll have to tell it:

```php
class MemoryQueue extends Object implements Queue {
  use __QueueDefaults; 

  // ...
}
```

We still have to change every implementation, though! The only gain we now 
have is that we can change the default implementation at a single place.
If we always keep in mind interface may need to be extended at some point
in the future and always add the traits as well as the `use` statement,
we don't have to think about this, but then again forgetting to do so will
only have an impact later on. And programmers are usually not that disciplined.