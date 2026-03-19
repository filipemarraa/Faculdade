public class Furgao extends Veiculo {
    private boolean carregado;

    public Furgao(double peso, double volume, boolean carregado) {
        super(peso, volume);
        this.carregado = carregado;
    }

    public double calcularTarifa() {
        return carregado ? 50.00 : 25.00;
    }

    public boolean isAceito() {
        return this.peso <= 6000 && this.volume <= 18;
    }
}
