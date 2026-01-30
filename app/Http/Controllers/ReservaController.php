<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Vacacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * ReservaController
 * 
 * Gestiona las reservas de paquetes vacacionales realizadas por los usuarios.
 * Incluye visualización de reservas propias, creación y cancelación.
 */
class ReservaController extends Controller
{
    /**
     * Constructor del controlador.
     * Aplica el middleware 'auth' para asegurar que solo usuarios logueados accedan.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la lista de reservas del usuario autenticado.
     *
     * @return View Vista con la lista paginada de reservas.
     */
    public function index(): View
    {
        // Obtiene las reservas del usuario, incluyendo datos de la vacación (Eager Loading)
        // Ordenadas por fecha más reciente
        $reservas = Auth::user()->reservas()->with('vacacion')->latest()->paginate(10);
        return view('reserva.index', ['reservas' => $reservas]);
    }

    /**
     * Almacena una nueva reserva en la base de datos.
     *
     * @param Request $request Petición con el ID de la vacación a reservar.
     * @return RedirectResponse Redirección con mensaje de éxito o error.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar que la vacación existe
        $request->validate([
            'vacacion_id' => 'required|exists:vacacions,id',
        ]);

        $reserva = new Reserva();
        $reserva->user_id = Auth::id(); // Asigna la reserva al usuario actual
        $reserva->vacacion_id = $request->vacacion_id;

        try {
            $reserva->save();
            return back()->with(['mensajeTexto' => 'Reserva realizada con éxito!']);
        } catch (\Exception $e) {
            return back()->withErrors(['mensajeTexto' => 'Error al realizar la reserva: ' . $e->getMessage()]);
        }
    }

    /**
     * Cancela (elimina) una reserva existente.
     * Verifica que la reserva pertenezca al usuario o que este sea admin.
     *
     * @param Reserva $reserva La reserva a eliminar.
     * @return RedirectResponse Redirección tras la operación.
     */
    public function destroy(Reserva $reserva): RedirectResponse
    {
        // Autorización: solo el dueño o un admin pueden cancelar
        if ($reserva->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'No autorizado.');
        }

        try {
            $reserva->delete();
            return back()->with(['mensajeTexto' => 'Reserva cancelada.']);
        } catch (\Exception $e) {
            return back()->withErrors(['mensajeTexto' => 'Error al cancelar la reserva.']);
        }
    }
}
