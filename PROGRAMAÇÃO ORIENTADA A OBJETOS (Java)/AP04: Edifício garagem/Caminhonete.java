public class Caminhonete extends Veiculo {
    private boolean carregada;

    public Caminhonete(double peso, double volume, boolean carregada) {
        super(peso, volume);
        this.carregada = carregada;
    }

    public double calcularTarifa() {
        return carregada ? 50.00 : 25.00;
    }

    public boolean isAceito() {
        return this.peso <= 6000 && this.volume <= 18;
    }
}
