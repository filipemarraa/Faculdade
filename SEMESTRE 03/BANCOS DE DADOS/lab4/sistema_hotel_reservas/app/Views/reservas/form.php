<section class="panel">
    <h1>Nova reserva</h1>

    <form method="post" action="index.php?route=reservas.create">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
        <div class="grid">
            <label>
                Hóspede
                <select name="id_usuario" <?= $visualizaTodas ? '' : 'disabled' ?>>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= (int) $usuario['id_usuario'] ?>">
                            <?= htmlspecialchars($usuario['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>
                Quarto
                <select name="id_quarto" required>
                    <?php foreach ($quartos as $quarto): ?>
                        <option value="<?= (int) $quarto['id_quarto'] ?>">
                            <?= htmlspecialchars($quarto['numero'] . ' - ' . $quarto['tipo']) ?>
                            | <?= (int) $quarto['capacidade'] ?> pessoa(s)
                            | R$ <?= number_format((float) $quarto['diaria'], 2, ',', '.') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>
                Check-in
                <input type="date" name="data_checkin" required>
            </label>
            <label>
                Check-out
                <input type="date" name="data_checkout" required>
            </label>
            <label>
                Quantidade de hóspedes
                <input type="number" name="quantidade_hospedes" min="1" value="1" required>
            </label>
            <label>
                Observação
                <input type="text" name="observacao" maxlength="255">
            </label>
        </div>

        <?php if (!$visualizaTodas && $usuarios): ?>
            <input type="hidden" name="id_usuario" value="<?= (int) $usuarios[0]['id_usuario'] ?>">
        <?php endif; ?>

        <div class="actions">
            <button type="submit">Criar reserva</button>
            <a class="button secondary" href="index.php?route=reservas">Voltar</a>
        </div>
    </form>
</section>
