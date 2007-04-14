<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'ant.AntProject'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class AntProjectTest extends TestCase {
  
    /**
     * Test
     *
     */
    #[@test]
    public function parseBuildXml() {
      $project= AntProject::fromString('
        <project name="MyProject" default="dist" basedir=".">
            <description>
                simple example build file
            </description>
          <!-- set global properties for this build -->
          <property name="src" location="src"/>
          <property name="build" location="build"/>
          <property name="dist"  location="dist"/>

          <target name="init">
            <!-- Create the time stamp -->
            <tstamp/>
            <!-- Create the build directory structure used by compile -->
            <mkdir dir="${build}"/>
          </target>

          <target name="compile" depends="init"
                description="compile the source " >
            <!-- Compile the java code from ${src} into ${build} -->
            <javac srcdir="${src}" destdir="${build}"/>
          </target>

          <target name="dist" depends="compile"
                description="generate the distribution" >
            <!-- Create the distribution directory -->
            <mkdir dir="${dist}/lib"/>

            <!-- Put everything in ${build} into the MyProject-${DSTAMP}.jar file -->
            <jar jarfile="${dist}/lib/MyProject-${DSTAMP}.jar" basedir="${build}"/>
          </target>

          <target name="clean"
                description="clean up" >
            <!-- Delete the ${build} and ${dist} directory trees -->
            <delete dir="${build}"/>
            <delete dir="${dist}"/>
          </target>
        </project>
      ');
      
      Console::writeLine($project->toString());
    }
  }
?>
