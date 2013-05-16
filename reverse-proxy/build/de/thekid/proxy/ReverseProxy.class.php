<?php uses('scriptlet.HttpScriptlet', 'peer.http.HttpConnection', 'util.log.LogCategory', 'util.log.Logger', 'util.log.ColoredConsoleAppender', 'scriptlet.Request', 'peer.URL', 'scriptlet.Response', 'peer.http.HttpRequest', 'peer.http.HttpConstants');

;
;
;

 class ReverseProxy extends HttpScriptlet{
protected $conn;
protected $cat;



public function __construct($base){if (NULL !== $base && !is("string", $base)) throw new IllegalArgumentException("Argument 1 passed to ".__METHOD__." must be of string, ".xp::typeOf($base)." given");$this->conn=new HttpConnection($base);$this->setTrace(Logger::getInstance()->getCategory()->withAppender(new ColoredConsoleAppender()));}


public function handleMethod($req){
return 'doRequest';}


public function setTrace($cat){
$this->cat=$cat;}


protected function transformURI($uri){






$url=new URL($uri);if ($this->conn->getUrl()->getHost() === $url->getHost()) {$url->setHost('localhost');$url->setPort(8080);};return $url->getURL();;}


public function doRequest($req,$res){
$proxied=$this->conn->create(new HttpRequest());


$proxied->setTarget($req->getURL()->getPath());
$proxied->setMethod($req->getMethod());
$proxied->addHeaders($req->getHeaders());
$proxied->setParameters($req->getQueryString());


$host=$this->conn->getUrl()->getHost();
if (NULL !== ($port=$this->conn->getUrl()->getPort())) {
$host.=':'.$port;};

$proxied->setHeader('Host',$host);
$proxied->setHeader('Connection','close');


$this->cat&&$this->cat->info('>>>',$proxied->getRequestString());
try {
$answer=$this->conn->send($proxied);} catch(Throwable $t) {

$this->cat&&$this->cat->warn('***',$t);
$res->setStatus(HttpConstants::STATUS_BAD_GATEWAY);
$res->setContent('<h1>Proxy error</h1><pre>'.$t->compoundMessage().'</pre>');
return;};



$this->cat&&$this->cat->info('<<<',$answer);
$res->setStatus($answer->statusCode());
foreach ($answer->headers() as $header => $value) {
if ('Location' === $header) {
$res->setHeader($this->transformURI($value[0]));}else {

$res->setHeader($header,$value[0]);};};


do {
$bytes=$answer->readData();
$this->cat&&$this->cat->info('<<<',new Bytes((string)$bytes));
$res->write($bytes);} while (
$bytes);;}}xp::$registry['class.ReverseProxy']= 'de.thekid.proxy.ReverseProxy';xp::$registry['details.de.thekid.proxy.ReverseProxy']= array (
  0 => 
  array (
    'conn' => 
    array (
      5 => 
      array (
        'type' => 'peer.http.HttpConnection',
      ),
    ),
    'cat' => 
    array (
      5 => 
      array (
        'type' => 'util.log.LogCategory',
      ),
    ),
  ),
  1 => 
  array (
    '__construct' => 
    array (
      1 => 
      array (
        0 => 'string',
      ),
      2 => NULL,
      3 => 
      array (
      ),
      4 => '
 ',
      5 => 
      array (
      ),
      6 => 
      array (
      ),
    ),
    'handleMethod' => 
    array (
      1 => 
      array (
        0 => 'scriptlet.Request',
      ),
      2 => 'string',
      3 => 
      array (
      ),
      4 => NULL,
      5 => 
      array (
      ),
      6 => 
      array (
      ),
    ),
    'setTrace' => 
    array (
      1 => 
      array (
        0 => 'util.log.LogCategory',
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => NULL,
      5 => 
      array (
      ),
      6 => 
      array (
      ),
    ),
    'transformURI' => 
    array (
      1 => 
      array (
        0 => 'string',
      ),
      2 => 'string',
      3 => 
      array (
      ),
      4 => NULL,
      5 => 
      array (
      ),
      6 => 
      array (
      ),
    ),
    'doRequest' => 
    array (
      1 => 
      array (
        0 => 'scriptlet.Request',
        1 => 'scriptlet.Response',
      ),
      2 => 'bool',
      3 => 
      array (
      ),
      4 => NULL,
      5 => 
      array (
      ),
      6 => 
      array (
      ),
    ),
  ),
  'class' => 
  array (
    5 => 
    array (
    ),
    4 => NULL,
  ),
);
?>
