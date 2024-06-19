package br.edu.idp.tech.poo;

import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.ServerSocket;
import java.net.Socket;

public class Servidor {

    public void iniciar(int porta) {
        ObjectOutputStream saida;
        ObjectInputStream entrada;
        boolean sair = false;
        String mensagem = "";

        try {
            // Criando um socket para ouvir na porta e com uma fila de tamanho 10
            ServerSocket servidor = new ServerSocket(porta, 10);
            Socket conexao;
            while (!sair) {
                System.out.println("Ouvindo na porta: " + porta);

                // Ficará bloqueado aqui até que algum cliente se conecte
                conexao = servidor.accept();

                System.out.println("Conexão estabelecida com: " + conexao.getInetAddress().getHostAddress());

                // Obtendo os fluxos de entrada e de saída
                saida = new ObjectOutputStream(conexao.getOutputStream());
                entrada = new ObjectInputStream(conexao.getInputStream());

                // Enviando a mensagem inicial ao cliente
                saida.writeObject("Conexão estabelecida com sucesso...\n");

                do {
                    try {
                        // Obtendo a mensagem enviada pelo cliente
                        mensagem = (String) entrada.readObject();
                        System.out.println("Cliente>> " + mensagem);

                        // Mensagem prolixa para o cliente
                        String mensagemProlixa = "A sua mensagem foi enviada para Melkor e ele respondeu:\n>> " + mensagem + "\n(a mensagem original foi \"" + mensagem + "\")";
                        saida.writeObject(mensagemProlixa);
                    } catch (IOException iOException) {
                        System.err.println("Erro: " + iOException.toString());
                    }
                } while (!mensagem.equals("FIM"));

                System.out.println("Conexão encerrada pelo cliente");
                sair = true;
                saida.close();
                entrada.close();
                conexao.close();

            }

        } catch (Exception e) {
            System.err.println("Erro: " + e.toString());
        }
    }

    public static void main(String[] args) {
        int porta = -1;

        // Verificando se foi informado 1 argumento de linha de comando
        if (args.length < 1) {
            System.err.println("Uso: java tcp.Servidor <porta>");
            System.exit(1);
        }

        try { // Para garantir que somente inteiros sejam atribuídos à porta

            porta = Integer.parseInt(args[0]);

        } catch (Exception e) {
            System.err.println("Erro: " + e.toString());
            System.exit(1);
        }

        if (porta < 1024) {
            System.err.println("A porta deve ser maior que 1024.");
            System.exit(1);
        }

        Servidor s = new Servidor();
        s.iniciar(porta);
    }

}
