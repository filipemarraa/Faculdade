<section class="panel">
    <h1>Painel</h1>
    <p>Usuário logado: <strong><?= htmlspecialchars($usuario['nome']) ?></strong></p>
    <p>Perfil: <strong><?= htmlspecialchars($usuario['tipo_descricao']) ?></strong></p>

    <div class="actions">
        <a class="button" href="index.php?route=usuarios">Gerenciar usuários</a>
        <?php if ($podeCadastrarUsuario): ?>
            <a class="button secondary" href="index.php?route=usuarios.create">Cadastrar usuário</a>
        <?php endif; ?>
    </div>
</section>
