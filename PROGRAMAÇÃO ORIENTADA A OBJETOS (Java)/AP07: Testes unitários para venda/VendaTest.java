import org.junit.jupiter.api.Test;
import static org.junit.jupiter.api.Assertions.*;

public class VendaTest {

    @Test
    public void testVendaInicializadaCorretamente() {
        Venda venda = new Venda("Cliente Teste");
        assertEquals("Cliente Teste", venda.getCliente());
        assertEquals(Venda.SITUACAO_NAO_INICIADA, venda.getSituacao());
    }

    @Test
    public void testValorTotalVenda() {
        Venda venda = new Venda("Cliente Teste");
        venda.vender("Produto 1", 100.0, 2.0);
        venda.vender("Produto 2", 50.0, 1.0);
        assertEquals(250.0, venda.getValor());
    }

    @Test
    public void testAplicarDescontoEmVendaNaoIniciada() {
        Venda venda = new Venda("Cliente Teste");
        boolean result = venda.aplicarDesconto(10.0);
        assertFalse(result);
    }

    @Test
    public void testAplicarDescontoEmVendaEmAndamento() {
        Venda venda = new Venda("Cliente Teste");
        venda.vender("Produto 1", 100.0, 2.0);
        boolean result = venda.aplicarDesconto(10.0);
        assertTrue(result);
    }

    @Test
    public void testFinalizarVendaNaoIniciada() {
        Venda venda = new Venda("Cliente Teste");
        Exception exception = assertThrows(RuntimeException.class, venda::finalizar);
        assertEquals("venda não iniciada", exception.getMessage());
    }

    @Test
    public void testFinalizarVendaEmAndamento() {
        Venda venda = new Venda("Cliente Teste");
        venda.vender("Produto 1", 100.0, 2.0);
        venda.finalizar();
        assertEquals(Venda.SITUACAO_ENCERRADA, venda.getSituacao());
    }
}
