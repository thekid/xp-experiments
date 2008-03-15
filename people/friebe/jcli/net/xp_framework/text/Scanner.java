/* This class is part of the XP framework
 *
 * $Id$ 
 */

package net.xp_framework.text;

import java.util.StringTokenizer;

/**
 * Provides methods to scan a string 
 *
 * @see http://php.net/sscanf
 */
public abstract class Scanner {

    /**
     * Returns a span of a string comparing it to a mask
     *
     */
    protected static String span(String s, String mask, int offset, boolean not) {
        StringBuffer result= new StringBuffer();
        for (int i= offset; i < s.length(); i++) {
            char c= s.charAt(i);
            int p= mask.indexOf(c);
            
            if (not && p != -1 || !not && p == -1) break;
            result.append(c);
        }
        return result.toString();
    }

    /**
     * Scans a string 
     *
     * @param   input input string
     * @param   format format string with tokens
     * @return  scan result
     */
    public static Scanned scan(String input, String format) {
        StringTokenizer t= new StringTokenizer(format, "%");
        Scanned result= new Scanned();
        int offset= 0;

        while (t.hasMoreTokens()) {
            String token= t.nextToken();

            // Handle tokens:
            // * %d - an integer (0-9)
            // * %f - a float (0-9.)
            // * %s - a string (scan until next whitespace, \r\n\s\t)
            switch (token.charAt(0)) {
                case 'd': {
                    String number= span(input, "0123456789", offset, false);
                    if (0 == number.length()) return result;

                    result.add(Integer.parseInt(number));
                    offset+= number.length();
                    token= token.substring(1, token.length());
                    break;
                }

                case 'f': {
                    String number= span(input, "0123456789.", offset, false);
                    if (0 == number.length()) return result;
                    
                    result.add(Float.parseFloat(number.toString()));
                    offset+= number.length();
                    token= token.substring(1, token.length());
                    break;
                }
                
                case 's': {
                    String string= span(input, "\r\n\t ", offset, true);
                    if (0 == string.length()) return result;
                    
                    result.add(string);
                    offset+= string.length();
                    token= token.substring(1, token.length());
                    break;
                }
            }

            if (!token.equals(input.substring(offset, offset + token.length()))) return result;
            offset+= token.length();
        }
        
        return result;
    }
}
