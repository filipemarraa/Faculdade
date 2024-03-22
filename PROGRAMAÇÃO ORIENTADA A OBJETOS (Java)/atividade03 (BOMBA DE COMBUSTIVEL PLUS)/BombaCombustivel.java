import java.util.ArrayList;
import java.util.List;

public class BombaCombustivel {
    private List<Combustivel> combustiveis;

    public BombaCombustivel() {
        this.combustiveis = new ArrayList<>();
    }
    
    public void adicionarCombustivel(String tipo, double precoPorLitro, double quantidade) {
        combustiveis.add(new Combustivel(tipo, precoPorLitro, quantidade));
    }

    public void abastecerPorValor(String tipo, double valor) {
        for (Combustivel combustivel : combustiveis) {
            if (combustivel.getTipo().equalsIgnoreCase(tipo)) {
                double litros = valor / combustivel.getPrecoPorLitro();
                if (litros > combustivel.getQuantidadeDisponivel()) {
                    System.out.println("Não há combustível suficiente na bomba para essa operação.");
                    return;
                }

                combustivel.decrementarQuantidade(litros);
                System.out.println("Foram abastecidos " + String.format("%.2f", litros) + " litros de " + tipo);
                return;
            }
        }
        System.out.println("Tipo de combustível não encontrado.");
    }

    public void abastecerPorLitro(String tipo, double litros) {
        for (Combustivel combustivel : combustiveis) {
            if (combustivel.getTipo().equalsIgnoreCase(tipo)) {
                if (litros > combustivel.getQuantidadeDisponivel()) {
                    System.out.println("Não há combustível suficiente na bomba para essa operação.");
                    return;
                }

                double valor = litros * combustivel.getPrecoPorLitro();
                combustivel.decrementarQuantidade(litros);
                System.out.println("O valor a ser pago é de R$ " + String.format("%.2f", valor));
                return;
            }
        }
        System.out.println("Tipo de combustível não encontrado.");
    }

    public void alterarValor(String tipo, double novoValor) {
        for (Combustivel combustivel : combustiveis) {
            if (combustivel.getTipo().equalsIgnoreCase(tipo)) {
                combustivel.setPrecoPorLitro(novoValor);
                System.out.println("Valor do litro de " + tipo + " atualizado para R$ " + String.format("%.2f", novoValor));
                return;
            }
        }
        System.out.println("Tipo de combustível não encontrado.");
    }

    public void alterarQuantidadeCombustivel(String tipo, double novaQuantidade) {
        for (Combustivel combustivel : combustiveis) {
            if (combustivel.getTipo().equalsIgnoreCase(tipo)) {
                combustivel.setQuantidadeDisponivel(novaQuantidade);
                System.out.println("Quantidade de combustível de " + tipo + " atualizada para " + novaQuantidade + " litros.");
                return;
            }
        }
        System.out.println("Tipo de combustível não encontrado.");
    }

    public void mostrarTotaisAbastecidos() {
        for (Combustivel combustivel : combustiveis) {
            System.out.println("Total abastecido de " + combustivel.getTipo() + ": " +
                    String.format("%.2f", combustivel.getTotalAbastecido()) + " litros");
        }
    }

    public void listarTiposCombustivel() {
        int indice = 1;
        System.out.println("Tipos de combustível disponíveis:");
        for (Combustivel combustivel : combustiveis) {
            System.out.println(indice + " - " + combustivel.getTipo());
            indice++;
        }
    }

    public String getTipoCombustivelPorNumero(int numeroEscolhido) {
        if (numeroEscolhido < 1 || numeroEscolhido > combustiveis.size()) {
            System.out.println("Número inválido.");
            return null;
        }
        return combustiveis.get(numeroEscolhido - 1).getTipo();
    }
}
