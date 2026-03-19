public class BombaCombustivel {
    private String tipoCombustivel;
    private double valorLitro;
    private double quantidadeCombustivel;
    private double totalAbastecido; 

    public BombaCombustivel(String tipoCombustivel, double valorLitro, double quantidadeCombustivel) {
        this.tipoCombustivel = tipoCombustivel;
        this.valorLitro = valorLitro;
        this.quantidadeCombustivel = quantidadeCombustivel;
        this.totalAbastecido = 0; // total abastecido com 0
    }

    public void abastecerPorValor(double valor) {
        double litros = valor / valorLitro;
        if (litros > quantidadeCombustivel) {
            System.out.println("Não há combustível suficiente na bomba para essa operação.");
        } else {
            quantidadeCombustivel -= litros;
            totalAbastecido += valor;
            System.out.println("Foram abastecidos " + litros + " litros de " + tipoCombustivel);
        }
    }

    public void abastecerPorLitro(double litros) {
        double valor = litros * valorLitro;
        if (litros > quantidadeCombustivel) {
            System.out.println("Não há combustível suficiente na bomba para essa operação.");
        } else {
            quantidadeCombustivel -= litros;
            totalAbastecido += valor;
            System.out.println("O valor a ser pago é de R$ " + valor);
        }
    }

    public void alterarValor(double novoValor) {
        this.valorLitro = novoValor;
    }

    public void alterarCombustivel(String novoTipo) {
        this.tipoCombustivel = novoTipo;
    }

    public void alterarQuantidadeCombustivel(double novaQuantidade) {
        this.quantidadeCombustivel = novaQuantidade;
    }

    public double getTotalAbastecido() {
        return totalAbastecido;
    }
}
