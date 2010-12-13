/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package net.xp_framework.xar;

import java.io.ByteArrayInputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.Hashtable;
import java.util.List;
import java.util.Map;

/**
 *
 * @author kiesel
 */
public class XarFile {
    public static final int ARCHIVE_HEADER_SIZE         = 0x100;
    public static final int ARCHIVE_INDEX_ENTRY_SIZE    = 0x100;
    
    protected String name = null;
    protected Map<String, XarEntry> entries= null;
    protected File file= null;

    public XarFile(File file) throws FileNotFoundException, IOException {
        this.file= file;
        this.readIndex();
    }

    public XarFile(String fileName) throws IOException {
        this.file= new File(fileName);
        this.readIndex();
    }

    private void readIndex() throws FileNotFoundException, IOException {
        FileInputStream in= new FileInputStream(this.file);

        byte[] header= new byte[ARCHIVE_HEADER_SIZE];
        in.read(header);

        String magic= new String(header, 0, 2);
        if (magic.equals("CCA")) throw new IOException("Given file is not a .xar archive - Illegal magic value: " + magic);

        String version= String.valueOf(header[3]);
        System.out.println("Version= " + version);

        int indexSize= this.intFromBytes(header, 4);

        System.out.println("Index size= " + String.valueOf(indexSize));
        this.entries= new Hashtable<String,XarEntry>(indexSize);

        for (int i= 0; i < indexSize; i++) {
            byte[] bytes= new byte[ARCHIVE_INDEX_ENTRY_SIZE];
            in.read(bytes);

            String id= new String(bytes, 0, 240);
            int size= this.intFromBytes(bytes, 240);
            int offset= this.intFromBytes(bytes, 244);

            System.out.println("---> Entry: " + id);
            System.out.println("     Size: " + size + " / offset: " + offset);
            this.entries.put(id, new XarEntry(id, offset, size));
        }
    }

    public XarEntry getEntry(String id) {
        return this.entries.get(id);
    }

    public InputStream getInputStream(XarEntry e) throws IOException {
        FileInputStream is= new FileInputStream(this.file);
        byte[] data= new byte[e.getSize()];
        is.read(data, e.getOffset(), e.getSize());

        return new ByteArrayInputStream(data);
    }

    private int intFromBytes(byte[] bytes, int i) {
        return ((bytes[i] & 0xff)) |
            ((bytes[i+ 1] & 0xff) << 8) |
            ((bytes[i+ 2] & 0xff) << 16) |
            ((bytes[i+ 3] & 0xff) << 24)
        ;
    }
}
