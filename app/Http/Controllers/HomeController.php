<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

/**
 * HomeController
 * 
 * Gestiona el panel de control del usuario y la edición de perfil.
 * Permite a los usuarios ver su dashboard y actualizar sus datos personales.
 */
class HomeController extends Controller {
    
    /**
     * Constructor.
     * Define middlewares para proteger las rutas:
     * - 'auth': Requiere inicio de sesión para el index.
     * - 'verified': Requiere verificación de email para editar perfil.
     */
    function __construct() {
        $this->middleware('auth')->only(['index']);
        $this->middleware('verified')->only(['edit', 'update']);
    }

    /**
     * Muestra el formulario de edición del perfil de usuario.
     *
     * @return View Vista del formulario.
     */
    function edit(): View {
        return view('auth.edit');
    }

    /**
     * Muestra el dashboard o página principal del usuario logueado.
     *
     * @return View Vista 'auth.home'.
     */
    function index(): View {
        return view('auth.home');
    }

    /**
     * Actualiza la información del perfil del usuario (Nombre, Email, Contraseña).
     * Realiza validaciones estrictas de los campos.
     *
     * @param Request $request Datos del formulario.
     * @return RedirectResponse Redirección con resultado de la operación.
     */
    function update(Request $request): RedirectResponse {
        $user = Auth::user();
        
        // Reglas de validación
        $rules = [
            'name'            => 'required|max:255',
            'email'           => 'required|max:255|email',
            'currentpassword' => 'nullable|current_password', // Valida la contraseña actual si se quiere cambiar
            'password'        => 'nullable|min:8|confirmed'     // Valida la nueva contraseña y su confirmación
        ];

        // Mensajes personalizados de error
        $messages = [
            'name.required'                     => 'El nombre es obligatorio',
            'name.max'                          => 'El nombre es demasiado largo',
            'email.required'                    => 'El email es obligatorio',
            'email.max'                         => 'El email es demasiado largo',
            'email.email'                       => 'Formato de email inválido',
            'currentpassword.current_password'  => 'La clave actual no es correcta',
            'password.min'                      => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed'                => 'Las contraseñas no coinciden',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        // Actualización de datos
        $user->name = $request->name;
        
        // Si cambia el email, se resetea la verificación
        if($request->email != $user->email) {
            $user->email = $request->email;
            $user->email_verified_at = null;
        }

        // Si se proporciona contraseña nueva, se encripta y guarda
        if($request->password != null && $request->currentpassword != null) {
            $user->password = Hash::make($request->password);
        }

        try {
            $result = $user->save();
            $message = 'Perfil actualizado correctamente.';
        } catch(\Exception $e) {
            $message = 'Error al actualizar el perfil.';
            $result = false;
        }

        $messageArray = ['general' => $message];

        if($result) {
            return redirect()->route('home')->with($messageArray);
        } else {
            return back()->withInput()->withErrors($messageArray);
        }
    }
}