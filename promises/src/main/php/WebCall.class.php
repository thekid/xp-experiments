<?php
  declare(ticks=1);
  uses('lang.Runnable', 'peer.http.HttpConnection');
  
  class WebCall extends Object {
    public static $done= FALSE;
  
    static function __static() {
      ClassLoader::defineClass('HttpResponsePromise', 'lang.Object', array(), '{
        public $socket= NULL;
        public $then= NULL;
        
        public function __construct($socket) {
          $this->socket= $socket;
        }
        
        public function when() {
          return $this->socket->canRead(0);
        }
        
        public function then() {
          $this->then->run(new HttpResponse(new SocketInputStream($this->socket)));
        }
      }');
      
      $async= ClassLoader::defineClass('AsyncSocketHttpTransport', 'peer.http.SocketHttpTransport', array(), '{
        public function send(HttpRequest $request, $timeout= 60, $connecttimeout= 2.0) {
          $s= $this->socket;
          $s->isConnected() && $s->close();
          $s->setTimeout($timeout);
          $s->connect($connecttimeout);
          $s->write($request->getRequestString());

          return new HttpResponsePromise($s);
        }
      }');
      
      HttpTransport::register('async', $async);
    }
    
    public static function tick($promise= NULL) {
      static $promises= array();
      static $pid= 0;
      
      if ($promise) {
        $promises[$pid++]= $promise;
        return;
      }

      foreach ($promises as $i => $promise) {
        if ($promise->when()) {
          $promise->then();
          unset($promises[$i]);
        }
      }
    }
  
    protected static function get($url, Object $then) {
      $c= new HttpConnection(str_replace('http://', 'async://', $url));
      Console::writeLine($c);
      $promise= $c->get();
      $promise->then= $then;
      self::tick($promise);
      register_tick_function('WebCall::tick');
    }
    
    public static function main($args) {
      $url= $args[0] ?: 'http://xp-framework.net/downloads/slow.php';
      
      self::get($url, newinstance('lang.Object', array(), '{
        public function run($response) {
          WebCall::$done= TRUE;
          Console::writeLine("Completed: ", $response);
        }
      }'));

      Console::write('Loading: ');
      do {
        Console::write('.');
        usleep(500 * 1000);
      } while (!self::$done);
      Console::writeLine();
    }
  }
?>
