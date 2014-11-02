<?php

class EmployeeTest extends \unittest\TestCase {

  #[@test]
  public function can_create() {
    new Employee(6100, 'The dude');
  }

  #[@test]
  public function accessors() {
    $created= new Employee(6100, 'The dude');
    $this->assertEquals([6100, 'The dude'], [$created->id(), $created->name()]);
  }

  #[@test]
  public function creation() {
    $created= Employee::with()
      ->id(6100)
      ->name('The dude')
      ->create()
    ;
    $this->assertEquals([6100, 'The dude'], [$created->id(), $created->name()]);
  }
}