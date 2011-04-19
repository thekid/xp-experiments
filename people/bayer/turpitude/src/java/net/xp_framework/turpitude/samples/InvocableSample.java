package net.xp_framework.turpitude.samples;

import javax.script.*;
import net.xp_framework.turpitude.PHPEvalException;
import net.xp_framework.turpitude.PHPCompileException;

public class InvocableSample {

   /**
    * default constructor
    */
    public InvocableSample() {
    }

    /**
     * executes a script from a file
     */
    public void exec() {
        ScriptEngineManager mgr = new ScriptEngineManager();
        ScriptEngine eng = mgr.getEngineByName("turpitude");
        if (null == eng) {
            System.out.println("unable to find engine, please check classpath");
            return;
        }
        System.out.println("found Engine: " + eng.getFactory().getEngineName());
        Compilable comp = (Compilable)eng;

        Object retval;
        try {
            CompiledScript script = comp.compile(getSource());
            script.eval();
            Invocable inv = (Invocable)script;
            Object phpobj = inv.invokeFunction("useless", "Function Value");
            printRetval(phpobj);
            retval = inv.invokeMethod(phpobj, "bar", "Method Value");
            printRetval(retval);
            //inv.invokeFunction("non", "existant", "function");
            //inv.invokeMethod("non", "existant", "object");
            //inv.invokeMethod(phpobj, "non existant", "method");
            ExampleInterface exint = inv.getInterface(ExampleInterface.class);
            retval = exint.bar("interface call");
            printRetval(retval);
            exint = inv.getInterface(phpobj, ExampleInterface.class);
            retval = exint.bar("interface call");
            printRetval(retval);
        } catch(Throwable e) {
            e.printStackTrace();
        }

    }

    private static void printRetval(Object retval) {
        if (null == retval)
            System.out.println("return value " + retval);
        else 
            System.out.println("return value " + retval.getClass() + " : " + retval);
    }

    private static String getSource() {
        StringBuffer src = new StringBuffer();
        src.append("<?php \n");
        src.append("function useless($i) {");
        src.append("    return new foo($i);");
        src.append("}");
        src.append(" ");
        src.append("class foo {");
        src.append("  var $val = '';");
        src.append("  function __construct($i) {");
        src.append("    $this->val = $i;");
        src.append("  }");
        src.append("  function bar($i) {");
        src.append("    return 'foo::bar::'.$i.' ('.$this->val.')';");
        src.append("  }");
        src.append("}");
        src.append(" ");
        src.append("class ExampleInterface { ");
        src.append("  function bar($i) {");
        src.append("    return 'ExampleInterface::bar::'.$i;");
        src.append("  }");
        src.append("}");
        src.append(" ");
        src.append("?>"); 
        return src.toString();
    }

    /**
     * entry point
     */
    public static void main(String[] argv) {
        InvocableSample cs = new InvocableSample();
        cs.exec();
    }
 

}
