public abstract class Veiculo {
    protected double peso;
    protected double volume;

    public Veiculo(double peso, double volume) {
        this.peso = peso;
        this.volume = volume;
    }

    public abstract double calcularTarifa();
    public abstract boolean isAceito();
}
