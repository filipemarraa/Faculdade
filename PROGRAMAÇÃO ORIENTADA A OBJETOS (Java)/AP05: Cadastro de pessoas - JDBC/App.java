package org.example;

import java.sql.Connection;
import java.sql.SQLException;

public class App {
    public static void main(String[] args) {
        Connection conexao = Conexao.conectarBD();

        try {
            Conexao.criarTabela(conexao);
            Conexao.inserirProduto(conexao, "Informática", "Mouse Gamer", 0.2f, 100, Medida.KG);
            Conexao.inserirProduto(conexao, "Casa", "Lâmpada LED", 0.05f, 200, Medida.KG);
            System.out.println("Produtos Iniciais:");
            Conexao.listarProdutos(conexao);
            Conexao.editarProduto(conexao, 1, "Informática", "Mouse Gamer RGB", 0.2f, 150, Medida.KG);
            System.out.println("Produtos Após Edição:");
            Conexao.listarProdutos(conexao);
            Conexao.deletarProduto(conexao, 2);
            System.out.println("Produtos Após Deletar:");
            Conexao.listarProdutos(conexao);
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }
}
