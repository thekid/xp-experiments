package net.xp_framework.xar;

import java.io.IOException;
import java.io.InputStream;
import java.util.Collection;
import java.util.Iterator;

/**
 * Hello world!
 *
 */
public class App 
{
    public static void main( String[] args ) throws IOException
    {
        XarFile f= new XarFile("C:\\cygwin\\home\\kiesel\\dev\\xp.forge\\trunk\\experiments\\people\\kiesel\\maven\\xar\\test.xar");

        Iterator<XarEntry> entries= f.entries().iterator();
        while (entries.hasNext()) {
            XarEntry entry= entries.next();
            InputStream in= f.getInputStream(entry);

            System.out.println("===> " + entry.getId() + " (reading " + in.available() + " bytes)");

            while (in.available() > 0) {
                byte[] b= new byte[in.available()];
                in.read(b);

                for (int i= 0; i < b.length; i++) {
                    System.out.print((char)b[i]);
                }
            }
            System.out.println(); System.out.println();

        }
    }
}
