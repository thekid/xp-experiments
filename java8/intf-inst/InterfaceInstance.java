import java.util.concurrent.atomic.AtomicLong;
import java.lang.reflect.Method;
import java.lang.reflect.Modifier;
import java.io.ByteArrayOutputStream;

public class InterfaceInstance<T> extends ClassLoader {
    private Class<T> base;
    private static final AtomicLong uniq = new AtomicLong();

    public InterfaceInstance(Class<T> base) throws IllegalArgumentException {
        for (Method m : base.getMethods()) {
            if (Modifier.isStatic(m.getModifiers()) && !m.isDefault()) {
                throw new IllegalArgumentException("Interface contains non-static method " + m.getName() + " without default");
            }
        }
        this.base = base;
    }

    public Class findClass(String name) {
        final byte[] definition = loadClassData(name);
        return defineClass(name, definition, 0, definition.length);
    }

    private byte[] loadClassData(String name) {
        ByteArrayOutputStream bytes = new ByteArrayOutputStream();
        try {
            ClassWriter writer = new ClassWriter(new ClassInfo(
                name,
                "java.lang.Object",
                new String[] { this.base.getName() }
            ));
            writer.writeTo(bytes);
            final byte[] definition = bytes.toByteArray();

            // DEBUG
            // java.nio.file.Files.write(java.nio.file.Paths.get(name + ".class"), definition);

            return definition;
        } catch (final Exception e) {
            throw new RuntimeException("Cannot load " + name, e);
        }
    }

    @SuppressWarnings("unchecked")
    public Class<T> defineClass() throws ClassNotFoundException {
        return (Class<T>)super.loadClass(this.base.getName() + "$Proxy$" + uniq.getAndIncrement());
    }
}