<section class="panel">
    <div class="header-row">
        <h1>Reservas</h1>
        <?php if ($podeCriarReserva): ?>
            <a class="button" href="index.php?route=reservas.create">Nova reserva</a>
        <?php endif; ?>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Hóspede</th>
                    <th>Quarto</th>
                    <th>Período</th>
                    <th>Hóspedes</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserva['usuario_nome']) ?></td>
                        <td><?= htmlspecialchars($reserva['quarto_numero'] . ' - ' . $reserva['quarto_tipo']) ?></td>
                        <td><?= htmlspecialchars($reserva['data_checkin']) ?> até <?= htmlspecialchars($reserva['data_checkout']) ?></td>
                        <td><?= (int) $reserva['quantidade_hospedes'] ?></td>
                        <td>R$ <?= number_format((float) $reserva['valor_total'], 2, ',', '.') ?></td>
                        <td><span class="badge"><?= htmlspecialchars($reserva['status']) ?></span></td>
                        <td class="actions-cell">
                            <?php if ($podeGerenciarReservas): ?>
                                <form class="inline-form" method="post" action="index.php?route=reservas.status&id=<?= (int) $reserva['id_reserva'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                    <select class="compact" name="status">
                                        <?php foreach ($statusReserva as $status): ?>
                                            <option value="<?= htmlspecialchars($status) ?>" <?= $reserva['status'] === $status ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($status) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button class="small" type="submit">Atualizar</button>
                                </form>
                            <?php endif; ?>
                            <?php if ($podeExcluirReservas): ?>
                                <form class="inline-form" method="post" action="index.php?route=reservas.delete&id=<?= (int) $reserva['id_reserva'] ?>" onsubmit="return confirm('Remover esta reserva?')">
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
