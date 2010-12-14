/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package net.xp_framework.xar;

import java.io.ByteArrayInputStream;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.RandomAccessFile;
import java.util.Collection;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

/**
 *
 * @author kiesel
 */
public class XarFile {
    public static final int ARCHIVE_HEADER_SIZE         = 0x100;
    public static final int ARCHIVE_INDEX_ENTRY_SIZE    = 0x100;
    public static final int FILE_VERSION                = 2;
    private static final int MAX_PATHLEN                = 240;
    
    protected String name = null;
    protected Map<String, XarEntry> entries= null;
    protected long bodyOffset= 0;
    protected RandomAccessFile file= null;

    public XarFile(File file) throws FileNotFoundException, IOException {
        this.file= new RandomAccessFile(file, "r");
        this.readIndex();
    }

    public XarFile(String fileName) throws IOException {
        this.file= new RandomAccessFile(new File(fileName), "r");
        this.readIndex();
    }

    public XarFile() {
        this.file= null;
        this.entries= new HashMap<String, XarEntry>();
    }

    private void readIndex() throws FileNotFoundException, IOException {

        byte[] header= new byte[ARCHIVE_HEADER_SIZE];
        this.file.read(header);

        String magic= new String(header, 0, 2);
        if (magic.equals("CCA")) throw new IOException("Given file is not a .xar archive - Illegal magic value: " + magic);

        String version= String.valueOf(header[3]);
        System.out.println("Version= " + version);

        int indexSize= this.intFromBytes(header, 4);

        System.out.println("Index size= " + String.valueOf(indexSize));
        this.entries= new HashMap<String,XarEntry>(indexSize);

        for (int i= 0; i < indexSize; i++) {
            byte[] bytes= new byte[ARCHIVE_INDEX_ENTRY_SIZE];
            this.file.read(bytes);

            String id= new String(bytes, 0, 240);
            int size= this.intFromBytes(bytes, 240);
            int offset= this.intFromBytes(bytes, 244);

            System.out.println("---> Entry: " + id);
            System.out.println("     Size: " + size + " / offset: " + offset);
            this.entries.put(id, new XarEntry(id, offset, size));
        }

        this.bodyOffset= this.file.getFilePointer();
    }

    public XarEntry getEntry(String id) {
        return this.entries.get(id);
    }

    public Collection<XarEntry> entries() {
        return this.entries.values();
    }

    public InputStream getInputStream(XarEntry e) throws IOException {
        byte[] data= new byte[(int)e.getSize()];

        this.file.seek(e.getOffset() + this.bodyOffset);
        this.file.read(data);

        return new ByteArrayInputStream(data);
    }

    public void add(XarEntry xe) {
        this.entries.put(xe.getId(), xe);
    }

    public void write(OutputStream out) throws IOException {
        Iterator<XarEntry> i= this.entries().iterator();

        // Write file header
        out.write(new byte[] { 'C', 'C', 'A' });
        out.write((byte)FILE_VERSION);
        out.write(this.bytesFromInt(this.entries.size()));
        out.write(this.pad((byte)0, 248));

        // Write index elements
        i= this.entries().iterator();
        int offset= 0;
        while (i.hasNext()) {
            XarEntry xe= i.next();

            out.write(xe.getId().getBytes("iso-8859-1"));
            out.write(this.pad((byte)0, MAX_PATHLEN- xe.getId().getBytes("iso-8859-1").length));

            out.write(this.bytesFromInt(xe.getSize()));
            out.write(this.bytesFromInt(offset));
            out.write(this.pad((byte)0, 8));

            offset+= xe.getSize();
        }

        i= this.entries().iterator();
        while (i.hasNext()) {
            XarEntry xe= i.next();

            out.write(xe.getBytes());
        }
    }

    private int intFromBytes(byte[] bytes, int i) {
        return ((bytes[i] & 0xff)) |
            ((bytes[i+ 1] & 0xff) << 8) |
            ((bytes[i+ 2] & 0xff) << 16) |
            ((bytes[i+ 3] & 0xff) << 24)
        ;
    }

    private byte[] bytesFromInt(int n) {
        byte[] b= new byte[4];

        b[0]= (byte) (n & 0xff);
        b[1]= (byte) ((n >> 8) & 0xff);
        b[2]= (byte) ((n >> 16) & 0xff);
        b[3]= (byte) ((n >> 24) & 0xff);

        return b;
    }

    private byte[] pad(byte c, int n) {
        byte[] b= new byte[n];
        for (int i= 0; i < n; i++) {
            b[i]= c;
        }
        return b;
    }
}
