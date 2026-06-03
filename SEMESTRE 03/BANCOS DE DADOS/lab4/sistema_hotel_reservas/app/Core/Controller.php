<?php

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        $data['csrfToken'] = $this->csrfToken();
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

    protected function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    protected function validateCsrf(string $redirectRoute = 'home'): void
    {
        $token = $_POST['csrf_token'] ?? '';
        if (!is_string($token) || !hash_equals($this->csrfToken(), $token)) {
            $this->flash('erro', 'Requisição inválida. Tente novamente.');
            $this->redirect($redirectRoute);
        }
    }
}
