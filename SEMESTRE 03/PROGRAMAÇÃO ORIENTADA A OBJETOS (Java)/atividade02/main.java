import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        BombaCombustivel bomba = new BombaCombustivel("Gasolina", 5.59, 5000);

        System.out.println("Bomba de Combustível do Sr Filipe Marra!");

        boolean sair = false;
        while (!sair) {
            System.out.println("\nEscolha uma opção:");
            System.out.println("1 - Abastecer por valor");
            System.out.println("2 - Abastecer por litro");
            System.out.println("3 - Alterar valor do combustível");
            System.out.println("4 - Alterar tipo do combustível");
            System.out.println("5 - Alterar quantidade de combustível na bomba");
            System.out.println("6 - Sair");
            System.out.print("Opção: ");
            int opcao = scanner.nextInt();

            switch (opcao) {
                case 1:
                    System.out.print("Informe o valor a ser abastecido: R$ ");
                    double valor = scanner.nextDouble();
                    bomba.abastecerPorValor(valor);
                    break;
                case 2:
                    System.out.print("Informe a quantidade de litros: ");
                    double litros = scanner.nextDouble();
                    bomba.abastecerPorLitro(litros);
                    break;
                case 3:
                    System.out.print("Informe o novo valor do litro: R$ ");
                    double novoValor = scanner.nextDouble();
                    bomba.alterarValor(novoValor);
                    System.out.println("Valor do litro atualizado.");
                    break;
                case 4:
                    System.out.print("Informe o novo tipo de combustível: ");
                    scanner.nextLine(); // Limpa o buffer do scanner
                    String novoTipo = scanner.nextLine();
                    bomba.alterarCombustivel(novoTipo);
                    System.out.println("Tipo de combustível atualizado.");
                    break;
                case 5:
                    System.out.print("Informe a nova quantidade de combustível na bomba (em litros): ");
                    double novaQuantidade = scanner.nextDouble();
                    bomba.alterarQuantidadeCombustivel(novaQuantidade);
                    System.out.println("Quantidade de combustível na bomba atualizada.");
                    break;
                case 6:
                    sair = true;
                    System.out.println("Encerrando o programa...");
                    break;
                default:
                    System.out.println("Opção inválida.");
                    break;
            }    

            if (!sair) {
                System.out.println("Valor total abastecido até agora: R$ " + String.format("%.2f", bomba.getTotalAbastecido()));
            }
        }

        System.out.println("Valor total abastecido na bomba: R$ " + String.format("%.2f", bomba.getTotalAbastecido()));
        scanner.close();
    }
}
