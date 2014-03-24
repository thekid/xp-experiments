public class NewInstance {

    public static void main(String... args) throws Throwable {
        Class<?> clazz = new InterfaceInstance(Hello.class).defineClass();
        System.out.println(Hello.class.cast(clazz.newInstance()).hello());
    }
}