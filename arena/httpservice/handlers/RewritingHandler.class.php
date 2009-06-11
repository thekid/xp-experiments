<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('handlers.AbstractUrlHandler');

  /**
   * Rewriting handler
   *
   * @see      HttpProtocol
   * @purpose  Handler for HttpProtocol
   */
  class RewritingHandler extends AbstractUrlHandler {
    protected 
      $pattern     = '',
      $replacmenet = '',
      $delegate    = NULL;

    /**
     * Constructor
     *
     * @param   string docroot document root
     */
    public function __construct($pattern, $replacement, AbstractUrlHandler $delegate) {
      $this->pattern= $pattern;
      $this->replacement= $replacement;
      $this->delegate= $delegate;
    }

    /**
     * Handle a single request
     *
     * @param   string method request method
     * @param   string query query string
     * @param   array<string, string> headers request headers
     * @param   string data post data
     * @param   peer.Socket socket
     */
    public function handleRequest($method, $query, array $headers, $data, Socket $socket) {
      $rewritten= preg_replace(
        array($this->pattern), 
        array($this->replacement), 
        $query
      );
      Console::writeLine($query, ' => ', $rewritten);
      $this->delegate->handleRequest(
        $method, 
        $rewritten, 
        $headers, 
        $data, 
        $socket
      );
    }

    /**
     * Returns a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->pattern.':='.$this->replacement.')@<'.$this->delegate->toString().'>';
    }
  }
?>
