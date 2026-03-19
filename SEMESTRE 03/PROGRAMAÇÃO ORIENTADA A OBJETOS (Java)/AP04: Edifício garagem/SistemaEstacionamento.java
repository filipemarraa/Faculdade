import java.util.Scanner;

public class SistemaEstacionamento {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        String tipo;
        double peso, volume;
        boolean carregado;

        System.out.println("Informe o tipo de veículo (motocicleta, carro de passeio, caminhonete, furgao):");
        tipo = scanner.nextLine().toLowerCase();
        
        System.out.println("Informe o peso do veículo (em kg):");
        peso = scanner.nextDouble();
        
        volume = 0;
        carregado = false;
        if ("caminhonete".equals(tipo) || "furgao".equals(tipo)) {
            System.out.println("Informe o volume do veículo (em m³):");
            volume = scanner.nextDouble();
            System.out.println("O veículo está carregado? (sim/nao):");
            carregado = "sim".equals(scanner.next().toLowerCase());
        }

        Veiculo veiculo = FabricaDeVeiculos.classificarVeiculo(tipo, peso, volume, carregado);

        if (veiculo != null && veiculo.isAceito()) {
            System.out.printf("A tarifa por hora é: R$ %.2f%n", veiculo.calcularTarifa());
        } else {
            System.out.println("Veículo não suportado ou não aceito no estacionamento.");
        }

        scanner.close();
    }
}
