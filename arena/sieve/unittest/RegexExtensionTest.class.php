<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase for vacation extension
   *
   * @see      http://ietfreport.isoc.org/idref/draft-ietf-sieve-regex
   * @purpose  Unittest
   */
  class RegexExtensionTest extends SieveParserTestCase {
 
    /**
     * Test regex
     *
     */
    #[@test]
    public function regex() {
      $condition= $this->parseCommandSetFrom('
        # if the subject is all uppercase (no lowercase)
        if header :regex "subject" "^[^[:lower:]]+$" {
           discard;      # junk it
        }
      ')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.HeaderCondition');
      $this->assertEquals(MatchType::regex(), $condition->matchtype);
      $this->assertEquals(array('^[^[:lower:]]+$'), $condition->keys);
    }

    /**
     * Test regex with comparator
     *
     */
    #[@test]
    public function withComparator() {
      $condition= $this->parseCommandSetFrom('
        # if the subject is all uppercase (no lowercase)
        if header :regex :comparator "i;ascii-casemap" "Subject" "\\[Bug [0-9]+\\]" {
           fileinto "INBOX.bugs";
        }
      ')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.HeaderCondition');
      $this->assertEquals(MatchType::regex(), $condition->matchtype);
      $this->assertEquals('i;ascii-casemap', $condition->comparator);
      $this->assertEquals(array('\[Bug [0-9]+\]'), $condition->keys);
    }
  }
?>
