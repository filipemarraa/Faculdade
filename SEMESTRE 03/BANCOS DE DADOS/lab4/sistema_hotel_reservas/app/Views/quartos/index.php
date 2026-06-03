<section class="panel">
    <div class="header-row">
        <h1>Quartos</h1>
        <?php if ($podeGerenciarQuartos): ?>
            <a class="button" href="index.php?route=quartos.create">Novo quarto</a>
        <?php endif; ?>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Tipo</th>
                    <th>Capacidade</th>
                    <th>Diária</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quartos as $quarto): ?>
                    <tr>
                        <td><?= htmlspecialchars($quarto['numero']) ?></td>
                        <td><?= htmlspecialchars($quarto['tipo']) ?></td>
                        <td><?= (int) $quarto['capacidade'] ?> pessoa(s)</td>
                        <td>R$ <?= number_format((float) $quarto['diaria'], 2, ',', '.') ?></td>
                        <td><span class="badge"><?= htmlspecialchars($quarto['status']) ?></span></td>
                        <td class="actions-cell">
                            <?php if ($podeGerenciarQuartos): ?>
                                <a href="index.php?route=quartos.edit&id=<?= (int) $quarto['id_quarto'] ?>">Editar</a>
                            <?php endif; ?>
                            <?php if ($podeExcluirQuartos): ?>
                                <form class="inline-form" method="post" action="index.php?route=quartos.delete&id=<?= (int) $quarto['id_quarto'] ?>" onsubmit="return confirm('Remover este quarto?')">
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
