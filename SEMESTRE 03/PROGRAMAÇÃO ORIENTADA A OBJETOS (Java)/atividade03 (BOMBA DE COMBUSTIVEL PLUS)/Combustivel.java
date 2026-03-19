public class Combustivel {
    private String tipo;
    private double precoPorLitro;
    private double quantidadeDisponivel;
    private double totalAbastecido;

    // Construtor
    public Combustivel(String tipo, double precoPorLitro, double quantidadeDisponivel) {
        this.tipo = tipo;
        this.precoPorLitro = precoPorLitro;
        this.quantidadeDisponivel = quantidadeDisponivel;
        this.totalAbastecido = 0;
    }

    // Métodos getters e setters
    public String getTipo() {
        return tipo;
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

    public double getTotalAbastecido() {
        return totalAbastecido;
    }

    // Método para decrementar a quantidade de combustível
    public void decrementarQuantidade(double quantidade) {
        this.quantidadeDisponivel -= quantidade;
        this.totalAbastecido += quantidade;
    }
}
