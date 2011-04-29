using System;
using System.Collections.Generic;
using System.Reflection;
using System.Diagnostics;

namespace Profiling
{

    class Profile 
    {

        public static void Main(string[] args)
        {
            try {
                new Profile().run(args);
            } catch (Exception e) {
                Console.Error.WriteLine("*** " + e);
            }
        }
    
        public void run(string[] args)
        {
            int times = args.Length > 1 ? Convert.ToInt32(args[1]) : 10000000;
            Type type = Type.GetType("Profiling." + args[0], true);

            Console.WriteLine(
                "== Profiling Type<{0}> ==",
                type
            );
            
            var profilees = new Dictionary<string, Profileable>();
            foreach (var m in type.GetFields(BindingFlags.Public | BindingFlags.Static))
            {
                profilees[m.Name]= (Profileable)m.GetValue(null);
            }
            
            var watch = new Stopwatch();
            foreach (var p in profilees) 
            {
                watch.Start();
                p.Value.run(times);
                watch.Stop();
                
                Console.WriteLine(
                    "{0}: {1:0.000} seconds for {2} runs ({3:0} / second)",
                    p.Key,
                    watch.Elapsed.TotalSeconds,
                    times,
                    times * (1 / watch.Elapsed.TotalSeconds)
                );
            }
            
            Console.WriteLine(
                "== Memory used: {0:0.000} kB ==",
                System.GC.GetTotalMemory(true) / 1024
            );
        }
    }
}
