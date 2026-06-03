<section class="panel">
    <div class="header-row">
        <h1>Usuários</h1>
        <?php if ($podeCadastrarUsuario): ?>
            <a class="button" href="index.php?route=usuarios.create">Novo usuário</a>
        <?php endif; ?>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Perfil</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['nome']) ?></td>
                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                        <td><?= htmlspecialchars($usuario['tipo_descricao']) ?></td>
                        <td class="actions-cell">
                            <a href="index.php?route=usuarios.edit&id=<?= (int) $usuario['id_usuario'] ?>">Editar</a>
                            <?php if ($podeExcluirUsuario): ?>
                                <form class="inline-form" method="post" action="index.php?route=usuarios.delete&id=<?= (int) $usuario['id_usuario'] ?>" onsubmit="return confirm('Remover este usuário?')">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                    <button class="link danger" type="submit">Excluir</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
