import java.io.*;
import java.net.*;

public class Server {
    private ServerSocket serverSocket;
    private Socket clientSocket;
    private BufferedReader in;
    private PrintWriter out;
    private GameLogic gameLogic;

    public Server(GameLogic gameLogic) {
        this.gameLogic = gameLogic;
    }

    public void start(int port) throws IOException {
        serverSocket = new ServerSocket(port);
        System.out.println("Servidor aguardando conexão...");
        clientSocket = serverSocket.accept();
        System.out.println("Cliente conectado");
        in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
        out = new PrintWriter(clientSocket.getOutputStream(), true);
    }

    public void receiveMove() throws IOException {
        String position;
        while ((position = in.readLine()) != null) {
            System.out.println("Jogada recebida: " + position);
            gameLogic.processMove(position);
            out.println("Jogada recebida: " + position);
        }
    }

    public void stop() throws IOException {
        in.close();
        out.close();
        clientSocket.close();
        serverSocket.close();
    }
}
