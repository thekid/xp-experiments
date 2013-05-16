/* This class is part of the XP framework
 *
 * $Id$ 
 */

package net.xp_framework.cmd;

import java.io.PrintStream;
import java.lang.reflect.Method;
import java.lang.reflect.InvocationTargetException;
import java.io.File;
import java.io.IOException;
import java.util.Arrays;
import java.util.Properties;
import java.net.URL;
import java.net.URLClassLoader;
import net.xp_framework.text.*;
import javax.tools.*;

/**
 * Runs a Command class 
 *
 */
public class Runner {
    private static PrintStream out= System.out;
    private static PrintStream err= System.err;

    /**
     * Main method
     *
     * @param   args 
     */
    public static void main(String... args) {
        System.exit(new Runner().run(new ParamString(args)));
    }
    
    /**
     * Run
     *
     * @param   params ParamString object
     * @return  exitcode
     */
    public int run(ParamString params) {
        if (!params.exists(0)) {
            err.println("*** Missing classname");
            return 1;
        }
        
        // Figure out classname
        String classname= params.value(0);
        ParamString classparams= new ParamString(params.list.subList(1, params.count).toArray(new String[] { }));
        
        ClassLoader cl= null;

        // Compile .java files, load classes using the system class loader otherwise
        if (!classname.endsWith(".java")) {
            cl= ClassLoader.getSystemClassLoader();
        } else {
            boolean success= false;
            File classfile= new File(classname);
            DiagnosticCollector<JavaFileObject> diagnostics= new DiagnosticCollector<JavaFileObject>();

            JavaCompiler tool= ToolProvider.getSystemJavaCompiler();
            StandardJavaFileManager manager= tool.getStandardFileManager(diagnostics, null, null);
            try {
                success= tool.getTask(
                    null, 
                    manager, 
                    null, 
                    null, 
                    null, 
                    manager.getJavaFileObjectsFromFiles(Arrays.asList(classfile))
                ).call();
                cl= new URLClassLoader(new URL[] { classfile.getCanonicalFile().toURI().toURL() });
            } catch (Throwable e) {
                e.printStackTrace(err);
                success= false;
            } finally {
                try {
                    manager.close();
                } catch (IOException e) {
                    e.printStackTrace(err);
                    success= false;
                }
                if (!success) {
                    err.println("*** Compilation failed");
                    for (Diagnostic diagnostic: diagnostics.getDiagnostics()) {
                        err.format(
                            "    Error on line %d in %s%n",
                            diagnostic.getLineNumber(),
                            diagnostic.getSource()
                        );
                    }
                    return 1;
                }
            }            

            classname= classname.substring(0, classname.length() - ".java".length()).replace("/", ".");
        }

        // Load class
        Class clazz= null;
        try {
            clazz= Class.forName(classname, true, cl);
        } catch (ClassNotFoundException e) {
            err.println("*** Class " + classname + " does not exist: " + e.getMessage());
            return 1;
        }
        
        if (clazz.isAssignableFrom(Runnable.class)) {
            err.println("*** " + clazz.getName() + " is not runnable");
            return 1;
        }
        
        // Usage
        if (classparams.exists("help", '?')) {
            err.printf("Usage: jcli %s%n", clazz.getName());
            return 0;
        }
        
        // Load, instantiate and initialize
        Command instance= null;
        try {
            instance= (Command)clazz.newInstance();
        } catch (InstantiationException e) {
            err.println("*** Could not instantiate: " + e.getMessage());
            return 1;
        } catch (IllegalAccessException e) {
            err.println("*** Could not instantiate: " + e.getMessage());
            return 1;
        }        
        
        instance.out= out;
        instance.err= err;
        
        // Default config base
        String configBase= "etc";
        
        for (Method m: clazz.getMethods()) {
            Object[] args= null;
            
            if (m.isAnnotationPresent(Inject.class)) {   // Inject objects
                Inject i= m.getAnnotation(Inject.class);
                
                if (m.getParameterTypes()[0].equals(Properties.class)) {
                    Properties p= new Properties();
                    try {
                        p.load(new java.io.FileInputStream(new java.io.File(configBase, i.name())));
                    } catch (java.io.IOException e) {
                        e.printStackTrace(err);
                        return 2;
                    }
                    args= new Object[] { p };
                }
            } else if (m.isAnnotationPresent(Arg.class)) {   // Pass one argument
                Arg a= m.getAnnotation(Arg.class);
                String longName;
                char shortName= 0;
                boolean exists;
                boolean positional= false;

                if (-1 != a.position()) {
                    longName= "#" + String.valueOf(a.position() + 1);
                    exists= classparams.exists(a.position());
                    positional= true;
                } else if (!("".equals(a.name()))) {
                    longName= a.name(); 
                    shortName= a.option() == 0 ? longName.charAt(0) : a.option();
                    exists= classparams.exists(longName);
                } else {
                    longName= m.getName().replaceFirst("^set", "").toLowerCase();
                    shortName= a.option() == 0 ? longName.charAt(0) : a.option();
                    exists= classparams.exists(longName);
                }
                
                if (0 == m.getParameterTypes().length) {
                    if (!exists) continue;
                    
                    args= new Object[] { };
                } else if (!exists) {
                    for (java.lang.annotation.Annotation pa: m.getParameterAnnotations()[0]) {
                        if (!(pa instanceof Default)) continue;
                        args= new Object[] { ((Default)pa).value() };
                    }
                    if (null == args) {
                        err.println("*** Argument " + longName + " does not exist!");
                        return 2;
                    }
                } else {
                    args= new Object[] { positional
                        ? classparams.value(a.position())
                        : classparams.value(longName, shortName) 
                    };
                }
                
            } else if (m.isAnnotationPresent(Args.class)) {   // Pass arguments
                Args a= m.getAnnotation(Args.class);

                if ("".equals(a.select())) {
                    args= new Object[] { classparams.list.toArray(new String[] { }) };
                } else {
                    Scanned scanned= Scanner.scan(a.select(), "[%d..%d]");
                    
                    args= new Object[] { classparams.list.subList(
                        scanned.get(0, 0), 
                        scanned.get(1, classparams.count)
                    ).toArray(new String[] { }) };
                }
            } else {
                continue;
            }

            // Invoke method
            try {
                m.invoke(instance, args);
            } catch (IllegalAccessException e) {
                err.println("*** Could not invoke " + m);
                return 2;
            } catch (InvocationTargetException e) {
                err.println("*** " + e.getMessage() + " " + e.getCause());
                return 2;
            }
        }

        // Call the run() method
        instance.run();
        return 0;
    }
}
