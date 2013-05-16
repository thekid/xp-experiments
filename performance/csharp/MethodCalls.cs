using System;
using System.Collections.Generic;

namespace Profiling
{

    abstract class MethodCalls : Profileable 
    {
    
        public static MethodCalls PUBLIC = new _PUBLIC(); class _PUBLIC : MethodCalls {
            public void publicMethod(int i)
            {
                i++;
            }

            public override void run(int times) 
            {
                for (int i = 0; i < times; i++) 
                {
                    publicMethod(i);
                }
            }
        }

        public static MethodCalls PRIVATE = new _PRIVATE(); class _PRIVATE : MethodCalls {
            private void privateMethod(int i)
            {
                i++;
            }

            public override void run(int times) 
            {
                for (int i = 0; i < times; i++) 
                {
                    privateMethod(i);
                }
            }
        }

        public static MethodCalls PROTECTED = new _PROTECTED(); class _PROTECTED : MethodCalls {
            protected void protectedMethod(int i)
            {
                i++;
            }

            public override void run(int times) 
            {
                for (int i = 0; i < times; i++) 
                {
                    protectedMethod(i);
                }
            }
        }
        
        public abstract void run(int times);
    }
}
