<?php

  class Dog extends Exception {}
  class Cat extends Exception {}
  class Elephant extends Exception {}
  class Banana extends Exception {}

  $e= new Dog("Flying Dog");
  try {
    throw $e;
  } catch (Dog $d) {
    var_dump(
      "Phaat, a flying Dog! What's your name dog?",
      $d->getMessage()
    );
  } catch (Cat $c) {
    var_dump(
      "MMMMMMIIIIOOOUUUUU",
      $c->getMessage()
    );
  } catch (Elephant $e) {
    var_dump(
      "Ey elephant, don't you know elephanths can't fly",
      $e->getMessage()
    );
  } catch (Banana $b) {
    var_dump(
      "Ey, who is throwing bananas at me?",
      $b->getMessage()
    );
  }

  $e= new Cat("LOL, I iz in ur sourz code");
  try {
    throw $e;
  } catch (Dog $d) {
    var_dump(
      "Phaat, a flying Dog! What's your name dog?",
      $d->getMessage()
    );
  } catch (Cat $c) {
    var_dump(
      "MMMMMMIIIIOOOUUUUU",
      $c->getMessage()
    );
  } catch (Elephant $e) {
    var_dump(
      "Ey elephant, don't you know elephanths can't fly",
      $e->getMessage()
    );
  } catch (Banana $b) {
    var_dump(
      "Ey, who is throwing bananas at me?",
      $b->getMessage()
    );
  }

  $e= new Elephant("hm?");
  try {
    throw $e;
  } catch (Dog $d) {
    var_dump(
      "Phaat, a flying Dog! What's your name dog?",
      $d->getMessage()
    );
  } catch (Cat $c) {
    var_dump(
      "MMMMMMIIIIOOOUUUUU",
      $c->getMessage()
    );
  } catch (Elephant $e) {
    var_dump(
      "Ey elephant, don't you know elephanths can't fly",
      $e->getMessage()
    );
  } catch (Banana $b) {
    var_dump(
      "Ey, who is throwing bananas at me?",
      $b->getMessage()
    );
  }

  $e= new Banana("*slap*");
  try {
    throw $e;
  } catch (Dog $d) {
    var_dump(
      "Phaat, a flying Dog! What's your name dog?",
      $d->getMessage()
    );
  } catch (Cat $c) {
    var_dump(
      "MMMMMMIIIIOOOUUUUU",
      $c->getMessage()
    );
  } catch (Elephant $e) {
    var_dump(
      "Ey elephant, don't you know elephanths can't fly",
      $e->getMessage()
    );
  } catch (Banana $b) {
    var_dump(
      "Ey, who is throwing bananas at me?",
      $b->getMessage()
    );
  }

?>
