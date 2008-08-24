<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses(
    'util.cmd.Command',
    'entities.Person',
    'persistence.EntityManager'
  );

  /**
   *
   *
   * @purpose  purpose
   */
  class FindPerson extends Command {
  
    /**
     * Set database DSN
     *
     * @param   string dsn
     */
    #[@arg]
    public function setConnection($dsn) {
      ConnectionManager::getInstance()->register(DriverManager::getConnection($dsn), 'people');
    }


    /**
     * Main runner method
     *
     */
    public function run() {
      $em= new EntityManager();
      $p= $em->find(XPClass::forName('entities.Person'), 1);
      $this->out->writeLine($p->isActive() ? 'active' : 'inactive', ': ', $p);
    }
  }
?>
