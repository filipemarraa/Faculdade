<section class="panel">
    <h1>Painel analítico</h1>

    <div class="cards">
        <article class="metric">
            <span>Usuários</span>
            <strong><?= (int) $indicadores['usuarios'] ?></strong>
        </article>
        <article class="metric">
            <span>Quartos</span>
            <strong><?= (int) $indicadores['quartos'] ?></strong>
        </article>
        <article class="metric">
            <span>Reservas</span>
            <strong><?= (int) $indicadores['reservas'] ?></strong>
        </article>
        <article class="metric">
            <span>Receita confirmada</span>
            <strong>R$ <?= number_format((float) $indicadores['receita'], 2, ',', '.') ?></strong>
        </article>
    </div>
</section>

<section class="panel">
    <h2>Reservas por status</h2>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($indicadores['reservasPorStatus'] as $linha): ?>
                    <tr>
                        <td><?= htmlspecialchars($linha['status']) ?></td>
                        <td><?= (int) $linha['total'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<section class="panel">
    <h2>Ocupação por quarto</h2>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Quarto</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Reservas ativas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($indicadores['ocupacaoPorQuarto'] as $linha): ?>
                    <tr>
                        <td><?= htmlspecialchars($linha['numero']) ?></td>
                        <td><?= htmlspecialchars($linha['tipo']) ?></td>
                        <td><?= htmlspecialchars($linha['status']) ?></td>
                        <td><?= (int) $linha['reservas_ativas'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
