/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package net.xp_framework.xar;

import java.io.UnsupportedEncodingException;

/**
 *
 * @author kiesel
 */
public class XarEntry {
    private String id = null;
    private int offset= -1;
    private int size= -1;
    byte[] data= null;

    public XarEntry(String id, int offset, int size) {
        this.id= id;
        this.offset= offset;
        this.size= size;
    }

    public XarEntry(String id, byte[] data) {
        try {
            if (id.getBytes("iso-8859-1").length > 240) {
                throw new IllegalArgumentException("Name of id must not exceed 240 bytes");
            }
        } catch (UnsupportedEncodingException ex) {
            throw new IllegalArgumentException("Name must be encodable in iso-8859-1");
        }
        this.id= id;
        this.data= data;
        this.size= data.length;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public int getOffset() {
        return offset;
    }

    public void setOffset(int offset) {
        this.offset = offset;
    }

    public int getSize() {
        return size;
    }

    public void setSize(int size) {
        this.size = size;
    }

    public byte[] getBytes() {
        return this.data;
    }
}
