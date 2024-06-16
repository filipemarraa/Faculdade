import org.junit.jupiter.api.Test;
import static org.junit.jupiter.api.Assertions.*;

public class ItemTest {

    @Test
    public void testItemInicializadoCorretamente() {
        Item item = new Item("Produto Teste", 2.0, 100.0);
        assertEquals("Produto Teste", item.getProduto());
        assertEquals(2.0, item.getQuantidade());
        assertEquals(100.0, item.getPrecoUnitario());
    }

    @Test
    public void testValorUnitarioItem() {
        Item item = new Item("Produto Teste", 2.0, 100.0);
        assertEquals(200.0, item.getValorUnitario());
    }

    @Test
    public void testAplicarDescontoExcedeLimite() {
        Item item = new Item("Produto Teste", 2.0, 100.0);
        boolean result = item.aplicarDesconto(80.0);
        assertFalse(result);
    }

    @Test
    public void testAplicarDescontoDentroDoLimite() {
        Item item = new Item("Produto Teste", 2.0, 100.0);
        boolean result = item.aplicarDesconto(50.0);
        assertTrue(result);
        assertEquals(50.0, item.getPrecoUnitario());
    }
}
