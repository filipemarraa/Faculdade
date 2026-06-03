<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();

        $this->view('home/index', [
            'title' => 'Painel',
            'usuario' => Auth::user(),
            'podeCadastrarUsuario' => Auth::temPermissao('usuario_criar'),
        ]);
    }
}
