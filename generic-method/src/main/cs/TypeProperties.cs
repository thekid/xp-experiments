using System;

class TypeProperties
{

    public static void Main(string[] args)
    {
        Type t = Type.GetType(args[0]);
        if (null == t) 
        {
            Console.Error.WriteLine("*** No such type '{0}'", args[0]);
            return;
        }
        
        Console.WriteLine("Type {0} [", t);
        foreach (var prop in t.GetProperties())
        {
            Console.WriteLine("  {0}: {1}", prop.Name, prop.PropertyType);
        }
        Console.WriteLine("]");
    }
}
