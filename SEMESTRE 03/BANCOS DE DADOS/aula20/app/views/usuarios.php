<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuários</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 0 20px; }
        h2 { color: #333; }
        input { display: block; width: 100%; padding: 8px; margin: 6px 0 14px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #45a049; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f2f2f2; }
        #msg { margin-top: 10px; color: green; font-weight: bold; }
    </style>
</head>
<body>

<h2>Cadastro de Usuário</h2>
<form id="formCadastro">
    <label>Nome:</label>
    <input type="text" id="nome" required>

    <label>E-mail:</label>
    <input type="email" id="email" required>

    <label>Nascimento:</label>
    <input type="date" id="nascimento" required>

    <button type="submit">Cadastrar</button>
</form>
<p id="msg"></p>

<h2>Usuários Cadastrados</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Nascimento</th>
        </tr>
    </thead>
    <tbody id="tabela"></tbody>
</table>

<script>
const controller = '../app/controllers/UsuarioController.php';

function carregarUsuarios() {
    fetch(controller + '?acao=listar')
        .then(res => res.json())
        .then(data => {
            const tabela = document.getElementById('tabela');
            tabela.innerHTML = '';
            data.forEach(u => {
                const tr = document.createElement('tr');
                tr.innerHTML = `<td>${u.id}</td><td>${u.nome}</td><td>${u.email}</td><td>${u.nascimento}</td>`;
                tabela.appendChild(tr);
            });
        });
}

document.getElementById('formCadastro').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append('nome', document.getElementById('nome').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('nascimento', document.getElementById('nascimento').value);

    fetch(controller + '?acao=salvar', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            const msg = document.getElementById('msg');
            if (data.sucesso) {
                msg.style.color = 'green';
                msg.textContent = 'Usuário cadastrado com sucesso!';
                document.getElementById('formCadastro').reset();
                carregarUsuarios();
            } else {
                msg.style.color = 'red';
                msg.textContent = data.erro;
            }
        });
});

carregarUsuarios();
</script>

</body>
</html>
