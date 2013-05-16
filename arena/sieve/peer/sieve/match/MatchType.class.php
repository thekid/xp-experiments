<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'peer.sieve.match.IsMatch',
    'peer.sieve.match.ContainsMatch',
    'peer.sieve.match.MatchesMatch',
    'peer.sieve.match.RegexMatch'
  );

  /**
   * Commands that perform string comparisons may have an optional match
   * type argument.  The three match types in RFC 5228 are
   * ":contains", ":is", and ":matches".
   *
   * The regex extension defines another match type "regex".
   *
   * The relational extension defines two other matches types, "value"
   * and "count". 
   *
   * @see      http://ietfreport.isoc.org/idref/draft-ietf-sieve-regex
   * @see      rfc://5228
   * @see      rfc://5231
   * @purpose  Base class
   */
  abstract class MatchType extends Object {
    protected static $is, $contains, $matches, $regex;   // Fly-weights, lazily initialized
    
    /**
     * Protected constructor to prevent initialization of subclasses
     * (unless, of course, they override the constructor!)
     *
     */
    protected function __construct() { }
    
    /**
     * Retrieve the "is" match type
     *
     * @return  peer.sieve.IsMatch
     */
    public static function is() {
      if (!isset(self::$is)) self::$is= new IsMatch();
      return self::$is;
    }
    
    /**
     * Retrieve the "contains" match type
     *
     * @return  peer.sieve.ContainsMatch
     */
    public static function contains() {
      if (!isset(self::$contains)) self::$contains= new ContainsMatch();
      return self::$contains;
    }
    
    /**
     * Retrieve the "matches" match type
     *
     * @return  peer.sieve.MatchesMatch
     */
    public static function matches() {
      if (!isset(self::$matches)) self::$matches= new MatchesMatch();
      return self::$matches;
    }
    
    /**
     * Retrieve the "regex" match type
     *
     * @return  peer.sieve.RegexMatch
     */
    public static function regex() {
      if (!isset(self::$regex)) self::$regex= new RegexMatch();
      return self::$regex;
    }

    /**
     * Creates a string representation of this match type.
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName();
    }
  }
?>
