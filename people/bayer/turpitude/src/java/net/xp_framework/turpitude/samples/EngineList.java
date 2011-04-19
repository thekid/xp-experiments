package net.xp_framework.turpitude.samples;

import javax.script.*;
import java.util.List;
import java.util.ListIterator;

public class EngineList {

   /**
    * default constructor
    * outputs a list of available ScriptEngines via System.out
    */
    public EngineList() {
        ScriptEngineManager mgr = new ScriptEngineManager();
        List<ScriptEngineFactory> lst = mgr.getEngineFactories();
        System.out.println("found " + lst.size() + " available ScriptEngines:");
        ListIterator<ScriptEngineFactory> it = lst.listIterator();
        while (it.hasNext()) {
            System.out.println("Engine: " + it.next().getEngineName());
        }
    }

    /**
     * entry point
     */
    public static void main(String[] argv) {
        EngineList el = new EngineList();
    }
 

}
