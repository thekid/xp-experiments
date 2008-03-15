/* This class is part of the XP framework
 *
 * $Id$ 
 */

package net.xp_framework.text;

import java.util.List;
import java.util.ArrayList;

/**
 * Scan result
 *
 * @see Scanner#scan
 */
public class Scanned {
    protected List<Object> elements= new ArrayList<Object>();

    /**
     * Adds an element 
     *
     * @param   e element
     */
    public void add(Object e) { 
        this.elements.add(e); 
    }

    /**
     * Returns an element 
     *
     * @param   index
     * @param   defaultValue the default value to return if no such result exists
     * @return  the value at the given index or the default value
     */
    public <T> T get(int index, T defaultValue) { 
        return (index < 0 || index >= this.elements.size())
            ? defaultValue
            : (T)this.elements.get(index)
        ;
    }

    /**
     * Returns an element 
     *
     * @param   index
     * @return  the value at the given index or null
     */
    public Object get(int index) {
        return this.get(index, null);
    }
}
