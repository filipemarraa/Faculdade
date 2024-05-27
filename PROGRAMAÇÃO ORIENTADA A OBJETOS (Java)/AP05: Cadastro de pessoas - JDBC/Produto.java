package org.example;

public class Produto {
    private String tipo;
    private String descricao;
    private double peso;
    private int quantidade;
    private Medida unidadeMedida;

    public Produto(String tipo, String descricao, double peso, int quantidade, Medida unidadeMedida) {
        this.tipo = tipo;
        this.descricao = descricao;
        this.peso = peso;
        this.quantidade = quantidade;
        this.unidadeMedida = unidadeMedida;
    }

    public String getTipo() {
        return tipo;
    }

    public String getDescricao() {
        return descricao;
    }

    public double getPeso() {
        return peso;
    }

    public int getQuantidade() {
        return quantidade;
    }

    public Medida getUnidadeMedida() {
        return unidadeMedida;
    }

    @Override
    public String toString() {
        return "Produto{" +
               "tipo='" + tipo + '\'' +
               ", descricao='" + descricao + '\'' +
               ", peso=" + peso +
               ", quantidade=" + quantidade +
               ", unidadeMedida=" + unidadeMedida +
               '}';
    }
}
