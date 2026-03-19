import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        BombaCombustivel bomba = new BombaCombustivel();
        
        // Adicionando diferentes tipos de combustíveis
        bomba.adicionarCombustivel("Gasolina Comum", 5.59, 5000);
        bomba.adicionarCombustivel("Gasolina Aditivada", 5.99, 4000);
        bomba.adicionarCombustivel("Álcool", 4.49, 6000);
        bomba.adicionarCombustivel("Diesel", 3.99, 7000);

        System.out.println("Bomba de Combustível do Sr Filipe Marra!");

        boolean sair = false;
        while (!sair) {
            System.out.println("\nEscolha uma opção:");
            System.out.println("1 - Abastecer por valor");
            System.out.println("2 - Abastecer por litro");
            System.out.println("3 - Alterar valor do combustível");
            System.out.println("4 - Alterar quantidade de combustível na bomba");
            System.out.println("5 - Sair");
            System.out.print("Opção: ");
            int opcao = scanner.nextInt();

            switch (opcao) {
                case 1:
                bomba.listarTiposCombustivel();
                System.out.print("Escolha o número correspondente ao tipo de combustível: ");
                int escolhaTipo = scanner.nextInt();
                String tipoValor = bomba.getTipoCombustivelPorNumero(escolhaTipo);
                    if (tipoValor != null) {
                    System.out.print("Informe o valor a ser abastecido: R$ ");
                    double valor = scanner.nextDouble();
                    bomba.abastecerPorValor(tipoValor, valor);
                    }
                break;
                case 2:
                bomba.listarTiposCombustivel();
                System.out.print("Escolha o número correspondente ao tipo de combustível: ");
                escolhaTipo = scanner.nextInt();
                String tipoLitro = bomba.getTipoCombustivelPorNumero(escolhaTipo);
                    if (tipoLitro != null) {
                    System.out.print("Informe a quantidade de litros: ");
                    double litros = scanner.nextDouble();
                    bomba.abastecerPorLitro(tipoLitro, litros);
                    }
                break;
                case 3:
                    bomba.listarTiposCombustivel();
                    System.out.print("Escolha o número correspondente ao tipo de combustível para alterar o valor: ");
                    int escolhaAlterarValor = scanner.nextInt();
                    String tipoAlterarValor = bomba.getTipoCombustivelPorNumero(escolhaAlterarValor);
                    if (tipoAlterarValor != null) {
                        System.out.print("Informe o novo valor do litro: R$ ");
                        double novoValor = scanner.nextDouble();
                        bomba.alterarValor(tipoAlterarValor, novoValor);
                    }
                    break;
                case 4:
                    bomba.listarTiposCombustivel();
                    System.out.print("Escolha o número correspondente ao tipo de combustível para alterar a quantidade: ");
                    int escolhaAlterarQuantidade = scanner.nextInt();
                    String tipoAlterarQuantidade = bomba.getTipoCombustivelPorNumero(escolhaAlterarQuantidade);
                    if (tipoAlterarQuantidade != null) {
                        System.out.print("Informe a nova quantidade de combustível na bomba (em litros): ");
                        double novaQuantidade = scanner.nextDouble();
                        bomba.alterarQuantidadeCombustivel(tipoAlterarQuantidade, novaQuantidade);
                    }
                    break;
                case 5:
                    sair = true;
                    System.out.println("Encerrando o programa...");
                    break;
                default:
                    System.out.println("Opção inválida.");
                    break;
            }

            if (!sair) {
                bomba.mostrarTotaisAbastecidos();
            }
        }

        scanner.close();
    }
}
