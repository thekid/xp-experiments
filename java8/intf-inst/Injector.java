import java.util.HashMap;
import java.lang.reflect.Constructor;
import java.lang.reflect.Parameter;
import java.lang.reflect.InvocationTargetException;
import static java.util.Arrays.stream;

public class Injector {
    public HashMap<Class<?>, Class<?>> bindings = new HashMap<>();

    public <T> Injector bind(Class<T> intf, Class<T> impl) {
        if (impl.isInterface()) {
            try {
                this.bindings.put(intf, new InterfaceInstance(impl).defineClass());
            } catch (ClassNotFoundException e) {
                throw new IllegalArgumentException("Cannot bind", e);
            }
        } else {
            this.bindings.put(intf, impl);
        }
        return this;
    }

    @SuppressWarnings("unchecked")
    public <T> Class<T> get(Class<T> clazz) {
        Class<?> bound = this.bindings.get(clazz);
        if (bound == null) {
            return clazz;
        } else {
            return (Class<T>)bound;
        }
    }

    protected <T> T newInstance(Class<T> clazz) throws InstantiationException, IllegalAccessException {
        for (Constructor<?> ctor : clazz.getConstructors()) {
            int params = ctor.getParameterCount();
            try {
                if (0 == params) {
                    return clazz.cast(ctor.newInstance());
                } else if (ctor.isAnnotationPresent(Inject.class)) {
                    return clazz.cast(ctor.newInstance(stream(ctor.getParameters())
                        .map(param -> (Object)this.getInstance(param.getType()))
                        .toArray()
                    ));
                }
            } catch (InvocationTargetException e) {
                throw new InstantiationException(ctor.toString());
            }
        }
        return clazz.newInstance();
    }

    public <T> T getInstance(Class<T> clazz) {
        try {
            T instance = this.newInstance(this.get(clazz));

            // TODO: Perform injection on members
            return instance;
        } catch (final Exception e) {
            throw new RuntimeException("Cannot instantiate", e);
        }
    }
}