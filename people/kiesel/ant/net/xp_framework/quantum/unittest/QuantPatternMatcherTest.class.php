<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'net.xp_framework.quantum.QuantPatternMatcher'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantPatternMatcherTest extends TestCase {
    
    protected function patternFor($pattern) {
      return new QuantPatternMatcher($pattern);
    }
    
    #[@test]
    public function patternEqualsName() {
      $this->assertTrue($this->patternFor('file')->matches('file'));
    }
    
    #[@test]
    public function patternEqualsStart() {
      $this->assertFalse($this->patternFor('dir')->matches('dir/file'));
    }
    
    #[@test]
    public function patternEqualsEnd() {
      $this->assertFalse($this->patternFor('file')->matches('dir/file'));
    }
    
    #[@test]
    public function patternEqualsStartOfName() {
      $this->assertFalse($this->patternFor('file.txt')->matches('file'));
    }

    #[@test]
    public function patternEqualsNameWithFolder() {
      $this->assertTrue($this->patternFor('directory/file')->matches('directory/file'));
    }
    
    #[@test]
    public function simpleWildcard() {
      $this->assertTrue($this->patternFor('fi?e')->matches('file'));
    }
    
    #[@test]
    public function simpleStarWildcard() {
      $this->assertTrue($this->patternFor('f*k')->matches('framework'));
    }
    
    #[@test]
    public function wildcardDoesNotTraverseDirectories() {
      $this->assertFalse($this->patternFor('directory?file')->matches('directory/file'));
    }

    #[@test]
    public function wildcardStarDoesNotTraverseDirectories() {
      $this->assertFalse($this->patternFor('directory*file')->matches('directory/file'));
    }
    
    #[@test]
    public function wildcardMatchesFiles() {
      $this->assertTrue($this->patternFor('directory/*')->matches('directory/anything'));
      $this->assertTrue($this->patternFor('directory/*')->matches('directory/just_anything'));
    }
    
    #[@test]
    public function wildcardMatchesDirectory() {
      $this->assertTrue($this->patternFor('*/file')->matches('somewhere/file'));
      $this->assertTrue($this->patternFor('*/file')->matches('otherwhere/file'));
    }
    
    #[@test]
    public function wildcardMatchesInbetween() {
      $this->assertTrue($this->patternFor('dir/*/file')->matches('dir/something/file'));
      $this->assertTrue($this->patternFor('dir/*/file')->matches('dir/anotherthing/file'));
    }
    
    #[@test]
    public function wildcardKeepsDepth() {
      $pattern= $this->patternFor('*/*/*/file');
      $this->assertFalse($pattern->matches('file'));
      $this->assertFalse($pattern->matches('1/file'));
      $this->assertFalse($pattern->matches('1/2/file'));
      $this->assertTrue($pattern->matches('1/2/3/file'));
    }
    
    #[@test]
    public function directoryWildcard() {
      $pattern= $this->patternFor('**/*');
      $this->assertTrue($pattern->matches('file'));
      $this->assertTrue($pattern->matches('dir/file'));
      $this->assertTrue($pattern->matches('dir/second/file'));
      $this->assertTrue($pattern->matches('dir/second/third/file'));
    }
    
    #[@test]
    public function enclosedDirectoryWildcard() {
      $pattern= $this->patternFor('dir/**/file.txt');
      $this->assertTrue($pattern->matches('dir/file.txt'));
      $this->assertTrue($pattern->matches('dir/dir/file.txt'));
      $this->assertTrue($pattern->matches('dir/dir/.hidden/file.txt'));
    }
    
    #[@test]
    public function trailingDirectoryWildcard() {
      $pattern= $this->patternFor('dir/**');
      $this->assertTrue($pattern->matches('dir/some/file'));
      $this->assertFalse($pattern->matches('some/dir/some/file'));
    }
    
    #[@test]
    public function directoryMatch() {
      $this->assertTrue($this->patternFor('directory/')->matches('directory/file'));
      $this->assertTrue($this->patternFor('directory/')->matches('directory/file/bar'));
    }
    
    #[@test]
    public function staticMatchEnclosedWithWildcards() {
      $this->assertTrue($this->patternFor('**/directory/**')->matches('some/directory/file'));
      $this->assertFalse($this->patternFor('**/directory/**')->matches('nothing'));
    }
  }
?>
