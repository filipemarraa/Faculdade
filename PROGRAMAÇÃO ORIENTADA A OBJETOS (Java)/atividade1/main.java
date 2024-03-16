public class Main {
    public static void main(String[] args) {
        Item produto = new Item("produto", 100, "Luz");
        Item servicoMecanico = new Item("servico", 200, "Mecânico e Peças");
        Item servicoEletricista = new Item("servico", 150, "Eletricista");

        OperacaoComercial operacao1 = new OperacaoComercial(produto);
        OperacaoComercial operacao2 = new OperacaoComercial(servicoMecanico);
        OperacaoComercial operacao3 = new OperacaoComercial(servicoEletricista);

        operacao1.detalharOperacao();
        System.out.println("---------------------------");
        operacao2.detalharOperacao();
        System.out.println("---------------------------");
        operacao3.detalharOperacao();
    }
}
