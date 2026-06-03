<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuários - Soft Delete</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 40px auto; padding: 0 20px; }
        h2 { color: #333; }
        input { display: block; width: 100%; padding: 8px; margin: 6px 0 14px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 20px; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn-verde  { background: #4CAF50; } .btn-verde:hover  { background: #45a049; }
        .btn-azul   { background: #2196F3; } .btn-azul:hover   { background: #1976D2; }
        .btn-vermelho { background: #f44336; } .btn-vermelho:hover { background: #d32f2f; }
        .btn-laranja  { background: #FF9800; } .btn-laranja:hover  { background: #F57C00; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f2f2f2; }
        #msg { margin-top: 10px; font-weight: bold; }
        .secao-deletados { margin-top: 40px; border-top: 2px dashed #f44336; padding-top: 20px; }
        .secao-deletados h2 { color: #f44336; }
        .deleted-at { font-size: 0.85em; color: #888; }
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

    <button type="submit" class="btn-verde">Cadastrar</button>
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
            <th>Ações</th>
        </tr>
    </thead>
    <tbody id="tabela"></tbody>
</table>

<!-- Seção de usuários deletados (lixeira) -->
<div class="secao-deletados">
    <h2>🗑️ Lixeira (Soft Delete)</h2>
    <p>Usuários removidos ainda existem no banco com <code>deleted_at</code> preenchido.</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Nascimento</th>
                <th>Deletado em</th>
                <th>Restaurar</th>
            </tr>
        </thead>
        <tbody id="tabelaDeletados"></tbody>
    </table>
</div>

<script>
const controller = '../app/controllers/UsuarioController.php';

function mostrarMsg(texto, cor) {
    const msg = document.getElementById('msg');
    msg.style.color = cor;
    msg.textContent = texto;
}

function carregarUsuarios() {
    fetch(controller + '?acao=listar')
        .then(res => res.json())
        .then(data => {
            const tabela = document.getElementById('tabela');
            tabela.innerHTML = '';
            data.forEach(u => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${u.id}</td>
                    <td>${u.nome}</td>
                    <td>${u.email}</td>
                    <td>${u.nascimento}</td>
                    <td>
                        <button class="btn-vermelho" onclick="excluir(${u.id})">Excluir</button>
                    </td>`;
                tabela.appendChild(tr);
            });
        });
}

function carregarDeletados() {
    fetch(controller + '?acao=listarDeletados')
        .then(res => res.json())
        .then(data => {
            const tabela = document.getElementById('tabelaDeletados');
            tabela.innerHTML = '';
            if (data.length === 0) {
                tabela.innerHTML = '<tr><td colspan="6" style="text-align:center;color:#888">Nenhum usuário deletado</td></tr>';
                return;
            }
            data.forEach(u => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${u.id}</td>
                    <td>${u.nome}</td>
                    <td>${u.email}</td>
                    <td>${u.nascimento}</td>
                    <td class="deleted-at">${u.deleted_at}</td>
                    <td>
                        <button class="btn-laranja" onclick="restaurar(${u.id})">Restaurar</button>
                    </td>`;
                tabela.appendChild(tr);
            });
        });
}

// Soft Delete: envia para o controller que faz UPDATE deleted_at = NOW()
function excluir(id) {
    if (!confirm('Tem certeza que deseja excluir este usuário?')) return;
    const formData = new FormData();
    formData.append('id', id);
    fetch(controller + '?acao=excluir', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.sucesso) {
                mostrarMsg('Usuário movido para a lixeira (Soft Delete).', 'orange');
                carregarUsuarios();
                carregarDeletados();
            } else {
                mostrarMsg(data.erro, 'red');
            }
        });
}

function restaurar(id) {
    const formData = new FormData();
    formData.append('id', id);
    fetch(controller + '?acao=restaurar', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.sucesso) {
                mostrarMsg('Usuário restaurado com sucesso!', 'green');
                carregarUsuarios();
                carregarDeletados();
            } else {
                mostrarMsg(data.erro, 'red');
            }
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
            if (data.sucesso) {
                mostrarMsg('Usuário cadastrado com sucesso!', 'green');
                document.getElementById('formCadastro').reset();
                carregarUsuarios();
            } else {
                mostrarMsg(data.erro, 'red');
            }
        });
});

carregarUsuarios();
carregarDeletados();
</script>

</body>
</html>
