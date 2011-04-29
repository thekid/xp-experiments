using System;
using System.Collections.Generic;

namespace Profiling
{

    abstract class Increment : Profileable 
    {
    
        public static MethodCalls POST = new _POST(); class _POST : MethodCalls {
            public override void run(int times) 
            {
                int a = 0;
                for (int i= 0; i < times; i++) 
                {
                    a++;
                }
            }
        }

        public static MethodCalls PRE = new _PRE(); class _PRE : MethodCalls {
            public override void run(int times) 
            {
                int a = 0;
                for (int i= 0; i < times; i++) 
                {
                    ++a;
                }
            }
        }

        public static MethodCalls BINARY = new _BINARY(); class _BINARY : MethodCalls {
            public override void run(int times) 
            {
                int a = 0;
                for (int i= 0; i < times; i++) 
                {
                    a = a + 1;
                }
            }
        }
        
        public abstract void run(int times);
    }
}
