public class Injection {
    private Hello sayer;

    @Inject
    public Injection(Hello sayer) {
        System.err.println("Injected: " + sayer);
        this.sayer = sayer;
    }

    public void run() {
        System.out.println(sayer.hello());
    }

    public static void main(String... args) {
        Injector inject = new Injector();
        inject.bind(Hello.class, Hello.class);

        inject.getInstance(Injection.class).run();
    }
}