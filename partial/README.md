Partial classes experiment
==========================
Implemented with PHP 5.4 traits the following forms a class named
`de.thekid.db.News`:

src/main/php/de/thekid/db/News0.partial.php
```php
<?php
  trait News0 {

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<#6100>';
    }
  }
?>
```

src/main/php/de/thekid/db/News1.partial.php
```php
<?php

<?php
  trait News1 {

    /**
     * Fetches an instance of this object from the underlying persistence
     * layer by a given unique identifier. Returns NULL if nothing is found.
     *
     * @param   int id
     * @return  de.thekid.db.News
     */
    public static function getById($id) {
      return new self();
    }
  }
?>
```


Prerequisites
-------------
Use the `class-source` branch from my xp-framework fork.

See https://github.com/thekid/xp-framework/tree/class-source

Testing
-------

```sh
$ export USE_XP='../../xp.thekid/core/;../../xp.thekid/tools/' 
$ xp -e 'uses("de.thekid.db.News"); Console::writeLine(News::getById(6100));'
de.thekid.db.News<#6100>
```
