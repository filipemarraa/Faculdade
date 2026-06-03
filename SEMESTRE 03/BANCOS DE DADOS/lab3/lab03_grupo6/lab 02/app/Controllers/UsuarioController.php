<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\TipoUsuario;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    private Usuario $usuarios;
    private TipoUsuario $tipos;

    public function __construct()
    {
        $this->usuarios = new Usuario();
        $this->tipos = new TipoUsuario();
    }

    public function index(): void
    {
        $this->requireLogin();

        if (Auth::isUsuarioComum()) {
            $this->redirect('usuarios.edit&id=' . Auth::user()['id_usuario']);
        }

        $this->view('usuarios/index', [
            'title' => 'Usuários',
            'usuarios' => $this->usuarios->all(),
            'podeCadastrarUsuario' => Auth::temPermissao('usuario_criar'),
            'podeExcluirUsuario' => Auth::temPermissao('usuario_excluir'),
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();

        if (!Auth::temPermissao('usuario_criar')) {
            $this->flash('erro', 'Seu perfil não tem permissão para cadastrar usuários.');
            $this->redirect('usuarios');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->usuarios->create($this->dadosFormulario());
            $this->flash('sucesso', 'Usuário cadastrado com sucesso.');
            $this->redirect('usuarios');
        }

        $this->view('usuarios/form', [
            'title' => 'Novo usuário',
            'usuarioEditado' => null,
            'tipos' => $this->tipos->all(),
            'podeEditarPerfil' => true,
        ]);
    }

    public function edit(): void
    {
        $this->requireLogin();

        $id = (int) ($_GET['id'] ?? 0);
        $usuarioEditado = $this->usuarios->find($id);

        if (!$usuarioEditado) {
            $this->flash('erro', 'Usuário não encontrado.');
            $this->redirect('usuarios');
        }

        if (!$this->podeEditarUsuario($usuarioEditado)) {
            $this->flash('erro', 'Seu perfil não tem permissão para editar este usuário.');
            $this->redirect('usuarios');
        }

        $podeEditarPerfil = Auth::isAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->usuarios->update($id, $this->dadosFormulario(), $podeEditarPerfil);
            $this->flash('sucesso', 'Usuário atualizado com sucesso.');
            $this->redirect(Auth::isUsuarioComum() ? 'home' : 'usuarios');
        }

        $this->view('usuarios/form', [
            'title' => 'Editar usuário',
            'usuarioEditado' => $usuarioEditado,
            'tipos' => $this->tipos->all(),
            'podeEditarPerfil' => $podeEditarPerfil,
        ]);
    }

    public function delete(): void
    {
        $this->requireLogin();

        if (!Auth::temPermissao('usuario_excluir')) {
            $this->flash('erro', 'Seu perfil não tem permissão para remover usuários.');
            $this->redirect('usuarios');
        }

        $id = (int) ($_GET['id'] ?? 0);
        $usuario = $this->usuarios->find($id);

        if (!$usuario) {
            $this->flash('erro', 'Usuário não encontrado.');
            $this->redirect('usuarios');
        }

        if ($id === Auth::user()['id_usuario']) {
            $this->flash('erro', 'Não é permitido remover o próprio usuário logado.');
            $this->redirect('usuarios');
        }

        $this->usuarios->delete($id);
        $this->flash('sucesso', 'Usuário removido com sucesso.');
        $this->redirect('usuarios');
    }

    private function podeEditarUsuario(array $usuarioEditado): bool
    {
        if (Auth::isAdmin()) {
            return true;
        }

        if (Auth::isGerencia()) {
            return $usuarioEditado['tipo'] !== 'admin';
        }

        return Auth::user()['id_usuario'] === (int) $usuarioEditado['id_usuario'];
    }

    private function dadosFormulario(): array
    {
        return [
            'nome' => trim($_POST['nome'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'senha' => $_POST['senha'] ?? '',
            'id_tipo_usuario' => (int) ($_POST['id_tipo_usuario'] ?? 0),
        ];
    }
}
