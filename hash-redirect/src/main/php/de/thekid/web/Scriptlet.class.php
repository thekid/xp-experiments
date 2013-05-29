<?php namespace de\thekid\web;

class Scriptlet extends \scriptlet\HttpScriptlet {

  /**
   * Reads session from cookie
   *
   * @param  scriptlet.Request $request
   * @return bool
   */
  public function handleMethod($request) {
    if ($request->hasCookie('psessionid')) {

      // FIXME: HttpScriptletURL doesn't have access to cookie values. We'll 
      // just pretend it was passed as parameter for the moment, but the correct
      // way would be to change this in the base class, refactoring it up to an
      // exchangeable session handling mechanism.
      $request->params['psessionid']= $request->getCookie('psessionid')->getValue();
    }
    return parent::handleMethod($request);
  }

  /**
   * Requires session
   *
   * @param  scriptlet.Request $request
   * @return bool
   */
  public function needsSession($request) {
    return true;
  }

  /**
   * Handles creating sessions
   *
   * @param  scriptlet.Request $request
   * @param  scriptlet.Response $response
   */
  public function doCreateSession($request, $response) {
    $response->setCookie(new \scriptlet\Cookie('psessionid', $request->getSession()->getId()));
    $response->write('
      <html>
        <head><title>Redirect</title></head>
        <body>
          <script language="JavaScript">document.location.replace(document.location.href.replace("#", "-"));</script>
        </body>
      </html>'
    );
    return false;
  }

  /**
   * Handles GET request
   *
   * @param  scriptlet.Request $request
   * @param  scriptlet.Response $response
   */
  public function doGet($request, $response) {
    $response->write(sprintf('
      <html>
        <head><title>Welcome</title></head>
        <body>
          <h1>Welcome</h1>
          <ul>
            <li>The fragment: <script language="JavaScript">document.write(document.location.hash);</script></li>
            <li>Your session: %s</li>
          </ul>
          <p><a href="/base/logout">Logout</a></p>
        </body>
      </html>',
      $request->getSession()->getId()
    ));
  }
}