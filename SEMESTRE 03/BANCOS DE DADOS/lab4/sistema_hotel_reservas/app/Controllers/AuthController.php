<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf('login');

            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';

            $usuario = (new Usuario())->authenticate($email, $senha);
            if ($usuario) {
                Auth::login($usuario);
                $this->redirect('home');
            }

            $this->flash('erro', 'Email ou senha são inválidos.');
        }

        $this->view('auth/login', ['title' => 'Login']);
    }

    public function logout(): void
    {
        Auth::logout();
        header('Location: index.php?route=login');
        exit;
    }
}
