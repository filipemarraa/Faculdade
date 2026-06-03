<?php
$isEdit = $usuarioEditado !== null;
?>
<section class="panel">
    <h1><?= $isEdit ? 'Editar usuário' : 'Novo usuário' ?></h1>

    <form method="post" action="index.php?route=<?= $isEdit ? 'usuarios.edit&id=' . (int) $usuarioEditado['id_usuario'] : 'usuarios.create' ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
        <div class="grid">
            <label>
                Nome
                <input type="text" name="nome" value="<?= htmlspecialchars($usuarioEditado['nome'] ?? '') ?>" required>
            </label>
            <label>
                Email
                <input type="email" name="email" value="<?= htmlspecialchars($usuarioEditado['email'] ?? '') ?>" required>
            </label>
            <label>
                Senha <?= $isEdit ? '(preencha apenas para alterar)' : '' ?>
                <input type="password" name="senha" <?= $isEdit ? '' : 'required' ?>>
            </label>
            <label>
                Perfil
                <select name="id_tipo_usuario" <?= $podeEditarPerfil ? '' : 'disabled' ?>>
                    <?php foreach ($tipos as $tipo): ?>
                        <option value="<?= (int) $tipo['id_tipo_usuario'] ?>" <?= (int) ($usuarioEditado['id_tipo_usuario'] ?? 0) === (int) $tipo['id_tipo_usuario'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tipo['descricao']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <?php if (!$podeEditarPerfil && $isEdit): ?>
            <input type="hidden" name="id_tipo_usuario" value="<?= (int) $usuarioEditado['id_tipo_usuario'] ?>">
        <?php endif; ?>

        <div class="actions">
            <button type="submit">Salvar</button>
            <a class="button secondary" href="index.php?route=usuarios">Voltar</a>
        </div>
    </form>
</section>
