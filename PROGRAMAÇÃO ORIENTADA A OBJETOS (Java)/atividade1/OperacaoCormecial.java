class OperacaoComercial {
    Item item;

    public OperacaoComercial(Item item) {
        this.item = item;
    }

    public void detalharOperacao() {
        double imposto = item.calcularImpostoTotal();
        double precoFinal = item.precoBase + imposto;
        System.out.println("Item: " + item.getDescricao());
        System.out.println("Preço Base: R$" + item.getPrecoBase());
        System.out.println("Imposto: R$" + imposto);
        System.out.println("Preço Final: R$" + precoFinal);
    }
}
