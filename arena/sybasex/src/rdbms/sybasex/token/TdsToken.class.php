  <?php
  uses('util.log.Traceable');
  
  $package= 'rdbms.sybasex.token';
  abstract class rdbms·sybasex·token·TdsToken extends Object implements Traceable {
    protected
      $data   = NULL;

    protected
      $cat    = NULL;
      
    public function setStream(InputStream $data) {
      $this->data= $data;
    }
    
    protected function readSmallInt() {
      $short= unpack('vint', $this->data->read(2));
      return $short['int'];
    }

    public abstract function handle();
    
    /**
     * Set log facility
     *
     * @param   util.log.LogCategory cat
     */
    public function setTrace($cat) {
      $this->cat= $cat;
    }
  }

?>