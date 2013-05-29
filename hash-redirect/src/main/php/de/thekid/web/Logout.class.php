<?php namespace de\thekid\web;

class Logout extends \scriptlet\HttpScriptlet {

  /**
   * Handles GET request
   *
   * @param  scriptlet.Request $request
   * @param  scriptlet.Response $response
   */
  public function doGet($request, $response) {
    $response->setCookie(new \scriptlet\Cookie('psessionid', null));
    $response->write('
      <html>
        <head><title>Logout</title></head>
        <body>
          <h1>Log out successful.</h1>
          <p>
            <a href="http://localhost:8080/base/#/wall/bit-dev/posts/89237">Log back in again</a>
          </p>
        </body>
      </html>'
    );
  }
}