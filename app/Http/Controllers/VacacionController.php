<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacacionCreateRequest;
use App\Http\Requests\VacacionEditRequest;
use App\Models\Vacacion;
use App\Models\Tipo;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * VacacionController
 * 
 * Gestiona el ciclo de vida de los paquetes vacacionales (CRUD).
 * Permite listar, crear, editar y eliminar paquetes, así como gestionar la subida de imágenes.
 */
class VacacionController extends Controller
{
    /**
     * Constructor del controlador.
     * Aplica el middleware 'verified' para restringir acceso a operaciones de modificación.
     * Permite acceso público a listados ('index') y detalles ('show', 'tipo').
     */
    function __construct() {
        $this->middleware('verified')->except(['show', 'index', 'tipo']); 
    }

    /**
     * Muestra el formulario para crear un nuevo paquete vacacional.
     * Carga los tipos de vacaciones disponibles para el desplegable.
     *
     * @return View Vista del formulario de creación.
     */
    function create(): View {
        $tipos = Tipo::pluck('nombre', 'id');
        return view('vacacion.create', ['tipos' => $tipos]);
    }

    /**
     * Elimina un paquete vacacional de la base de datos.
     *
     * @param Vacacion $vacacion Instancia del modelo a eliminar (Inyección de dependencias).
     * @return RedirectResponse Redirección tras la operación.
     */
    function destroy(Vacacion $vacacion): RedirectResponse {
        try {
            $result = $vacacion->delete();
            $textMessage = 'La vacación se ha eliminado.';
        } catch(\Exception $e) {
            $textMessage = 'La vacación no se ha podido eliminar.';
            $result = false;
        }
        $message = [
            'mensajeTexto' => $textMessage,
        ];
        if($result) {
            return redirect()->route('main')->with($message);
        } else {
            return back()->withInput()->withErrors($message);
        }
    }

    /**
     * Muestra el formulario de edición para una vacación existente.
     *
     * @param Vacacion $vacacion La vacación a editar.
     * @return View Vista de edición con los datos precargados.
     */
    function edit(Vacacion $vacacion): View {
        $tipos = Tipo::pluck('nombre', 'id');
        return view('vacacion.edit', ['vacacion' => $vacacion, 'tipos' => $tipos]);
    }

    /**
     * Muestra un listado paginado de todas las vacaciones (Vista Admin).
     *
     * @return View Vista con la tabla de gestión de paquetes.
     */
    function index(): View {
        $vacaciones = Vacacion::paginate(9); 
        return view('vacacion.index', ['vacaciones' => $vacaciones]);
    }

    /**
     * Muestra las vacaciones filtradas por una categoría (Tipo) específica.
     *
     * @param Tipo $tipo El modelo del Tipo seleccionado.
     * @return View Vista de resultados filtrados.
     */
    function tipo(Tipo $tipo): View {
        return view('vacacion.tipo', [
            'hasPagination' => true,
            'vacaciones' => $tipo->vacacions()->paginate(9),
            'tipo' => $tipo
        ]);
    }

    /**
     * Muestra la vista detallada de una vacación específica.
     *
     * @param Vacacion $vacacion La vacación a mostrar.
     * @return View Vista de detalle.
     */
    function show(Vacacion $vacacion): View {
        return view('vacacion.show', ['vacacion' => $vacacion]);
    }

    /**
     * Almacena un nuevo paquete vacacional en la base de datos.
     * Valida los datos entrantes, guarda el registro y procesa la imagen si existe.
     *
     * @param VacacionCreateRequest $request Objeto Request con validación previa.
     * @return RedirectResponse Redirección al éxito o error.
     */
    function store(VacacionCreateRequest $request): RedirectResponse {
        // Excluimos 'fotos' de la creación inicial para evitar errores de asignación masiva con archivos
        $data = $request->except(['fotos']);
        $vacacion = new Vacacion($data);
        
        $result = false;
        try {
            // Guardamos primero para obtener el ID
            $vacacion->save();
            $txtmessage = 'El paquete vacacional ha sido añadido.';
            
            if($request->hasFile('fotos')) {
                // Sube la imagen y actualiza el campo 'fotos'
                $ruta = $this->upload($request, $vacacion);
                $vacacion->fotos = $ruta;
                $vacacion->save();
            }
            $result = true;
        } catch(UniqueConstraintViolationException $e) {
            $txtmessage = 'Clave única duplicada.';
        } catch(QueryException $e) {
            $txtmessage = 'Error en base de datos: ' . $e->getMessage();
        } catch(\Exception $e) {
            $txtmessage = 'Error fatal: ' . $e->getMessage();
        }
        
        $message = [
            'mensajeTexto' => $txtmessage,
        ];
        
        if($result) {
            return redirect()->route('main')->with($message);
        } else {
            return back()->withInput()->withErrors($message);
        }
    }


    /**
     * Actualiza los datos de un paquete vacacional existente.
     *
     * @param VacacionEditRequest $request Nuevos datos validados.
     * @param Vacacion $vacacion Paquete a actualizar.
     * @return RedirectResponse Resultado de la operación.
     */
    function update(VacacionEditRequest $request, Vacacion $vacacion): RedirectResponse {
        $result = false;
        
        // Comprobar si se solicitó eliminar la imagen actual
        if($request->deleteImage == 'true') {
            $vacacion->fotos = null;
        }
        
        $vacacion->fill($request->all());
        
        try {
            // Si hay nueva imagen, subirla y reemplazar
            if($request->hasFile('fotos')) {
                $ruta = $this->upload($request, $vacacion);
                $vacacion->fotos = $ruta;
            }
            $result = $vacacion->save();
            $txtmessage = 'El paquete vacacional ha sido editado.';
        } catch(UniqueConstraintViolationException $e) {
            $txtmessage = 'Error de clave única.';
        } catch(QueryException $e) {
            $txtmessage = 'Error de BD.';
        } catch(\Exception $e) {
            $txtmessage = 'Error fatal.';
        }
        
        $message = [
            'mensajeTexto' => $txtmessage,
        ];
        
        if($result) {
            return redirect()->route('main')->with($message);
        } else {
            return back()->withInput()->withErrors($message);
        }
    }

    /**
     * Sube un archivo de imagen al almacenamiento del servidor.
     * Genera un nombre único basado en el ID y timestamp.
     *
     * @param Request $request Petición conteniendo el archivo.
     * @param Vacacion $vacacion Objeto asociado.
     * @return string Ruta relativa del archivo guardado.
     */
    private function upload(Request $request, Vacacion $vacacion): string {
        $image = $request->file('fotos');
        $name = $vacacion->id . '_' . time() . '.' . $image->getClientOriginalExtension();
        $ruta = $image->storeAs('vacaciones', $name, 'public');
        return $ruta;
    }
}