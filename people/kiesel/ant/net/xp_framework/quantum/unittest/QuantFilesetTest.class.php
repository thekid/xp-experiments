<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'net.xp_framework.quantum.QuantFileset',
    'xml.meta.Unmarshaller'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class QuantFilesetTest extends TestCase {

    /**
     * Test
     *
     */
    #[@test]
    public function verboseStructure() {
      $this->assertStructure(Unmarshaller::unmarshal('
        <fileset dir="${server.src}">
          <patternset>
            <include name="**/*.java"/>
            <exclude name="**/*Test*"/>
          </patternset>
        </fileset>',
        'net.xp_framework.quantum.QuantFileset'
      ));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function abbreviatedStructure() {
      $this->assertStructure(Unmarshaller::unmarshal('
        <fileset dir="${server.src}">
          <include name="**/*.java"/>
          <exclude name="**/*Test*"/>
        </fileset>',
        'net.xp_framework.quantum.QuantFileset'
      ));      
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function attributeStructure() {
      $this->assertStructure(Unmarshaller::unmarshal('
        <fileset dir="${server.src}"
          includes="**/*.java"
          excludes="**/*Test*"
        />',
        'net.xp_framework.quantum.QuantFileset'
      ));
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function assertStructure($u) {
      $this->assertClass($u, 'net.xp_framework.quantum.QuantFileset');
      $this->assertClass($u->patternset, 'net.xp_framework.quantum.QuantPatternSet');
      $this->assertEquals(1, sizeof($u->patternset->includes));
      $this->assertClass($u->patternset->includes[0], 'net.xp_framework.quantum.QuantPattern');
      $this->assertEquals(1, sizeof($u->patternset->excludes));
      $this->assertClass($u->patternset->excludes[0], 'net.xp_framework.quantum.QuantPattern');      
    }
    
  }
?>
