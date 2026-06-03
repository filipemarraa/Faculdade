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
            'podeVisualizarDashboard' => Auth::temPermissao('dashboard_visualizar'),
            'podeGerenciarQuartos' => Auth::temPermissao('quarto_gerenciar'),
            'podeVisualizarTodasReservas' => Auth::temPermissao('reserva_visualizar_todas'),
        ]);
    }
}
