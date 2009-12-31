<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'io.zip.ZipFile',
    'io.zip.ZipDir',
    'io.zip.ZipArchiveWriter',
    'io.zip.ZipArchiveReader',
    'io.streams.OutputStream',
    'io.streams.InputStream'
  );

  /**
   * Zip archives hanadling
   *
   * Usage (creating a zip file)
   * ~~~~~~~~~~~~~~~~~~~~~~~~~~~
   * <code>
   *   $z= ZipFile::create(new FileOutputStream(new File('dist.zip')));
   *   $z->addEntry(new ZipDirEntry('META-INF'));
   *   $z->addEntry(new ZipFileEntry('META-INF/version.txt'))->write($contents);
   *   $z->close();
   * </code>
   *
   * Usage (reading a zip file)
   * ~~~~~~~~~~~~~~~~~~~~~~~~~~
   * <code>
   *   $z= ZipFile::open(new FileInputStream(new File('dist.zip')));
   *   foreach ($z->entries() as $entry) {
   *     if ($entry->isDirectory()) {
   *       // Create dir
   *     } else {
   *       // Extract
   *     }
   *   }
   * </code>
   *
   * @see      http://www.pkware.com/documents/casestudies/APPNOTE.TXT
   * @purpose  Entry point class
   */
  abstract class ZipFile extends Object {
    
    /**
     * Creation constructor
     *
     * @param   io.streams.OutputStream stream
     * @return  io.zip.ZipArchiveWriter
     */
    public static function create(OutputStream $stream) {
      return new ZipArchiveWriter($stream);
    }

    /**
     * Read constructor
     *
     * @param   io.streams.InputStream stream
     * @return  io.zip.ZipArchiveReader
     */
    public static function open(InputStream $stream) {
      return new ZipArchiveReader($stream);
    }   
  }
?>
