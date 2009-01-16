using System;
using XcCli;

class Hello : Command
{
    private string name;

    [Arg]
    public void SetName(string name) 
    {
        this.name = name;
    }

    public override void run() 
    {
        Console.WriteLine("Hello {0}", this.name);
    }
}
