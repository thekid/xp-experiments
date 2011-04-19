package net.xp_framework.phpejb.client;

import javax.naming.directory.InitialDirContext;
import javax.naming.InitialContext;
import javax.naming.NamingException;
import java.util.Hashtable;
import java.util.ListIterator;
import java.util.List;
import javax.script.ScriptException;
import net.xp_framework.phpejb.list.EngineList;
import net.xp_framework.phpejb.slsb.SLHelloWorld;
import net.xp_framework.phpejb.sfsb.SFHelloWorld;
import javax.jms.*;

public class TestClient {

    public void run() {
        System.out.println("starting TestClient...");
        try {
            Hashtable env = new Hashtable();
            env.put(InitialContext.PROVIDER_URL, "jnp://localhost:1099");
            env.put(InitialContext.INITIAL_CONTEXT_FACTORY, "org.jnp.interfaces.NamingContextFactory");
            InitialContext ctx = new InitialContext(env);

            // EngineList
            EngineList list = (EngineList)ctx.lookup("phpejb/EngineListBean/remote");
            List<String> lst = list.getList();
            ListIterator<String> it = lst.listIterator();
            while (it.hasNext()) {
                System.out.println("engine: "+it.next());
            }
            // Stateless
            SLHelloWorld slhw = (SLHelloWorld)ctx.lookup("phpejb/SLHelloWorldBean/remote");
            System.out.println(slhw.sayHello("TestClient"));
            // Stateful
            SFHelloWorld sfhw = (SFHelloWorld)ctx.lookup("phpejb/SFHelloWorldBean/remote");
            sfhw.setName("TestClient");
            System.out.println(sfhw.sayHello());
            // Message driven
            Queue queue = (Queue)ctx.lookup("queue/mdb");
            QueueConnectionFactory factory = (QueueConnectionFactory)ctx.lookup("ConnectionFactory");
            QueueConnection cnn = factory.createQueueConnection();
            QueueSession sess = cnn.createQueueSession(false, QueueSession.AUTO_ACKNOWLEDGE);
            TextMessage msg = sess.createTextMessage("TestClient");
            QueueSender sender = sess.createSender(queue);
            sender.send(msg);
            sess.close();
        } catch (Throwable e) {
            e.printStackTrace();
            return;
        }
    }

    public static void main(String[] argv) {
        TestClient c = new TestClient();
        c.run();
    }

}
