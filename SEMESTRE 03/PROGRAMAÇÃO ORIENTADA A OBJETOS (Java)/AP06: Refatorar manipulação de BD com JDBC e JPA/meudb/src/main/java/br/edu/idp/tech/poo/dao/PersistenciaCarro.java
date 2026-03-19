package br.edu.idp.tech.poo.dao;

import br.edu.idp.tech.poo.entidade.Carro;
import java.util.List;

public interface PersistenciaCarro {
    void salvar(Carro carro);
    void salvar(List<Carro> carros);
    List<Carro> findAll();
}
