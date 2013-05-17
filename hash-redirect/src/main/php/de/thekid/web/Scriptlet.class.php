<?php namespace de\thekid\web;

class Scriptlet extends \scriptlet\HttpScriptlet {

  /**
   * Handles GET request
   *
   * @param  scriptlet.Request $request
   * @param  scriptlet.Response $response
   */
  public function doGet($request, $response) {
    $response->write('
      <html>
        <head><title>Welcome</title></head>
        <body>
          <h1>Welcome</h1>
          <p>The fragment: <script language="JavaScript">document.write(document.location.hash);</script></p>
        </body>
      </html>
    ');
  }
}