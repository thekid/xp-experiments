<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.Streams', 'webservices.json.JsonFactory');

  /**
   * A REST response
   *
   */
  class RestResponse extends Object {
    protected $status= -1;
    protected $content= '';
    protected $headers= array();
    protected $type= NULL;
    protected $input= NULL;

    /**
     * Creates a new response
     *
     * @param   int status
     * @param   string content
     * @param   [:string[]] headers
     * @param   lang.Type type
     * @param   io.streams.InputStream input
     */
    public function __construct($status, $content, $headers, $type, $input) {
      $this->status= $status;
      $this->content= $content;
      $this->headers= $headers;
      $this->type= $type;
      $this->input= $input;
    }

    /**
     * Get status code
     *
     * @return  int
     */
    public function status() {
      return $this->status;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   string name
     * @return  string[] names
     */
    protected function variantsOf($name) {
      $variants= array($name);
      $chunks= explode('_', $name);
      if (sizeof($chunks) > 1) {
        $variants[]= array_shift($chunks).implode(array_map('ucfirst', $chunks));
      }
      return $variants;
    }
    
    /**
     * Convert data based on type
     *
     * @param   [:var] data
     * @return  var
     */
    public function convert($data) {
      if (NULL === $this->type) {                     // No conversion
        return $data;
      } else if ($this->type instanceof XPClass) {    // Conversion to a class
        $return= $this->type->newInstance();
        foreach ($data as $name => $value) {
          foreach ($this->variantsOf($name) as $variant) {
            if ($this->type->hasField($variant)) {
              $field= $this->type->getField($variant);
              if ($field->getModifiers() & MODIFIER_PUBLIC) {
                $field->set($return, $value);
                continue 2;
              }
            }
            if ($this->type->hasMethod('set'.$variant)) {
              $method= $this->type->getMethod('set'.$variant);
              if ($method->getModifiers() & MODIFIER_PUBLIC) {
                $method->invoke($return, array($value));
                continue 2;
              }
            }
          }
        }
        return $return;
      } else {
        throw new FormatException('Cannot convert to '.$this->type->toString());
      }
    }
    
    /**
     * Get content
     *
     * @return  var
     */
    public function content() {
      switch ($this->content) {
        case 'application/json':
          return $this->convert(JsonFactory::create()->decode(Streams::readAll($this->input)));

        default:
          throw new IllegalArgumentException('Unknown content type "'.$this->type.'"');
      }
    }
  }
?>
