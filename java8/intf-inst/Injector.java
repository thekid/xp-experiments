import java.util.HashMap;

public class Injector {
    public HashMap<Class<?>, Class<?>> bindings = new HashMap<>();

    public <T> Injector bind(Class<T> intf, Class<T> impl) {
        if (impl.isInterface()) {
            try {
                impl = new InterfaceInstance<T>(impl).defineClass();
            } catch (ClassNotFoundException e) {
                throw new RuntimeException("Cannot bind", e);
            }
        }
        this.bindings.put(intf, impl);
        return this;
    }

    @SuppressWarnings("unchecked")
    protected <T> Class<T> get(Class<T> clazz) {
        return (Class<T>)this.bindings.get(clazz);
    }

    public <T> T getInstance(Class<T> clazz) {
        try {
            return this.get(clazz).newInstance();
        } catch (InstantiationException | IllegalAccessException e) {
            throw new RuntimeException("Cannot instantiate", e);
        }
    }
}