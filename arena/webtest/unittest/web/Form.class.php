<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'unittest.web';

  uses('unittest.web.Field', 'unittest.web.Fields');

  /**
   * Represents a HTML form
   *
   * @see      xp://unittest.web.WebTestCase#getForm
   * @purpose  Value object
   */
  class unittest·web·Form extends Object {
    protected
      $test   = NULL,
      $node   = NULL,
      $fields = NULL;
    
    /**
     * Constructor
     *
     * @param   unittest.web.WebTestCase case
     * @param   php.DOMNode node
     */
    public function __construct(WebTestCase $test, DOMNode $node) {
      $this->test= $test;
      $this->node= $node;
    }
    
    /**
     * Get form action
     *
     * @return  string
     */
    public function getAction() {
      $action= $this->node->getAttribute('action');
      return $action ? $action : $this->test->base;
    }

    /**
     * Get fields. Lazy / Cached.
     *
     * @return  unittest.web.Field[]
     */
    public function getFields() {
      if (NULL === $this->fields) {
        $this->fields= $this->test->getXPath()->query('.//input|.//textarea|.//select', $this->node);
      }

      $fields= array();
      foreach ($this->fields as $element) {
        $fields[]= unittest·web·Fields::forTag($element->tagName)->newInstance($this, $element);
      }
      return $fields;
    }
    
    /**
     * Creates a string representation
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(action= '.$this->getAction().')@'.xp::stringOf($this->getFields());
    }

    /**
     * Submit the form
     *
     */
    public function submit() {
      $this->test->navigateTo($this->getAction());
    }
  }
?>
