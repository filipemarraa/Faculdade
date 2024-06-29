import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.IOException;

public class GameUI {
    private JFrame frame;
    private JTextField addressField;
    private JTextField positionField;
    private JTextArea logArea;
    private JButton connectButton;
    private JButton awaitButton;
    private JButton playButton;
    private JLabel nrJogadasLabel;
    private JLabel naviosRestantesLabel;

    private Server server;
    private Client client;
    private boolean isServer;
    private GameLogic gameLogic;

    public GameUI() {
        gameLogic = new GameLogic();
    }

    public void createAndShowGUI() {
        frame = new JFrame("Batalha Navalix");
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.setSize(600, 600);

        Container container = frame.getContentPane();
        container.setLayout(new BorderLayout());

        JPanel gridPanel = new JPanel(new GridLayout(9, 9));
        gridPanel.setPreferredSize(new Dimension(400, 400));

        for (int i = 0; i < 9; i++) {
            for (int j = 0; j < 9; j++) {
                if (i == 0 && j == 0) {
                    gridPanel.add(new JLabel(""));
                } else if (i == 0) {
                    gridPanel.add(new JLabel(Integer.toString(j), SwingConstants.CENTER));
                } else if (j == 0) {
                    gridPanel.add(new JLabel(Character.toString((char) ('a' + i - 1)), SwingConstants.CENTER));
                } else {
                    gridPanel.add(new JButton());
                }
            }
        }

        container.add(gridPanel, BorderLayout.CENTER);

        JPanel infoPanel = new JPanel(new GridLayout(3, 1));
        nrJogadasLabel = new JLabel("Nr Jogadas: 0");
        naviosRestantesLabel = new JLabel("Navios restantes: 5");

        infoPanel.add(nrJogadasLabel);
        infoPanel.add(naviosRestantesLabel);

        container.add(infoPanel, BorderLayout.EAST);

        JPanel panel = new JPanel(new GridLayout(2, 1));
        addressField = new JTextField();
        positionField = new JTextField();
        panel.add(new JLabel("Endereço"));
        panel.add(addressField);
        panel.add(new JLabel("Posição"));
        panel.add(positionField);

        container.add(panel, BorderLayout.NORTH);

        connectButton = new JButton("Conectar");
        awaitButton = new JButton("Aguardar jogador");
        playButton = new JButton("Jogar");
        JPanel buttonPanel = new JPanel();
        buttonPanel.add(connectButton);
        buttonPanel.add(awaitButton);
        buttonPanel.add(playButton);

        container.add(buttonPanel, BorderLayout.SOUTH);

        logArea = new JTextArea();
        container.add(new JScrollPane(logArea), BorderLayout.WEST);

        connectButton.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                connectToServer();
            }
        });

        awaitButton.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                startServer();
            }
        });

        playButton.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                sendMove();
            }
        });

        frame.setVisible(true);
    }

    private void connectToServer() {
        try {
            client = new Client();
            client.connect(addressField.getText(), 12345);
            isServer = false;
            logArea.append("Conectado ao servidor\n");
        } catch (IOException ex) {
            logArea.append("Erro ao conectar: " + ex.getMessage() + "\n");
        }
    }

    private void startServer() {
        try {
            server = new Server(gameLogic);
            new Thread(() -> {
                try {
                    server.start(12345);
                    isServer = true;
                    logArea.append("Servidor iniciado, aguardando jogador...\n");
                    server.receiveMove();
                } catch (IOException ex) {
                    logArea.append("Erro no servidor: " + ex.getMessage() + "\n");
                }
            }).start();
        } catch (Exception ex) {
            logArea.append("Erro ao iniciar servidor: " + ex.getMessage() + "\n");
        }
    }

    private void sendMove() {
        String position = positionField.getText();
        if (isServer) {
            logArea.append("Servidor não pode enviar jogada\n");
        } else {
            client.sendMove(position);
            logArea.append("Jogada enviada: " + position + "\n");
            gameLogic.processMove(position);
            nrJogadasLabel.setText("Nr Jogadas: " + gameLogic.getNrJogadas());
            naviosRestantesLabel.setText("Navios restantes: " + gameLogic.getNaviosRestantes());
        }
    }

    public static void main(String[] args) {
        GameUI gameUI = new GameUI();
        gameUI.createAndShowGUI();
    }
}
