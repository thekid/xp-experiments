using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;

namespace Net.XpFramework.Runner
{
    class Executor
    {
        private static int KEY = 0;
        private static int VALUE = 1;
        private static char[] PATH_SEPARATOR = new char[] { Path.PathSeparator };

        /// <summary>
        /// 
        /// </summary>
        /// <param name="base_dir"></param>
        /// <param name="runner"></param>
        /// <param name="tool"></param>
        /// <param name="includes"></param>
        /// <param name="args"></param>
        public static int Execute(string base_dir, string runner, string tool, string[] includes, string[] args)
        {
            // Determine USE_XP path from either environment option or from xp.ini
            string env = System.Environment.GetEnvironmentVariable("USE_XP");
            IEnumerable<string> use_xp = null;
            if (null == env)
            {
                if (!File.Exists(base_dir + "xp.ini"))
                {
                    throw new FileNotFoundException("Cannot find xp.ini in " + base_dir);
                }

                foreach (string line in File.ReadAllLines(base_dir + "xp.ini"))
                {
                    string[] parsed = line.Split(new char[] { '=' }, 2);
                    if (parsed[KEY] == "use")
                    {
                        use_xp = Paths.Translate(base_dir, parsed[VALUE].Split(PATH_SEPARATOR));
                    }
                }
            }
            else
            {
                use_xp = Paths.Translate(System.Environment.CurrentDirectory, env.Split(PATH_SEPARATOR));
            }
            
            // Search for tool
            string executor = "php";
            string argv = "-dinclude_path=\".;" + String.Join(new string(PATH_SEPARATOR), includes) + "\" -duser_dir=\"" + String.Join(";", use_xp.ToArray()) + "\" -dmagic_quotes_gpc=0";
            foreach (string ini in Paths.Locate(use_xp, "php.ini", false))
            {
                foreach (string line in File.ReadAllLines(ini))
                {
                    string[] parsed = line.Split(new char[] { '=' }, 2);
                    if (parsed[KEY] == "executor")
                    {
                        executor = parsed[VALUE];
                    }
                    else
                    {
                        argv += " -d" + parsed[KEY] + "=\"" + parsed[VALUE] + "\"";
                    }
                }
            }

            // Spawn runtime
            var proc = new System.Diagnostics.Process();
            proc.StartInfo.FileName = executor;
            proc.StartInfo.Arguments = argv + " \"" + Paths.Locate(use_xp, "tools\\" + runner + ".php", true).First() + "\" " + tool + " \"" + String.Join("\" \"", args) + "\"";
            proc.StartInfo.UseShellExecute = false;
            try
            {
                proc.Start();
                proc.WaitForExit();
                return proc.ExitCode;
            }
            finally
            {
                proc.Close();
            }
        }
    }
}
