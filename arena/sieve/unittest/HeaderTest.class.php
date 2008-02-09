<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase
   *
   * @see      xp://peer.sieve.HeaderCondition
   * @purpose  Unittest
   */
  class HeaderTest extends SieveParserTestCase {

    /**
     * Test
     *
     */
    #[@test]
    public function xCaffeineIsEmpty() {
      $condition= $this->parseCommandSetFrom('
        if header :is ["X-Caffeine"] [""] {
           keep;
        }
      ')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.HeaderCondition');
      $this->assertEquals(MatchType::is(), $condition->matchtype);
      $this->assertEquals(array('X-Caffeine'), $condition->names);
      $this->assertEquals(array(''), $condition->keys);
    }

    /**
     * Test
     *
     */
    #[@test]
    public function xCaffeineContainsEmpty() {
      $condition= $this->parseCommandSetFrom('
        if header :contains ["X-Caffeine"] [""] {
           keep;
        }
      ')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.HeaderCondition');
      $this->assertEquals(MatchType::contains(), $condition->matchtype);
      $this->assertEquals(array('X-Caffeine'), $condition->names);
      $this->assertEquals(array(''), $condition->keys);
    }

    /**
     * Test
     *
     */
    #[@test]
    public function ccMatches() {
      $condition= $this->parseCommandSetFrom('
        if header :matches "Cc" "?*" {
           keep;
        }
      ')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.HeaderCondition');
      $this->assertEquals(MatchType::matches(), $condition->matchtype);
      $this->assertEquals(array('Cc'), $condition->names);
      $this->assertEquals(array('?*'), $condition->keys);
    }
  }
?>
