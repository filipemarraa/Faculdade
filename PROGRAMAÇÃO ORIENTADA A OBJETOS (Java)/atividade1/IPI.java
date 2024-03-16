public class IPI implements Imposto {
    @Override
    public double calcular(double valorBase) {
        return valorBase * 0.25;
    }
}
