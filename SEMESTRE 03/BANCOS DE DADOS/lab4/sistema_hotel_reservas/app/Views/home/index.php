<section class="panel">
    <h1>Painel do hotel</h1>
    <p>Usuário logado: <strong><?= htmlspecialchars($usuario['nome']) ?></strong></p>
    <p>Perfil: <strong><?= htmlspecialchars($usuario['tipo_descricao']) ?></strong></p>

    <div class="actions">
        <a class="button" href="index.php?route=reservas">Reservas</a>
        <a class="button secondary" href="index.php?route=quartos">Quartos</a>
        <a class="button secondary" href="index.php?route=usuarios">Usuários</a>
        <?php if ($podeVisualizarDashboard): ?>
            <a class="button secondary" href="index.php?route=dashboard">Painel analítico</a>
        <?php endif; ?>
        <?php if ($podeCadastrarUsuario): ?>
            <a class="button secondary" href="index.php?route=usuarios.create">Cadastrar usuário</a>
        <?php endif; ?>
    </div>
</section>

<section class="panel">
    <h2>Fluxo de demonstração</h2>
    <p>Use este painel para apresentar o ciclo completo: autenticação por perfil, cadastro de quartos, criação de reservas, gerenciamento operacional e análise administrativa.</p>
    <ul class="check-list">
        <li>Administrador: gerencia usuários, exclui registros e acessa o painel analítico.</li>
        <li>Gerência: acompanha reservas e mantém quartos, sem permissões administrativas críticas.</li>
        <li>Usuário comum: cria reservas e acompanha somente seus próprios dados.</li>
    </ul>
</section>
