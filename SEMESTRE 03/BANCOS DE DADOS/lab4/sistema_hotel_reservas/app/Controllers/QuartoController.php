<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Quarto;
use Throwable;

class QuartoController extends Controller
{
    private Quarto $quartos;

    public function __construct()
    {
        $this->quartos = new Quarto();
    }

    public function index(): void
    {
        $this->requireLogin();

        $this->view('quartos/index', [
            'title' => 'Quartos',
            'quartos' => $this->quartos->all(),
            'podeGerenciarQuartos' => Auth::temPermissao('quarto_gerenciar'),
            'podeExcluirQuartos' => Auth::temPermissao('quarto_excluir'),
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->exigirGerenciamento();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf('quartos.create');
            $dados = $this->dadosFormulario();
            $erros = $this->validarDados($dados);

            if ($erros) {
                $this->flash('erro', implode(' ', $erros));
                $this->redirect('quartos.create');
            }

            try {
                $this->quartos->create($dados);
                $this->flash('sucesso', 'Quarto cadastrado com sucesso.');
                $this->redirect('quartos');
            } catch (Throwable) {
                $this->flash('erro', 'Não foi possível cadastrar o quarto. Verifique se o número já existe.');
                $this->redirect('quartos.create');
            }
        }

        $this->view('quartos/form', [
            'title' => 'Novo quarto',
            'quartoEditado' => null,
            'statusQuarto' => Quarto::STATUS,
        ]);
    }

    public function edit(): void
    {
        $this->requireLogin();
        $this->exigirGerenciamento();

        $id = (int) ($_GET['id'] ?? 0);
        $quarto = $this->quartos->find($id);

        if (!$quarto) {
            $this->flash('erro', 'Quarto não encontrado.');
            $this->redirect('quartos');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf('quartos.edit&id=' . $id);
            $dados = $this->dadosFormulario();
            $erros = $this->validarDados($dados);

            if ($erros) {
                $this->flash('erro', implode(' ', $erros));
                $this->redirect('quartos.edit&id=' . $id);
            }

            try {
                $this->quartos->update($id, $dados);
                $this->flash('sucesso', 'Quarto atualizado com sucesso.');
                $this->redirect('quartos');
            } catch (Throwable) {
                $this->flash('erro', 'Não foi possível atualizar o quarto. Verifique se o número já existe.');
                $this->redirect('quartos.edit&id=' . $id);
            }
        }

        $this->view('quartos/form', [
            'title' => 'Editar quarto',
            'quartoEditado' => $quarto,
            'statusQuarto' => Quarto::STATUS,
        ]);
    }

    public function delete(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('quartos');
        }

        $this->validateCsrf('quartos');

        if (!Auth::temPermissao('quarto_excluir')) {
            $this->flash('erro', 'Apenas administradores podem excluir quartos.');
            $this->redirect('quartos');
        }

        $id = (int) ($_GET['id'] ?? 0);
        if ($this->quartos->possuiReservas($id)) {
            $this->flash('erro', 'Não é possível excluir quarto que possui reservas vinculadas.');
            $this->redirect('quartos');
        }

        $this->quartos->delete($id);
        $this->flash('sucesso', 'Quarto removido com sucesso.');
        $this->redirect('quartos');
    }

    private function exigirGerenciamento(): void
    {
        if (!Auth::temPermissao('quarto_gerenciar')) {
            $this->flash('erro', 'Seu perfil não tem permissão para gerenciar quartos.');
            $this->redirect('quartos');
        }
    }

    private function dadosFormulario(): array
    {
        return [
            'numero' => trim($_POST['numero'] ?? ''),
            'tipo' => trim($_POST['tipo'] ?? ''),
            'capacidade' => (int) ($_POST['capacidade'] ?? 0),
            'diaria' => (float) str_replace(',', '.', $_POST['diaria'] ?? '0'),
            'status' => $_POST['status'] ?? 'disponivel',
        ];
    }

    private function validarDados(array $dados): array
    {
        $erros = [];

        if ($dados['numero'] === '') {
            $erros[] = 'Informe o número do quarto.';
        }

        if ($dados['tipo'] === '') {
            $erros[] = 'Informe o tipo do quarto.';
        }

        if ($dados['capacidade'] < 1) {
            $erros[] = 'A capacidade deve ser maior que zero.';
        }

        if ($dados['diaria'] < 0) {
            $erros[] = 'A diária não pode ser negativa.';
        }

        if (!in_array($dados['status'], Quarto::STATUS, true)) {
            $erros[] = 'Status de quarto inválido.';
        }

        return $erros;
    }
}
