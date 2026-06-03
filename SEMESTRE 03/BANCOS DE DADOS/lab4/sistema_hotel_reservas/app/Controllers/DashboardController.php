<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Dashboard;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();

        if (!Auth::temPermissao('dashboard_visualizar')) {
            $this->flash('erro', 'O painel analítico é restrito a administradores.');
            $this->redirect('home');
        }

        $this->view('dashboard/index', [
            'title' => 'Painel analítico',
            'indicadores' => (new Dashboard())->indicadores(),
        ]);
    }
}
