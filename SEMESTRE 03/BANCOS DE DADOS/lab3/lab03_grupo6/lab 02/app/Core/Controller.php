<?php

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        require __DIR__ . '/../Views/layout.php';
    }

    protected function redirect(string $route): void
    {
        header('Location: index.php?route=' . $route);
        exit;
    }

    protected function requireLogin(): void
    {
        if (!Auth::check()) {
            $this->redirect('login');
        }
    }

    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}
