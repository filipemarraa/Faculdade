public class FabricaDeVeiculos {
    public static Veiculo classificarVeiculo(String tipo, double peso, double volume, boolean carregado) {
        if (tipo.contains("motocicleta")) {
            return new Motocicleta(peso);
        } else if (tipo.contains("carro de passeio")) {
            if (peso > 2000) {
                return new Furgao(peso, volume, carregado);
            } else {
                return new CarroDePasseio(peso);
            }
        } else if (tipo.contains("caminhonete")) {
            return new Caminhonete(peso, volume, carregado);
        } else if (tipo.contains("furgao")) {
            return new Furgao(peso, volume, carregado);
        } else {
            return null;
        }
    }
}
