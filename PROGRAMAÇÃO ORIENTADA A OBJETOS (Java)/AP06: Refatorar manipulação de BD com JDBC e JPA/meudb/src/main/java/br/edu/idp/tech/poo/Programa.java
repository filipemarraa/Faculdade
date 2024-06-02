package br.edu.idp.tech.poo;

import br.edu.idp.tech.poo.dao.PersistenciaCarro;
import br.edu.idp.tech.poo.dao.CarroJdbcDao;
import br.edu.idp.tech.poo.dao.CarroJpaDao;
import br.edu.idp.tech.poo.entidade.Carro;
import br.edu.idp.tech.poo.ui.CliIavel;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

public class Programa {

    private String sufixo;
    private CliIavel ui;

    public Programa(CliIavel cli) {
        this.ui = cli;
    }

    public void executar() {
        sufixo = " /" + gerarLetraAletoria();
        ui.exibirInformacao("Sufixo da execução: " + sufixo);
        prepararBD();

        ui.exibirInformacao("Execução via JDBC - início");
        executarPersistencia(new CarroJdbcDao(), 3);
        ui.exibirInformacao("Execução via JDBC - término");

        ui.exibirInformacao("Execução via JPA - início");
        executarPersistencia(new CarroJpaDao(), 4);
        ui.exibirInformacao("Execução via JPA - término");
    }

    private void executarPersistencia(PersistenciaCarro dao, int quantidadeCarros) {
        CarregadorDados carregador = new CarregadorDados(sufixo);
        List<Carro> novosCarros = carregador.gerarListaCarros(quantidadeCarros);

        for (Carro carro : novosCarros) {
            dao.salvar(carro);
        }

        List<Carro> carros = dao.findAll();
        ui.exibirListaCarros(carros);
    }

    private void prepararBD() {
        try {
            CarroJdbcDao.criarTabela();
        } catch (SQLException e) {
            throw new RuntimeException(e);
        }
    }

    private char gerarLetraAletoria() {
        final int NUM_LETRA_BASE = 97;
        final int QUANTIDADE_LETRAS = 25;
        int numero = GeradorNumAletorio.gerarInt(QUANTIDADE_LETRAS);
        return (char) (NUM_LETRA_BASE + numero);
    }
}
