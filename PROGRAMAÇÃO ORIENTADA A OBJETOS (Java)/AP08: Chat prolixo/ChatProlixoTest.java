package br.edu.idp.tech.poo;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertTrue;

import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.ServerSocket;
import java.net.Socket;

import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;

public class ChatProlixoTest {

    @BeforeEach
    public void setUp() throws Exception {
        // Configuração inicial antes dos testes, se necessário
    }

    @Test
    public void testServidorEnvioMensagem() throws Exception {
        String mensagem = "Olá Melkor, como está a sua eternidade?";
        String respostaEsperada = "A sua mensagem foi enviada para Melkor e ele respondeu:\n>> Olá Melkor, como está a sua eternidade?\n(a mensagem original foi \"Olá Melkor, como está a sua eternidade?\")";

        try (ServerSocket servidor = new ServerSocket(12345);
             Socket conexao = new Socket("localhost", 12345)) {

            Socket clienteSocket = servidor.accept();
            ObjectOutputStream saidaCliente = new ObjectOutputStream(clienteSocket.getOutputStream());
            ObjectInputStream entradaCliente = new ObjectInputStream(clienteSocket.getInputStream());

            saidaCliente.writeObject(mensagem);
            saidaCliente.flush();

            String resposta = (String) entradaCliente.readObject();
            assertEquals(respostaEsperada, resposta);
        }
    }

    @Test
    public void testClienteRecebeMensagem() throws Exception {
        String mensagem = "Olá Melkor, como está a sua eternidade?";
        String respostaEsperada = "A sua mensagem foi enviada para Melkor e ele respondeu:\n>> Olá Melkor, como está a sua eternidade?\n(a mensagem original foi \"Olá Melkor, como está a sua eternidade?\")";

        ByteArrayOutputStream saida = new ByteArrayOutputStream();
        ObjectOutputStream saidaObjeto = new ObjectOutputStream(saida);

        saidaObjeto.writeObject(mensagem);
        saidaObjeto.flush();

        ByteArrayInputStream entrada = new ByteArrayInputStream(saida.toByteArray());
        ObjectInputStream entradaObjeto = new ObjectInputStream(entrada);

        String resposta = (String) entradaObjeto.readObject();
        assertEquals(respostaEsperada, resposta);
    }

    @Test
    public void testConexaoClienteServidor() throws Exception {
        try (ServerSocket servidor = new ServerSocket(12345)) {
            Socket clienteSocket = new Socket("localhost", 12345);
            assertTrue(clienteSocket.isConnected());
        }
    }
}
