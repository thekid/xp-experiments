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
    protected $type= '';
    protected $headers= array();
    protected $input= NULL;

    /**
     * Creates a new response
     *
     * @param   int status
     * @param   string type
     * @param   [:string[]] headers
     * @param   io.streams.InputStream input
     */
    public function __construct($status, $type, $headers, $input) {
      $this->status= $status;
      $this->type= $type;
      $this->headers= $headers;
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
     * Get content
     *
     * @return  var
     */
    public function content() {
      switch ($this->type) {
        case 'application/json':
          return JsonFactory::create()->decode(Streams::readAll($this->input));

        default:
          throw new IllegalArgumentException('Unknown content type "'.$this->type.'"');
      }
    }
  }
?>
