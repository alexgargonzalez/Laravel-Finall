<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AdminMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

/**
 * UserController
 * 
 * Controlador para la gestión de usuarios por parte de los administradores.
 * Permite listar, crear, editar y eliminar usuarios del sistema.
 */
class UserController extends Controller
{
    /**
     * Constructor.
     * Aplica el AdminMiddleware para restringir acceso solo a administradores.
     */
    function __construct() {
        $this->middleware(AdminMiddleware::class);
    }

    /**
     * Muestra el listado de todos los usuarios registrados.
     *
     * @return View Vista 'user.index' con la lista de usuarios.
     */
    public function index(): View
    {
        return view('user.index', ['users' => User::all()]);
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     *
     * @return View Vista 'user.create'.
     */
    public function create(): View
    {
        $rols = ['user', 'advanced', 'admin'];
        return view('user.create', ['rols' => $rols]);
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     * NOTA: Falta validación explícita (Request validation), se guarda directamente.
     *
     * @param Request $request Datos del usuario.
     * @return RedirectResponse Redirección al índice de usuarios.
     */
    public function store(Request $request): RedirectResponse {
        $user = new User($request->all());
        // Se debería hashear el password aquí si viene en texto plano
        // $user->password = Hash::make($request->password); 
        $user->save();
        return redirect()->route('user.index');
    }

    /**
     * Muestra los detalles de un usuario específico.
     *
     * @param User $user Usuario a mostrar.
     * @return View Vista de detalle.
     */
    public function show(User $user): View
    {
        return view('user.show', ['user' => $user]);
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     *
     * @param User $user Usuario a editar.
     * @return View Vista de edición.
     */
    public function edit(User $user): View
    {
        $rols = ['user', 'advanced', 'admin'];
        return view('user.edit', [
            'user' => $user,
            'rols' => $rols
        ]);
    }

    /**
     * Actualiza los datos de un usuario en la base de datos.
     *
     * @param Request $request Nuevos datos.
     * @param User $user Usuario a actualizar.
     * @return RedirectResponse Redirección.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $user->fill($request->all());
        $user->save();
        return redirect()->route('user.index');
    }

    /**
     * Elimina un usuario del sistema.
     *
     * @param User $user Usuario a borrar.
     * @return RedirectResponse Redirección.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('user.index');
    }
}
