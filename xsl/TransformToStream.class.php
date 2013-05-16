<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.MemoryOutputStream', 'io.streams.Streams');

  class TransformToStream extends Object {
    
    public static function main(array $args) {
      $xsl= new DOMDocument();
      Console::writeLine('XSL: ', $xsl->loadXML('<?xml version="1.0"?>
        <xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
          <xsl:output method="text"/>
          <xsl:template match="/">
            <xsl:text>Hello </xsl:text>
            <xsl:value-of select="normalize-space(/root/text())"/>
            <xsl:text>!</xsl:text>
          </xsl:template>
        </xsl:stylesheet>
      '));
      
      $xml= new DOMDocument();
      Console::writeLine('XML: ', $xml->loadXML('<?xml version="1.0"?>
        <root>
          World
        </root>
      '));
      
      $stream= new MemoryOutputStream();
    
      $p= new XSLTProcessor();
      $p->importStylesheet($xsl);
      Console::writeLine('T: ', $p->transformToURI($xml, Streams::writeableUri($stream)));
      Console::writeLine('B: "', $stream->getBytes(), '"');
    }
  }
?>
