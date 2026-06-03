<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Quarto;
use App\Models\Reserva;
use App\Models\Usuario;
use RuntimeException;
use Throwable;

class ReservaController extends Controller
{
    private Reserva $reservas;

    public function __construct()
    {
        $this->reservas = new Reserva();
    }

    public function index(): void
    {
        $this->requireLogin();

        $visualizaTodas = Auth::temPermissao('reserva_visualizar_todas');
        $usuarioId = $visualizaTodas ? null : Auth::user()['id_usuario'];

        $this->view('reservas/index', [
            'title' => 'Reservas',
            'reservas' => $this->reservas->all($usuarioId),
            'podeCriarReserva' => Auth::temPermissao('reserva_criar') || $visualizaTodas,
            'podeGerenciarReservas' => Auth::temPermissao('reserva_gerenciar'),
            'podeExcluirReservas' => Auth::isAdmin(),
            'statusReserva' => Reserva::STATUS,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();

        $visualizaTodas = Auth::temPermissao('reserva_visualizar_todas');
        if (!Auth::temPermissao('reserva_criar') && !$visualizaTodas) {
            $this->flash('erro', 'Seu perfil não tem permissão para criar reservas.');
            $this->redirect('reservas');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf('reservas.create');

            $dados = $this->dadosFormulario($visualizaTodas);
            $erros = $this->validarDados($dados);

            if ($erros) {
                $this->flash('erro', implode(' ', $erros));
                $this->redirect('reservas.create');
            }

            try {
                $this->reservas->create($dados);
                $this->flash('sucesso', 'Reserva criada com sucesso. Status inicial: pendente.');
                $this->redirect('reservas');
            } catch (RuntimeException $exception) {
                $this->flash('erro', $exception->getMessage());
                $this->redirect('reservas.create');
            } catch (Throwable) {
                $this->flash('erro', 'Não foi possível criar a reserva.');
                $this->redirect('reservas.create');
            }
        }

        $usuarios = $visualizaTodas ? (new Usuario())->all() : [Auth::user()];

        $this->view('reservas/form', [
            'title' => 'Nova reserva',
            'quartos' => (new Quarto())->disponiveis(),
            'usuarios' => $usuarios,
            'visualizaTodas' => $visualizaTodas,
        ]);
    }

    public function status(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('reservas');
        }

        $this->validateCsrf('reservas');

        if (!Auth::temPermissao('reserva_gerenciar')) {
            $this->flash('erro', 'Seu perfil não tem permissão para gerenciar reservas.');
            $this->redirect('reservas');
        }

        $id = (int) ($_GET['id'] ?? 0);
        $status = $_POST['status'] ?? '';

        try {
            $this->reservas->updateStatus($id, $status);
            $this->flash('sucesso', 'Status da reserva atualizado.');
        } catch (RuntimeException $exception) {
            $this->flash('erro', $exception->getMessage());
        }

        $this->redirect('reservas');
    }

    public function delete(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('reservas');
        }

        $this->validateCsrf('reservas');

        if (!Auth::isAdmin()) {
            $this->flash('erro', 'Apenas administradores podem excluir reservas.');
            $this->redirect('reservas');
        }

        $id = (int) ($_GET['id'] ?? 0);
        $this->reservas->delete($id);
        $this->flash('sucesso', 'Reserva removida com sucesso.');
        $this->redirect('reservas');
    }

    private function dadosFormulario(bool $visualizaTodas): array
    {
        return [
            'id_usuario' => $visualizaTodas ? (int) ($_POST['id_usuario'] ?? 0) : Auth::user()['id_usuario'],
            'id_quarto' => (int) ($_POST['id_quarto'] ?? 0),
            'data_checkin' => $_POST['data_checkin'] ?? '',
            'data_checkout' => $_POST['data_checkout'] ?? '',
            'quantidade_hospedes' => (int) ($_POST['quantidade_hospedes'] ?? 0),
            'observacao' => trim($_POST['observacao'] ?? ''),
        ];
    }

    private function validarDados(array $dados): array
    {
        $erros = [];

        if ($dados['id_usuario'] < 1) {
            $erros[] = 'Selecione um hóspede válido.';
        }

        if ($dados['id_quarto'] < 1) {
            $erros[] = 'Selecione um quarto válido.';
        }

        if ($dados['quantidade_hospedes'] < 1) {
            $erros[] = 'Informe ao menos um hóspede.';
        }

        if (!$dados['data_checkin'] || !$dados['data_checkout']) {
            $erros[] = 'Informe check-in e check-out.';
        }

        return $erros;
    }
}
