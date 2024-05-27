package org.example;

import java.sql.*;

public class Conexao {
    public static final String URL = "jdbc:mysql://localhost:3306/peoplesign";
    private static final String USUARIO = "root";
    private static final String SENHA = "D4tabases";

    public static Connection conectarBD() {
        Connection conexao = null;
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            conexao = DriverManager.getConnection(URL, USUARIO, SENHA);
        } catch (SQLException e) {
            e.printStackTrace();
        } catch (ClassNotFoundException e) {
            throw new RuntimeException(e);
        }
        return conexao;
    }

    public static void criarTabela(Connection conexao) throws SQLException {
        String query = "CREATE TABLE IF NOT EXISTS produtos (" +
                "id INT AUTO_INCREMENT PRIMARY KEY, " +
                "tipo VARCHAR(255) NOT NULL, " +
                "descricao TEXT NOT NULL, " +
                "peso FLOAT NOT NULL, " +
                "quantidade INT NOT NULL, " +
                "medida ENUM('METRO', 'METRO_QUADRADO', 'LITRO', 'KG') NOT NULL)";
        Statement stmt = conexao.createStatement();
        stmt.execute(query);
    }

    public static void inserirProduto(Connection conexao, String tipo, String descricao, float peso, int quantidade, Medida medida) {
        String query = "INSERT INTO produtos (tipo, descricao, peso, quantidade, medida) VALUES (?, ?, ?, ?, ?)";

        try (PreparedStatement pstmt = conexao.prepareStatement(query)) {
            pstmt.setString(1, tipo);
            pstmt.setString(2, descricao);
            pstmt.setFloat(3, peso);
            pstmt.setInt(4, quantidade);
            pstmt.setString(5, medida.name());
            pstmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static void listarProdutos(Connection conexao) throws SQLException {
        String query = "SELECT id, tipo, descricao, peso, quantidade, medida FROM produtos";
        Statement stmt = conexao.createStatement();
        ResultSet rs = stmt.executeQuery(query);
        while (rs.next()) {
            int produtoId = rs.getInt("id");
            String produtoTipo = rs.getString("tipo");
            String produtoDescricao = rs.getString("descricao");
            float produtoPeso = rs.getFloat("peso");
            int produtoQuantidade = rs.getInt("quantidade");
            String produtoMedida = rs.getString("medida");

            System.out.println("ID: " + produtoId);
            System.out.println("Tipo: " + produtoTipo);
            System.out.println("Descrição: " + produtoDescricao);
            System.out.println("Peso: " + produtoPeso);
            System.out.println("Quantidade: " + produtoQuantidade);
            System.out.println("Medida: " + produtoMedida);
            System.out.println("------------------------------");        
        }
        rs.close();
        stmt.close();
    }

    public static void deletarProduto(Connection conexao, int id) {
        String query = "DELETE FROM produtos WHERE id = ?";

        try (PreparedStatement pstmt = conexao.prepareStatement(query)) {
            pstmt.setInt(1, id);
            int rowsAffected = pstmt.executeUpdate();
            if (rowsAffected > 0) {
                System.out.println("Produto deletado com sucesso!");
            } else {
                System.out.println("Produto com ID " + id + " não encontrado.");
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static void editarProduto(Connection conexao, int id, String tipo, String descricao, float peso, int quantidade, Medida medida) {
        String query = "UPDATE produtos SET tipo = ?, descricao = ?, peso = ?, quantidade = ?, medida = ? WHERE id = ?";
        try (PreparedStatement pstmt = conexao.prepareStatement(query)) {
            pstmt.setString(1, tipo);
            pstmt.setString(2, descricao);
            pstmt.setFloat(3, peso);
            pstmt.setInt(4, quantidade);
            pstmt.setString(5, medida.name());
            pstmt.setInt(6, id);

            int rowsAffected = pstmt.executeUpdate();
            if (rowsAffected > 0) {
                System.out.println("Produto atualizado com sucesso!");
            } else {
                System.out.println("Produto com ID " + id + " não encontrado.");
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }
}
