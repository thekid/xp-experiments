using System;
using System.Collections.Generic;
using System.Reflection;
using System.CodeDom.Compiler;
using System.IO;

namespace XcCli 
{    
    public class Runner
    {

        public void run(string[] args)
        {
            var sourceFile = new FileInfo(args[0]);
            CodeDomProvider provider = null;

            if (sourceFile.Extension.ToLower() == ".cs")
            {
                provider = CodeDomProvider.CreateProvider("CSharp");
            }
            else
            {
                throw new ArgumentException("Cannot determine CodeDomProvider from " + sourceFile);
            }

            CompilerParameters cp = new CompilerParameters();

            // Generate an executable instead of 
            // a class library.
            cp.GenerateExecutable = false;

            // Save the assembly as a physical file.
            cp.GenerateInMemory = true;

            // Set whether to treat all warnings as errors.
            cp.TreatWarningsAsErrors = false;

            cp.ReferencedAssemblies.Add("xcclilib.dll");

            // Invoke compilation of the source file.
            CompilerResults cr = provider.CompileAssemblyFromFile(cp, new string[] {
                sourceFile.FullName
            });

            if (cr.Errors.Count > 0)
            {
                // Display compilation errors.
                Console.WriteLine("Errors building {0} into {1}",
                    sourceFile, cr.PathToAssembly);
                foreach (CompilerError ce in cr.Errors)
                {
                    Console.WriteLine("  {0}", ce.ToString());
                    Console.WriteLine();
                }
                return;
            }

            // Display a successful compilation message.
            Type t = cr.CompiledAssembly.GetType(sourceFile.Name.Substring(0, sourceFile.Name.Length - sourceFile.Extension.Length), true);
            if (!t.IsSubclassOf(typeof(Command)))
            {
                Console.Error.WriteLine("*** " + t + " is not a command");
                return;
            }

            var parameters = new Dictionary<string, string>();
            for (int i = 1; i < args.Length; i++)
            {
                if (args[i].StartsWith("--"))
                {
                    string[] parts = args[i].Substring(2).Split(new char[] { '=' }, 2);
                    parameters[parts[0]] = parts[1];
                }
                else if (args[i].StartsWith("-"))
                {
                    parameters[args[i].Substring(1)] = args[++i];
                }
            }

            Command c= ((Command)Activator.CreateInstance(t));
            foreach (MethodInfo m in t.GetMethods())
            {
                foreach (object attr in m.GetCustomAttributes(false))
                {
                    if (attr is Arg)
                    {
                        string name = m.Name.ToLower();
                        if (name.StartsWith("set"))
                        {
                            name = name.Substring(3);
                        }
                        m.Invoke(c, new object[] { parameters[name] });
                    }
                }
            }
            c.run();
        }

        /// <summary>
        /// Entry point method
        /// </summary>
        /// <param name="args"></param>
        public static void Main(string[] args)
        {
            try
            {
                new Runner().run(args);
            }
            catch (Exception e)
            {
                Console.Error.WriteLine("*** " + e);
                return;
            }
        }
    }
}
