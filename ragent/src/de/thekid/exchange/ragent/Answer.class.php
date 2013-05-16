<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'peer.mail.store.ImapStore',
    'peer.mail.store.NullStoreCache',
    'org.imc.VCalendar'
  );

  /**
   * (Insert class' description here)
   *
   */
  class Answer extends Command {
    protected $store= NULL;
    
    const CONTENT_CLASS_CALENDARMESSAGE = 'urn:content-classes:calendarmessage';
  
    /**
     * Set store DSN
     *
     * @param   string dsn
     */
    #[@arg]
    public function setStore($dsn) {
      $this->store= new ImapStore(new NullStoreCache());
      $this->store->connect($dsn);
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      with ($inbox= $this->store->getFolder('INBOX')); {
        $inbox->open();
        
        while ($msg= $inbox->getMessage()) {
          switch ($msg->getHeader('Content-class')) {
            case self::CONTENT_CLASS_CALENDARMESSAGE: {
              $this->out->writeLine('Message ', $msg);
              while ($part= $msg->getPart()) {
                if ('text/calendar' != $part->getContentType()) continue;
                
                try {
                  $body= new Stream();
                  $body->open(STREAM_MODE_WRITE);
                  $body->write($part->getBody());
                  $body->close();
                  $cal= VCalendar::fromStream($body);
                } catch (XPException $e) {
                  $this->err->writeLine('*** ', $e);
                  break;
                }
                $this->out->writeLine('-> Calendar ', $part->getBody(), ' => ', VCalendar::fromStream($body));
                
                // TODO: Check if we're free & answer this request
                break;
              }
              break;
            }
            
            default: {
              // $this->err->writeLine('*** Unknown: ', $msg);
            }
          }
        }
        
        $inbox->close();
      }
    }
    
    /**
     * Destructor. Ensures connection is closed
     *
     */
    public function __destruct() {
      $this->store && $this->store->close();
    }
  }
?>
