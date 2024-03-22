public class Combustivel {
    private String tipo;
    private double precoPorLitro;
    private double quantidadeDisponivel;

    // Construtor
    public Combustivel(String tipo, double precoPorLitro, double quantidadeDisponivel) {
        this.tipo = tipo;
        this.precoPorLitro = precoPorLitro;
        this.quantidadeDisponivel = quantidadeDisponivel;
    }

    // Métodos getters e setters
    public String getTipo() {
        return tipo;
    }

    public void setTipo(String tipo) {
        this.tipo = tipo;
    }

    public double getPrecoPorLitro() {
        return precoPorLitro;
    }

    public void setPrecoPorLitro(double precoPorLitro) {
        this.precoPorLitro = precoPorLitro;
    }

    public double getQuantidadeDisponivel() {
        return quantidadeDisponivel;
    }

    public void setQuantidadeDisponivel(double quantidadeDisponivel) {
        this.quantidadeDisponivel = quantidadeDisponivel;
    }

    // Método para decrementar a quantidade de combustível
    public void decrementarQuantidade(double quantidade) {
        this.quantidadeDisponivel -= quantidade;
    }
}
