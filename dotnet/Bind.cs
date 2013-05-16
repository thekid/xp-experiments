[assembly: System.Reflection.AssemblyTitle("XP.Bind")]
[assembly: System.Reflection.AssemblyVersion("1.0.0.0")]
namespace XP
{

  public class Assembly
  {
      System.Reflection.Assembly reference;
      
      public Assembly(System.Reflection.Assembly reference)
      {
          this.reference = reference;
      }
      
      public System.Type type(string name)
      {
          return this.reference.GetType(name);
      }

      public object instance(string name)
      {
          return this.reference.CreateInstance(name);
      }
  }

  public class Bind
  {

      public Assembly assembly(string dll)
      {
          return new Assembly(System.Reflection.Assembly.LoadFrom(dll));
      }
  }
}
