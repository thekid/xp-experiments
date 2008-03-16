package examples;

import net.xp_framework.cmd.*;
import java.util.Properties;

public class Configured extends Command {
    protected Properties databaseConfig;

    /**
     * Inject database config
     *
     */
    @Inject(name = "database") public void setDatabaseConfig(Properties prop) {
        this.databaseConfig= prop;
    }

    public void run() {
        this.databaseConfig.list(this.out);
    }
}
