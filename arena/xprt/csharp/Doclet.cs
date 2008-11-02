using System;
using System.Collections.Generic;

namespace Net.XpFramework.Runner
{
    class XpCli
    {

        static void Main(string[] args)
        {
            // Execute
            try
            {
                Environment.Exit(Executor.Execute(Paths.DirName(Paths.Binary()), "class", "xp.doclet.Runner", new string[] { }, args));
            }
            catch (Exception e) 
            {
                Console.Error.WriteLine("*** " + e.Message);
                Environment.Exit(0xFF);
            }
        }
    }
}
