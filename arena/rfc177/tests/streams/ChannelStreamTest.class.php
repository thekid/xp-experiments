<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'io.streams.ChannelOutputStream',
    'io.streams.ChannelInputStream',
    'io.TempFile',
    'tests.streams.RuntimeOutput',
    'lang.Runtime'
  );

  /**
   * TestCase
   *
   * @see      xp://io.streams.ChannelOutputStream
   * @see      xp://io.streams.ChannelInputStream
   * @purpose  purpose
   */
  class ChannelStreamTest extends TestCase {

    /**
     * Runs sourcecode in a new runtime
     *
     * @param   string[] args
     * @param   string src
     * @param   string in default ''
     * @param   int expectedExitCode default 0
     * @throws  lang.IllegalStateException if process exits with a non-zero exitcode
     * @return  string out
     */
    protected function runInNewRuntime($args, $src, $in= '', $expectedExitCode= 0) {
      $defaultArgs= array(
        '-n',                     // Do not use any configuration file
        '-dsafe_mode=0',          // Switch off "safe" mode
        '-dmagic_quotes_gpc=0',   // Get rid of magic quotes
        '-dextension_dir="'.ini_get('extension_dir').'"',
        '-dinclude_path=".'.PATH_SEPARATOR.get_include_path().'"'
      );
      
      // Store source to temporary file
      with ($t= new TempFile($this->getName())); {
        $t->open(FILE_MODE_WRITE);
        $t->write('<?php require("lang.base.php"); uses("lang.Runtime");');
        $t->write('  try { '.$src.' } catch (Throwable $e) { $e->printStackTrace(); exit(-1); }');
        $t->write('?>');
        $t->close();
      }

      // Fork runtime
      with (
        $out= $err= '', 
        $p= new Process(Runtime::getInstance()->getExecutable()->getFilename(), array_merge($args, $defaultArgs, array('"'.$t->getURI().'"')))
      ); {
        $p->in->write($in);
        $p->in->close();
        
        // Read output
        while ($b= $p->out->read()) { $out.= $b; }
        while ($b= $p->err->read()) { $err.= $b; }
        
        // Close process, get rid of temp file
        $exitv= $p->close();
        $t->unlink();
        
        // Check for exitcode
        if ($expectedExitCode !== $exitv) {
          throw new IllegalStateException(sprintf(
            "Command %s failed with exit code #%d (instead of %d) {OUT: %s\nERR: %s\n}",
            $p->getCommandLine(),
            $exitv,
            $expectedExitCode,
            $out,
            $err
          ));
        }
      }
      return new RuntimeOutput($exitv, $out, $err);
    }

    /**
     * Test ChannelOutputStream constructed with an invalid channel name
     *
     */
    #[@test, @expect('io.IOException')]
    public function invalidOutputChannelName() {
      new ChannelOutputStream('@@invalid@@');
    }

    /**
     * Test ChannelInputStream constructed with an invalid channel name
     *
     */
    #[@test, @expect('io.IOException')]
    public function invalidInputChannelName() {
      new ChannelInputStream('@@invalid@@');
    }
    
    /**
     * Test "stdin" channel cannot be written to
     *
     */
    #[@test, @expect('io.IOException')]
    public function stdinIsNotAnOutputStream() {
      new ChannelOutputStream('stdin');
    }

    /**
     * Test "input" channel cannot be written to
     *
     */
    #[@test, @expect('io.IOException')]
    public function inputIsNotAnOutputStream() {
      new ChannelOutputStream('input');
    }

    /**
     * Test "stdout" channel cannot be read from
     *
     */
    #[@test, @expect('io.IOException')]
    public function stdoutIsNotAnInputStream() {
      new ChannelInputStream('stdout');
    }

    /**
     * Test "stderr" channel cannot be read from
     *
     */
    #[@test, @expect('io.IOException')]
    public function stderrIsNotAnInputStream() {
      new ChannelInputStream('stderr');
    }

    /**
     * Test "output" channel cannot be read from
     *
     */
    #[@test, @expect('io.IOException')]
    public function outputIsNotAnInputStream() {
      new ChannelInputStream('outpit');
    }
  
    /**
     * Test "output" channel
     *
     */
    #[@test]
    public function output() {
      $r= $this->runInNewRuntime(array(), '
        uses("io.streams.ChannelOutputStream");

        $s= new ChannelOutputStream("output");
        $s->write("+OK Hello");
      ');
        
      $this->assertEquals('+OK Hello', $r->out());
      $this->assertEquals('', $r->err());
    }

    /**
     * Test "stdout" channel
     *
     */
    #[@test]
    public function stdout() {
      $r= $this->runInNewRuntime(array(), '
        uses("io.streams.ChannelOutputStream");

        $s= new ChannelOutputStream("stdout");
        $s->write("+OK Hello");
      ');
        
      $this->assertEquals('+OK Hello', $r->out());
      $this->assertEquals('', $r->err());
    }

    /**
     * Test "stderr" channel
     *
     */
    #[@test]
    public function stderr() {
      $r= $this->runInNewRuntime(array(), '
        uses("io.streams.ChannelOutputStream");

        $s= new ChannelOutputStream("stderr");
        $s->write("+OK Hello");
      ');
        
      $this->assertEquals('+OK Hello', $r->err());
      $this->assertEquals('', $r->out());
    }

    /**
     * Test "stdin" channel
     *
     */
    #[@test]
    public function stdin() {
      $r= $this->runInNewRuntime(array(), '
        uses("io.streams.ChannelInputStream");

        $s= new ChannelInputStream("stdin");
        while ($s->available()) {
          echo $s->read();
        }
      ', '+OK Piped input');
        
      $this->assertEquals('+OK Piped input', $r->out());
      $this->assertEquals('', $r->err());
    }

    /**
     * Test "input" channel
     *
     */
    #[@test, @ignore('There is no way to fill "php://input" in CLI php')]
    public function input() {
      $r= $this->runInNewRuntime(array(), '
        uses("io.streams.ChannelInputStream");

        $s= new ChannelInputStream("input");
        while ($s->available()) {
          echo $s->read();
        }
      ', '+OK Piped input');
        
      $this->assertEquals('+OK Piped input', $r->out());
      $this->assertEquals('', $r->err());
    }
  }
?>
