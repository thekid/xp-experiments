package examples;

import net.xp_framework.cmd.*;

public class HelloWorld extends Command {
    protected String name;

    /**
     * Set name. Defaults to "World"
     *
     */
    @Arg(position= 0) public void setName(@Default("World") String name) {
        this.name= name;
    }

    public void run() {
        this.out.println("Hello " + name);
    }
}
