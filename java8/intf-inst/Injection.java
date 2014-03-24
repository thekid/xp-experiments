public class Injection {

    public static void main(String... args) {
        Injector inject = new Injector();
        inject.bind(Hello.class, Hello.class);

        System.out.println(inject.getInstance(Hello.class).hello());
    }
}