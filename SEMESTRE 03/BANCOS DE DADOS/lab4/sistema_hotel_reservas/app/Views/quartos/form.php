<?php
$isEdit = $quartoEditado !== null;
?>
<section class="panel">
    <h1><?= $isEdit ? 'Editar quarto' : 'Novo quarto' ?></h1>

    <form method="post" action="index.php?route=<?= $isEdit ? 'quartos.edit&id=' . (int) $quartoEditado['id_quarto'] : 'quartos.create' ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
        <div class="grid">
            <label>
                Número
                <input type="text" name="numero" value="<?= htmlspecialchars($quartoEditado['numero'] ?? '') ?>" maxlength="10" required>
            </label>
            <label>
                Tipo
                <input type="text" name="tipo" value="<?= htmlspecialchars($quartoEditado['tipo'] ?? '') ?>" maxlength="40" required>
            </label>
            <label>
                Capacidade
                <input type="number" name="capacidade" min="1" value="<?= htmlspecialchars((string) ($quartoEditado['capacidade'] ?? 1)) ?>" required>
            </label>
            <label>
                Diária
                <input type="number" name="diaria" min="0" step="0.01" value="<?= htmlspecialchars((string) ($quartoEditado['diaria'] ?? '0.00')) ?>" required>
            </label>
            <label>
                Status
                <select name="status" required>
                    <?php foreach ($statusQuarto as $status): ?>
                        <option value="<?= htmlspecialchars($status) ?>" <?= ($quartoEditado['status'] ?? 'disponivel') === $status ? 'selected' : '' ?>>
                            <?= htmlspecialchars($status) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="actions">
            <button type="submit">Salvar</button>
            <a class="button secondary" href="index.php?route=quartos">Voltar</a>
        </div>
    </form>
</section>
