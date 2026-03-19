-- Questão 1: Liste todos os clientes que residem na cidade "São Paulo".
SELECT * FROM clientes WHERE cidade = 'SÃ£o Paulo';

-- Questão 2: Exiba os nomes e preços de todos os produtos que têm um preço maior que R$ 100,00.
SELECT nome, preco FROM produtos WHERE preco > 100.00;

-- Questão 3: Calcule o número total de pedidos realizados no banco de dados.
SELECT COUNT(*) AS total_pedidos FROM pedidos;

-- Questão 4 - Liste os nomes dos produtos que estão com menos de 10 unidades em estoque.
SELECT nome from produtos WHERE estoque < 10;

-- Questão 5 - Exiba o nome e o email dos clientes que realizaram pelo menos um pedido.
SELECT c.nome, c.email
FROM clientes c 
JOIN pedidos p ON c.id = p.cliente_id 
GROUP BY c.id, c.nome, c.email 

-- Questão 6 - Liste os produtos que foram pedidos pelo menos 3 vezes (com base na tabela itens_pedido).
SELECT p.nome, COUNT(ip.produto_id) AS vezes_pedido
FROM itens_pedido ip
JOIN produtos p ON ip.produto_id = p.id
GROUP BY p.nome
HAVING COUNT(ip.produto_id) >= 3;


-- Questão 7 - Exiba o valor total das transações realizadas em cada dia. Ordene os resultados pela data da transação.
SELECT data_transacao, SUM(valor) AS valor_total
FROM transacoes 
GROUP by data_transacao 
ORDER by data_transacao ASC;

-- Questão 8 - Encontre o valor total gasto por cada cliente em pedidos. Liste o nome do cliente e o valor total.
SELECT c.nome, SUM(ip.quantidade * ip.preco_unitario) AS total_gasto
FROM clientes c 
JOIN pedidos p ON c.id = p.cliente_id 
JOIN itens_pedido ip ON p.id = ip.pedido_id 
GROUP BY c.nome 
ORDER BY total_gasto DESC;

-- Questão 9 - Exiba os pedidos realizados no mês de janeiro de 2024.
SELEC * 
from pedidos 
WHERE data_pedido >= '2024-01-01' AND data_pedido < '2024-02-01'


-- Questão 10 - Calcule a média de preço dos produtos que estão em estoque.
SELECT AVG(preco) AS media_preco
FROM produtos 
WHERE estoque > 0;



