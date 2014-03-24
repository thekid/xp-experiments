How do I invoke Java 8 default methods refletively?
==

Given this simple "Hello World"ish Java 8 interface, how do I instantiate it and invoke its hello() method via reflection?

```
public interface Hello {
    default String hello() {
        return "Hello";
    }
}
```

I've found this solution here which creates instances from interfaces like the above reflectively using code from `sun.misc.ProxyGenerator`, defining a class implementing the interface by assembling bytecode. Now I'm able to write:

```java
Class<?> clazz = Class.forName("Hello");
Object instance;

if (clazz.isInterface()) {
    instance = new InterfaceInstance(clazz).defineClass().newInstance();
} else {
    instance = clazz.newInstance();
}

return clazz.getMethod("hello").invoke(instance);
```

See http://stackoverflow.com/questions/22614746/how-do-i-invoke-java-8-default-methods-refletively