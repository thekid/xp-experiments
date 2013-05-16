<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'xp.webstart';

  uses(
    'lang.System',
    'util.cmd.Console',
    'peer.URL',
    'xml.Tree',
    'xml.parser.XMLParser',
    'xml.parser.StreamInputSource',
    'peer.http.HttpConnection',
    'peer.http.HttpInputStream',
    'io.File',
    'io.streams.FileInputStream',
    'io.streams.FileOutputStream',
    'xp.webstart.types.XnlpDocument',
    'xml.meta.Unmarshaller'
  );

  /**
   * Webstart command
   * ~~~~~~~~~~~~~~~~
   *
   * Usage:
   * <pre>
   *   webstart [url]
   * </pre>
   *
   * @purpose  Tool
   */
  class xp·webstart·Runner extends Object {

    /**
     * Converts api-doc "markup" to plain text w/ ASCII "art"
     *
     * @param   string markup
     * @return  string text
     */
    protected static function textOf($markup) {
      $line= str_repeat('=', 72);
      return strip_tags(preg_replace(array(
        '#<pre>#', '#</pre>#', '#<li>#',
      ), array(
        $line, $line, '* ',
      ), trim($markup)));
    }

    /**
     * Displays usage and exits
     *
     */
    protected static function usage() {
      Console::$err->writeLine(self::textOf(XPClass::forName(xp::nameOf(__CLASS__))->getComment()));
      exit(1);
    }

    /**
     * Main runner method
     *
     * @param   string[] args
     */
    public static function main(array $args) {
      if (!$args) self::usage();
      
      // Parse arguments
      $verbose= FALSE;
      for ($i= 0, $s= sizeof($args); $i < $s; $i++) {
        if ('-v' === $args[$i]) {
          $verbose= TRUE;
        } else if ('-' === $args[$i]{0}) {
          Console::$err->writeLine('*** Unknown argument "', $args[$i], '"');
          exit(1);
        }
        break;
      }

      $url= new URL($args[$i]);
      switch ($url->getScheme('file')) {
        case 'http': $stream= new HttpInputStream(create(new HttpConnection($url))->get()); break;
        case 'file': $stream= new FileInputStream(new File($url->getPath())); break;
        default: Console::$err->writeLine('*** Scheme '.$url->getScheme().' not supported'); exit(2);
      }
      
      // Parse into XnlpDocument
      $t= new Tree();
      $p= new XMLParser();
      $p->setCallback($t);
      $p->parse(new StreamInputSource($stream));
      $xnlp= Unmarshaller::unmarshal($t->getSource(INDENT_NONE), 'xp.webstart.types.XnlpDocument');

      $verbose && Console::writeLine($xnlp);
      
      // Fetch all resources
      $verbose && Console::writeLine('===> Fetching resources');
      foreach ($xnlp->getResources() as $resource) {
        $url= $xnlp->getCodebase()->resolve($resource->getHref());
        $target= new File(System::tempDir(), basename($url->getUri()));
        $verbose && Console::writeLine('---> ', $url, ' -> ', $target);

        $in= new HttpInputStream(create(new HttpConnection($url->getUri()))->get());
        $out= new FileOutputStream($target);
        while ($in->available()) {
          $out->write($in->read());
        }
        $out->close();
        
        ClassLoader::registerPath($target->getURI());
      }
      
      $class= $xnlp->getApp()->getMainClass();
      $verbose && Console::writeLine('===> Launching ', $class);
      XPClass::forName($class)->getMethod('main')->invoke(NULL, array(array()));
    }
  }
?>
