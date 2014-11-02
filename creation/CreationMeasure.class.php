<?php

class CreationMeasure extends \util\profiling\Measurable {

  protected function test($creation) {
    return $creation->id(1)->name('Test')->create();
  }

  #[@measure]
  public function reflectively() {
    return $this->test(Creation::of('Employee'));
  }

  #[@measure]
  public function dynamically() {
    return $this->test(DynamicCreation::of('Employee'));
  }

  #[@measure]
  public function withfunction() {
    return $this->test(new CreationWithFunction(function($prop) {
      return new Employee($prop['id'], $prop['name']);
    }));
  }
}