<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.log.Layout');

  /**
   * Pattern layout
   *
   * Format string
   * -------------
   * The format string consists of format tokens preceded by a percent
   * sign (%) and any other character. The following format tokens are 
   * supported:
   * <ul>
   *   <li>%m - Message</li>
   *   <li>%c - Category name</li>
   *   <li>%l - Log level - lowercase</li>
   *   <li>%L - Log level - uppercase</li>
   *   <li>%t - Time in HH:MM:SS</li>
   *   <li>%p - Process ID</li>
   *   <li>%% - A literal percent sign (%)</li>
   * </li>
   *
   * @test    xp://test.PatternLayoutTest
   */
  class PatternLayout extends util·log·Layout {
    protected $format= array();
  
    /**
     * Creates a new pattern layout
     *
     * @param   string format
     */
    public function __construct($format) {
      for ($i= 0, $s= strlen($format); $i < $s; $i++) {
        if ('%' === $format{$i}) {
          $i++;
          switch ($format{$i}) {
            case '%': {   // Literal percent
              $this->format[]= '%'; 
              break;
            }
            default: {    // Any other character - verify it's supported
              if (!strspn($format{$i}, 'mclLtp')) {
                throw new IllegalArgumentException('Unknown format token "'.$format{$i}.'"');
              }
              $this->format[]= '%'.$format{$i};
            }
          }
        } else {
          $this->format[]= $format{$i};
        }
      }
    }

    /**
     * Formats a logging event according to this layout
     *
     * @param   util.log.LoggingEvent event
     * @return  string
     */
    public function format(LoggingEvent $event) {
      $out= '';
      foreach ($this->format as $token) {
        switch ($token) {
          case '%m': $out.= $event->getMessage(); break;
          case '%t': $out.= gmdate('H:i:s', $event->getTimestamp()); break;
          case '%c': $out.= $event->getCategory()->identifier; break;
          case '%l': $out.= $event->getCategory()->_indicators[$event->getLevel()]; break;
          case '%L': $out.= strtoupper($event->getCategory()->_indicators[$event->getLevel()]); break;
          case '%p': $out.= $event->getProcessId(); break;
          default: $out.= $token;
        }
      }
      return $out;
    }
  }
?>
