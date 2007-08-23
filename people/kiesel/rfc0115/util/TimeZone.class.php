<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.Date');

  /**
   * Time zone
   *
   * <code>
   *   $tz= new TimeZone('Europe/Berlin');
   *   printf("Offset is %s\n", $tz->getOffset());  // -0600
   * </code>
   *
   * @ext       datetime
   * @see       php://datetime
   * @see       php://timezones
   * @see       http://greenwichmeanTime.com/info/Timezone.htm
   * @see       http://www.worldtimezone.com/wtz-names/timezonenames.html
   * @see       http://scienceworld.wolfram.com/astronomy/TimeZone.html
   * @purpose   Time zone calculation
   */
  class TimeZone extends Object {
    protected
      $tz       = NULL;

    /**
     * Constructor.
     *
     * @param   string offset
     * @param   string timezone name default ''
     * @throws  lang.IllegalArgumentException if timezone is unknown
     */
    public function __construct($tz) {
      switch (TRUE) {
        case is_string($tz): {
          if (FALSE === ($this->tz= timezone_open($tz)))
            throw new IllegalArgumentException('Unknown timezone: "'.$tz.'"');
          return;
        }
        
        case is_null($tz): {
          if (FALSE === ($this->tz= timezone_open(date_default_timezone_get())))
            throw new IllegalArgumentException('Unknown timezone: "'.$tz.'"');
          return;
        }
        
        case $tz instanceof DateTimeZone: {
          $this->tz= $tz;
          return;
        }
        
        default: throw new IllegalArgumentException('Invalid timezone identifier given: "'.$tz.'"');
      }
    }
    
    /**
     * Retrieve handle of underlying DateTimeZone object
     *
     * @return  php.DateTimeZone
     */
    public function getHandle() {
      return clone $this->tz;
    }

    /**
     * Gets the name of the timezone
     *
     * @return  string name
     */
    public function getName() {
      return timezone_name_get($this->tz);
    }
    
    /**
     * Returns a TimeZone object by a time zone abbreviation.
     *
     * @param   string abbrev
     * @return  util.TimeZone
     */
    public static function getByName($abbrev) {
      return new self($abbrev);
    }
    
    /**
     * Get a timezone object for the machines local timezone.
     *
     * @return  util.TimeZone
     */
    public static function getLocal() {
      return new self(NULL);
    }

    /**
     * Retrieves the offset of the timezone
     *
     * @return  string offset
     */    
    public function getOffset($date= NULL) {
      $offset= $this->getOffsetInSeconds($date);
      
      $h= intval(abs($offset) / 3600);
      $m= (abs($offset)- ($h * 3600)) / 60;
      
      return sprintf('%s%02d%02d', ($offset < 0 ? '-' : '+'), $h, $m);
    }
    
    /**
     * Retrieve whether the timezone does have DST/non-DST mode
     *
     * @return  bool
     */
    public function hasDst() {
      return (bool)sizeof(timezone_transitions_get($this->tz));
    }

    /**
     * Retrieves the timezone offset to GMT. Because a timezone
     * may have different offsets when its in DST or non-DST mode,
     * a date object must be given which is used to determine whether
     * DST or non-DST offset should be returned.
     *
     * If no date is passed, current time is assumed.
     *
     * @param   util.Date date default NULL
     * @return  int offset
     */    
    public function getOffsetInSeconds($date= NULL) {
      return timezone_offset_get($this->tz, date_create($date instanceof Date ? $date->toString() : 'now'));
    }
    
    /**
     * Converts a date from one timezone to a date of this
     * timezone.
     *
     * @param   util.Date date
     * @param   util.TimeZone tz
     * @return  util.Date
     */
    public function convertDate(Date $date) {
      $handle= clone $date->getHandle();
      date_timezone_set($handle, $this->tz);
      return new Date($handle);
    }

    /**
     * Converts a date in the machines local timezone to a date in this
     * timezone.
     *
     * @param   util.Date date
     * @return  util.Date
     */    
    public function convertLocalDate(Date $date) {
      return $this->convertDate($date, TimeZone::getLocal());
    }
    
    /**
     * Retrieve date of the next timezone transition at the given
     * date for this timezone.
     *
     * @param   util.Date date
     * @return  util.TimeZoneTransition
     */
    public function previousTransition(Date $date) {
      return XPClass::forName('util.TimeZoneTransition')
        ->getMethod('previousTransition')
        ->invoke(NULL, array($this, $date))
      ;
    }
    
    /**
     * Retrieve date of the previous timezone transition at the given
     * date for this timezone.
     *
     * @param   util.Date date
     * @return  util.TimeZoneTransition
     */
    public function nextTransition(Date $date) {
      return XPClass::forName('util.TimeZoneTransition')
        ->getMethod('nextTransition')
        ->invoke(NULL, array($this, $date))
      ;
    }
  }
?>
