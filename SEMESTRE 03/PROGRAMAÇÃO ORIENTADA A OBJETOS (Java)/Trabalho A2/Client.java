import java.io.*;
import java.net.*;

public class Client {
    private Socket socket;
    private PrintWriter out;

    public void connect(String address, int port) throws IOException {
        socket = new Socket(address, port);
        out = new PrintWriter(socket.getOutputStream(), true);
        System.out.println("Conectado ao servidor");
    }

    public void sendMove(String position) {
        out.println(position);
    }

    public void disconnect() throws IOException {
        out.close();
        socket.close();
    }
}
