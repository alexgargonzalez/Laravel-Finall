<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Reserva;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * ComentarioController
 * 
 * Gestiona los comentarios y valoraciones de los usuarios sobre las vacaciones.
 * Implementa reglas de negocio como restricciones de autoría y requisito de reserva previa.
 */
class ComentarioController extends Controller {

    /**
     * Constructor. Protege todas las rutas con autenticación.
     */
    public function __construct() {
        $this->middleware('auth'); 
    }

    /**
     * Elimina un comentario.
     * Solo permite la eliminación si el usuario autenticado es el autor.
     *
     * @param Comentario $comentario El comentario a eliminar.
     * @return RedirectResponse Resultado de la operación.
     */
    function destroy(Comentario $comentario): RedirectResponse {
        if ($comentario->user_id !== Auth::id()) {
            return back()->withErrors(['mensajeTexto' => 'No tienes permiso para borrar este comentario.']);
        }

        try {
            $comentario->delete();
            return back()->with(['mensajeTexto' => 'Comentario eliminado.']);
        } catch (\Exception $e) {
            return back()->withErrors(['mensajeTexto' => 'Error al eliminar comentario: ' . $e->getMessage()]);
        }
    }

    /**
     * Muestra el formulario de edición de un comentario.
     * Verifica la autoría antes de mostrar la vista.
     *
     * @param Comentario $comentario Datos del comentario.
     * @return View Vista de edición.
     */
    function edit(Comentario $comentario): View {
        if ($comentario->user_id !== Auth::id()) {
             abort(403);
        }
        return view('comentario.edit', ['comentario' => $comentario]);
    }

    /**
     * Guarda un nuevo comentario.
     * REGLA DE NEGOCIO: Solo los usuarios que han reservado la vacación pueden comentar.
     *
     * @param Request $request Datos del formulario (vacacion_id, texto).
     * @return RedirectResponse Redirección.
     */
    function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'vacacion_id' => 'required|exists:vacacions,id',
            'texto' => 'required|string|max:500',
        ]);

        // Verificar si el usuario ha reservado el viaje
        $hasBooking = Reserva::where('user_id', Auth::id())
                             ->where('vacacion_id', $request->vacacion_id)
                             ->exists();

        // Si no tiene reserva (y no es admin, opcionalmente), se deniega
        if (!$hasBooking && !Auth::user()->isAdmin()) { 
             return back()->withErrors(['mensajeTexto' => 'Solo puedes comentar si has reservado este viaje.']);
        }

        $comentario = new Comentario();
        $comentario->user_id = Auth::id();
        $comentario->vacacion_id = $request->vacacion_id;
        $comentario->texto = $request->texto;

        try {
            $comentario->save();
            return back()->with(['mensajeTexto' => 'Comentario agregado correctamente']);
        } catch(\Exception $e) {
             return back()->withInput()->withErrors(['mensajeTexto' => 'Error al agregar comentario.']);
        }
    }

    /**
     * Actualiza el texto de un comentario existente.
     *
     * @param Request $request Nuevos datos.
     * @param Comentario $comentario Comentario a modificar.
     * @return RedirectResponse Redirección.
     */
    function update(Request $request, Comentario $comentario): RedirectResponse {
        // Verificar autoría
        if ($comentario->user_id !== Auth::id()) {
             return back()->withErrors(['mensajeTexto' => 'No puedes editar este comentario.']);
        }

        $request->validate([
            'texto' => 'required|string|max:500',
        ]);

        $comentario->texto = $request->texto;

        try {
            $comentario->save();
            return redirect()->route('vacacion.show', $comentario->vacacion_id)
                             ->with(['mensajeTexto' => 'Comentario modificado.']);
        } catch(\Exception $e) {
            return back()->withInput()->withErrors(['mensajeTexto' => 'Error al actualizar.']);
        }
    }
}