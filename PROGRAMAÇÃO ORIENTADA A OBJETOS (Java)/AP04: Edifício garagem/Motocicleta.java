public class Motocicleta extends Veiculo {
    public Motocicleta(double peso) {
        super(peso, 0);
    }

    public double calcularTarifa() {
        if (this.peso <= 100) {
            return 2.00;
        } else if (this.peso <= 299.9) {
            return 4.00;
        } else {
            return 10.00;
        }
    }

    public boolean isAceito() {
        return this.peso <= 300;
    }
}
