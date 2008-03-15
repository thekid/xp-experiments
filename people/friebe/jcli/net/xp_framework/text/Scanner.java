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
            // * %x - a hex number (0-9A-F), optionally prefixed w/ "0x"
            // * %s - a string (scan until next whitespace, \r\n\s\t)
            // * %c - a single character
            switch (token.charAt(0)) {
                case 'd': {
                    String number= span(input, "0123456789", offset, false);
                    if (0 == number.length()) return result;

                    result.add(Integer.parseInt(number));
                    offset+= number.length();
                    token= token.substring(1, token.length());
                    break;
                }

                case 'x': {
                    String hex= span(input, "0123456789xABCDEFabcdef", offset, false);
                    if (0 == hex.length()) return result;

                    if ("0x".equals(hex.substring(0, 2))) {
                        result.add(Integer.parseInt(hex.substring(2, hex.length()), 16));
                    } else {
                        result.add(Integer.parseInt(hex, 16));
                    }
                    offset+= hex.length();
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

                case 'c': {
                    if (offset >= input.length()) return result;
                    
                    result.add(input.charAt(offset));
                    offset+= 1;
                    token= token.substring(1, token.length());
                    break;
                }

                case '[': {
                    String mask= token.substring(1, token.indexOf(']'));
                    String string= null;
                    if ('^' == mask.charAt(0)) {
                        string= span(input, mask.substring(1, mask.length()), offset, true);
                    } else {
                        string= span(input, mask, offset, false);
                    }
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
