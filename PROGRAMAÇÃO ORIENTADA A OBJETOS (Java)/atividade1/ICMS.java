public class ICMS implements Imposto {
    @Override
    public double calcular(double valorBase) {
        return valorBase * 0.17;
    }
}
