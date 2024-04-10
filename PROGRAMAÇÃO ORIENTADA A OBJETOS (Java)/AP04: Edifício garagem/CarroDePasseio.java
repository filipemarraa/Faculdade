public class CarroDePasseio extends Veiculo {
    public CarroDePasseio(double peso) {
        super(peso, 0);
    }

    public double calcularTarifa() {
        if (this.peso <= 1000) {
            return 13.00;
        } else if (this.peso <= 2000) {
            return 15.00;
        } else {
            return 20.00;
        }
    }

    public boolean isAceito() {
        return this.peso <= 2000;
    }
}
