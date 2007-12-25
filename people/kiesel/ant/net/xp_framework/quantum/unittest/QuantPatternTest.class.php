<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'net.xp_framework.quantum.QuantPatternSet',
    'net.xp_framework.quantum.QuantPattern',
    'net.xp_framework.quantum.QuantEnvironment',
    'io.collections.iterate.FilteredIOCollectionIterator',
    'io.collections.IOCollection',
    'io.collections.IOElement',
    'io.streams.MemoryOutputStream'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class QuantPatternTest extends TestCase {
  
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function mockCollection($base, $elements) {
      $c= newinstance('io.collections.IOCollection', array($base), '{
        public $base = NULL;
        protected $list= array();
        
        public function __construct($name) { $this->base= $name; }
        public function setList($l) { $this->list= $l; reset($this->list); }
        public function open() { return TRUE; }
        public function rewind() { reset($this->list); }
        public function next() {
          $e= current($this->list);
          next($this->list); 

          if (!$e) return NULL;
          return newinstance("io.collections.IOElement", array($e), \'{
            public $name  = NULL;
            public function __construct($name) {
              $this->name= $name;
            }
            public function getURI() { return $this->name; }
            public function getSize() { return 0; }
            public function createdAt() { return Date::now(); }
            public function lastAccessed() { return Date::now(); }
            public function lastModified() { return Date::now(); }
          }\');
        }
        public function close() { return TRUE; }
        public function getURI() { return $this->base; }
        public function getSize() { return 0; }
        public function createdAt() { return Date::now(); }
        public function lastAccessed() { return Date::now(); }
        public function lastModified() { return Date::now(); }
      }');
      
      $c->setList($elements);
      return $c;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function asArray($iterator) {
      $list= array();
      while ($iterator->hasNext()) { $list[]= $iterator->next()->getURI(); }
      return $list;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function newPatternSet(QuantEnvironment $env, $inc, $exc= NULL) {
      $p= new QuantPatternSet();
      foreach ($inc as $i) $p->addIncludePattern(new QuantPattern($i, $env->directorySeparator()));
      
      if (is_array($exc)) {
        foreach ($exc as $e) $p->addIncludePattern(new QuantPattern($e, $env->directorySeparator()));
      } else {
        // Otherwise use default excludes
        foreach ($env->getDefaultExcludes() as $exclude) $p->addExcludePattern($exclude);
      }
      
      return $p;
    }
    
    /**
     * Create filter
     * 
     **/
    protected function iteratorFor($ds, IOCollection $collection, array $inc, array $exc= NULL) {
      $env= new QuantEnvironment(new StringWriter(new MemoryOutputStream()), new StringWriter(new MemoryOutputStream()), $ds);
      return new QuantFileIterator($collection, $this->newPatternSet(
        $env, $inc, $exc
      )->createFilter($env, $collection->getURI()), TRUE, '');
    }
    
    /**
     * Retrieve filtered file list
     * 
     **/
    protected function filteredArray($ds, $base, $files, $includeFilters) {
      return $this->asArray($this->iteratorFor($ds, $this->mockCollection($base, $files), $includeFilters, NULL));
    }
    
    #[@test]
    public function simpleFilterUnix() {
      $this->assertEquals(array('base/entry/foo'), $this->filteredArray('/', 'base', array('base/entry/foo'), array('**/*')));
    }
    
    #[@test]
    public function simpleFilterWin32() {
      $this->assertEquals(array('base\\entry\\foo'), $this->filteredArray('\\', 'base', array('base\\entry\\foo'), array('**/*')));
    }

    #[@test]
    public function filterSvnUnix() {
      $this->assertEmpty($this->filteredArray('/', 'base', array('base/.svn/text-entries', 'base/.svn', 'base/.svn/'), array('**/*')));
    }
    
    #[@test]
    public function filterSvnWin32() {
      $this->assertEmpty($this->filteredArray('\\', 'base', array('base\\.svn\\text-entries', 'base\\.svn', 'base\\.svn\\'), array('**/*')));
    }
    
    #[@test]
    public function filterTextUnix() {
      $expect= array('base/my.txt');
      $input= array(
        'base/some',
        'base/some.file',
        'base/my.txt',
        'base/my.txt~',
        'base/other/my.txt',
        'base/one/two/my.txt.bak',
        'base/one/two/my.txt'
      );
      $filters= array('my.txt');
      $this->assertEquals($expect, $this->filteredArray('/', 'base', $input, $filters));
    }
    
    #[@test]
    public function filterAnyDepthUnix() {
      $expect= array(
        'base/my.txt',
        'base/other/my.txt',
        'base/one/two/my.txt'
      );
      $input= array(
        'base/some',
        'base/some.file',
        'base/my.txt',
        'base/my.txt~',
        'base/other/my.txt',
        'base/one/two/my.txt.bak',
        'base/one/two/my.txt'
      );
      $filters= array(
        'my.txt',
        '**/my.txt'
      );
      $this->assertEquals($expect, $this->filteredArray('/', 'base', $input, $filters));
    }
    
    #[@test]
    public function filterParticularDepthUnix() {
      $expect= array(
        'base/one/two/my.txt'
      );
      $input= array(
        'base/some',
        'base/some.file',
        'base/my.txt',
        'base/my.txt~',
        'base/other/my.txt',
        'base/one/two/my.txt.bak',
        'base/one/two/my.txt'
      );
      $filters= array(
        '*/*/my.txt'
      );
      $this->assertEquals($expect, $this->filteredArray('/', 'base', $input, $filters));
    }
        
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function asFilter($f, $ds= '/') {
      $p= new QuantPattern($f);
      $p->setDirectorySeparator($ds);
      return $p->nameToRegex();
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function toFilter() {
      $this->assertEquals('#^.*[^/]*~$#', $this->asFilter('**/*~'));
      $this->assertEquals('#^.*\\#[^/]*\\#$#', $this->asFilter('**/#*#'));
      $this->assertEquals('#^.*CVS$#', $this->asFilter('**/CVS'));
      $this->assertEquals('#^.*CVS/.*$#', $this->asFilter('**/CVS/**'));
      $this->assertEquals('#^.*\\.svn$#', $this->asFilter('**/.svn'));
      $this->assertEquals('#^.*\\.svn/.*$#', $this->asFilter('**/.svn/**'));
      $this->assertEquals('#^[^/]*\\.xml$#', $this->asFilter('*.xml'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function dirSlashTest() {
      $this->assertEquals('#^\\.svn/.*$#', $this->asFilter('.svn/'));
    }

  }
?>
