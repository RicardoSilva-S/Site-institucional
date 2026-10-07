<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Usuarios do painel (/adm/usuarios). So o administrador acessa.
 *
 * Nao existe excluir: o usuario e desativado, assim o historico fica.
 * O admin logado nao pode se desativar nem tirar o proprio papel de admin,
 * para o painel nunca ficar sem ninguem que gerencie os usuarios.
 */
class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.usuarios.index', [
            'usuarios' => User::query()->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.usuarios.form', [
            'usuario' => new User(['papel' => User::PAPEL_EDITOR, 'ativo' => true]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validar($request, new User());
        $dados['password'] = Hash::make($dados['password']);

        User::create($dados);

        return redirect()->route('admin.usuarios.index')->with('status', 'Usuário criado.');
    }

    public function edit(User $usuario): View
    {
        return view('admin.usuarios.form', ['usuario' => $usuario]);
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        $dados = $this->validar($request, $usuario);
        $this->protegerProprioAcesso($request->user(), $usuario, $dados);

        // senha em branco na edicao = manter a atual
        if (empty($dados['password'])) {
            unset($dados['password']);
        } else {
            $dados['password'] = Hash::make($dados['password']);
        }

        $usuario->update($dados);

        return redirect()->route('admin.usuarios.index')->with('status', 'Usuário atualizado.');
    }

    protected function validar(Request $request, User $usuario): array
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuario->id)],
            'papel' => ['required', Rule::in(array_keys(User::PAPEIS))],
            'password' => [$usuario->exists ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ], [], [
            'name' => 'nome',
            'password' => 'senha',
        ]);

        $dados['ativo'] = $request->boolean('ativo');

        return $dados;
    }

    protected function protegerProprioAcesso(User $logado, User $usuario, array $dados): void
    {
        if (! $logado->is($usuario)) {
            return;
        }

        if (! $dados['ativo'] || $dados['papel'] !== User::PAPEL_ADMIN) {
            throw ValidationException::withMessages([
                'ativo' => 'Você não pode desativar nem tirar o papel de administrador do seu próprio usuário.',
            ]);
        }
    }
}
