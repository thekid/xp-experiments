<?php

use util\profiling\Timer;
use lang\XPClass;
use lang\IllegalArgumentException;
use lang\Enum;

/**
 * Profile enums. See http://xp-framework.info/xml/xp.en_US/news/view?207
 * for details.
 */
class Profile extends \util\cmd\Command {
  protected
    $fixture = null,
    $times   = 0;

  /**
   * Set what to profile. There are two possible ways:
   * 
   * - ClassName::MemberName - Only this member will be run
   * - ClassName - All members will be run in order of declaration
   *
   * @param   string name
   */
  #[@arg(position= 0)]
  public function setFixture($name) {
    $r= sscanf($name, '%[^:]::%s', $classname, $member);
    if (!$classname) {
      throw new IllegalArgumentException('Could not parse "'.$name.'"');
    }

    // Load class and ensure it's a profileable enum
    $class= XPClass::forName($classname);
    if (!$class->isEnum() || !$class->isSubclassOf('Profileable')) {
      throw new IllegalArgumentException($class->toString().' is not a profileable enum');
    }

    $this->out->writeLine('== Profiling ', $class, ' ==');
    if ($member) {
      $this->fixture= array(Enum::valueOf($class, $member));
    } else {
      $this->fixture= Enum::valuesOf($class);
    }
  }

  /**
   * Set how many times to run
   *
   * @param   int times default 100000
   */
  #[@arg]
  public function setTimes($times= 100000) {
    $this->times= (int)$times;
  }

  /**
   * Main runner method
   */
  public function run() {
    $t= new Timer();

    foreach ($this->fixture as $member) {
      try {
        $t->start();
        $member->run($this->times);
        $t->stop();
        $result= sprintf(
          '%.3f seconds for %d calls (%.0f / second)',
          $t->elapsedTime(),
          $this->times,
          $this->times * (1/ $t->elapsedTime())
        );
      } catch (Throwable $e) {
        $result= '*** '.$e->getMessage();
      }

      $this->out->writeLine($member->name(), ': ' , $result);
    }
    $this->out->writeLinef(
      '== Memory used: %.3f kB / peak: %.3f kB ==',
      memory_get_usage() / 1024,
      memory_get_peak_usage() / 1024
    );
  }
}
