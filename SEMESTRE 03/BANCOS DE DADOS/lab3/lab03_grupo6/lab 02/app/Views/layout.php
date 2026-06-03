<?php

use App\Core\Auth;

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Lab 03 - Usuários') ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topbar">
        <strong>Lab 03 - Usuários</strong>
        <?php if (Auth::check()): ?>
            <nav>
                <a href="index.php?route=home">Painel</a>
                <a href="index.php?route=usuarios">Usuários</a>
                <a href="index.php?route=logout">Sair</a>
            </nav>
        <?php endif; ?>
    </header>

    <main class="container">
        <?php if ($flash): ?>
            <div class="alert <?= htmlspecialchars($flash['type']) ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>

        <?php require $viewPath; ?>
    </main>
</body>
</html>
