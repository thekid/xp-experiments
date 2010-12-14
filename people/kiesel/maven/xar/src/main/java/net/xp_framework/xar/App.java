package net.xp_framework.xar;

import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.Iterator;

/**
 * Hello world!
 *
 */
public class App 
{
    public static void main( String[] args ) throws IOException
    {
        XarFile f= new XarFile("test.xar");

        Iterator<XarEntry> entries= f.entries().iterator();
        while (entries.hasNext()) {
            XarEntry entry= entries.next();
            InputStream in= f.getInputStream(entry);

            System.out.println("===> " + entry.getId() + " (reading " + in.available() + " bytes)");

            while (in.available() > 0) {
                byte[] b= new byte[in.available()];
                in.read(b);
            }
            System.out.println(); System.out.println();
        }


        FileOutputStream fos= new FileOutputStream("foo.xar");
        XarFile xf= new XarFile();
        xf.add(new XarEntry("some/path", "Hello World".getBytes()));
        xf.add(new XarEntry("another/path/Foo.class.php", "<?php class Foo extends Object {} ?>".getBytes()));

        xf.write(fos);
        fos.close();
    }
}
