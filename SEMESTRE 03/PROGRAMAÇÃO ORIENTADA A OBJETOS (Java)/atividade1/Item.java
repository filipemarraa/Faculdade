class Item {
    String tipo; 
    double precoBase;
    String descricao;
    List<Imposto> impostos = new ArrayList<>();

    public Item(String tipo, double precoBase, String descricao) {
        this.tipo = tipo;
        this.precoBase = precoBase;
        this.descricao = descricao;
        configurarImpostos();
    }

    private void configurarImpostos() {
        if (tipo.equals("produto")) {
            impostos.add(new ICMS());
            impostos.add(new IPI());
        } else if (tipo.equals("servico")) {
            impostos.add(new ISS());
            impostos.add(new ICMS()); 
        }
    }

    public double calcularImpostoTotal() {
        double totalImposto = 0;
        for (Imposto imposto : impostos) {
            totalImposto += imposto.calcular(precoBase);
        }
        return totalImposto;
    }

    public String getDescricao() {
        return descricao;
    }

    public double getPrecoBase() {
        return precoBase;
    }
}
