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

### Defaults
For each interface, we define its default methods inside a trait:

```php
interface Queue {
  function get();
  function clear();
}

trait __QueueDefaults {
  public function clear() {
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

### Replace
We define traits instead of interfaces:

```php
trait Queue {
  public abstract function get();

  public function clear() {
    while (NULL !== $this->get()) { }
  }
}

class MemoryQueue extends Object {
  use Queue; 

  // ...
}
```

Now this does exactly what we want: First of all, it is esured any 
implementing class will actually have a `get()` method; failure to do
so will result in a compile-time error. Second, the `clear()` method
may be implement, but third: doesn't have to (the default as defined 
by the trait is then used).

Downside: This is not `instanceof` compatible. While we could trick
around this in XP's `is()`, `cast()` and `newinstance()` core functionality
as well as inside reflection, and even for argument passing, we can't 
"trick" `instanceof`.