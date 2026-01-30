<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * MainController
 * 
 * Controlador principal para la página de inicio y visualización pública de paquetes.
 * Gestiona el listado, filtrado, ordenación y búsqueda de vacaciones.
 */
class MainController extends Controller {

    /**
     * Muestra la página "Acerca de nosotros".
     *
     * @return View Vista con información de la empresa.
     */
    function about(): View {
        return view('main.about');
    }

    /**
     * Obtiene el campo de la base de datos por el cual ordenar.
     * Mapea un índice numérico a un nombre de columna real.
     *
     * @param string|null $str Índice del campo (1: id, 2: precio, 3: tipo).
     * @return string Nombre de la columna en la BD.
     */
    function getField(?string $str): string {
        $values = [
            1 => 'vacacions.id',
            2 => 'vacacions.precio_pp',
            3 => 'tipos.nombre'
        ];
        return $this->getParam($str, $values);
    }

    /**
     * Obtiene la dirección del ordenamiento (ascendente o descendente).
     *
     * @param string|null $str Índice del orden (1: asc, 2: desc).
     * @return string Dirección del orden SQL ('asc' o 'desc').
     */
    function getOrder(string|null $str): string {
        $values = [
            1 => 'asc',
            2 => 'desc'
        ];
        return $this->getParam($str, $values);
    }

    /**
     * Método auxiliar genérico para obtener un valor de un array mapeado.
     * Si la clave no existe, devuelve el valor por defecto (índice 1).
     *
     * @param string|null $str Clave a buscar.
     * @param array $values Array de opciones válidas.
     * @return string Valor correspondiente.
     */
    function getParam(?string $str, array $values): string {
        $result = $values[1];
        if(isset($values[$str])) {
            $result = $values[$str];
        }
        return $result;
    }

    /**
     * Método principal que gestiona la vista del catálogo de vacaciones.
     * Aplica filtros de búsqueda, precio y tipo, y gestiona la paginación.
     *
     * @param Request $request Objeto con los parámetros de la petición (filtros).
     * @return View Vista 'main.main' con los resultados y datos para filtros.
     */
    function main(Request $request): View {
        // Obtener parámetros de ordenación y filtrado
        $field = $this->getField($request->field);
        $order = $this->getOrder($request->order);
        $desde = $request->desde; // Precio mínimo
        $hasta = $request->hasta; // Precio máximo
        $tipo_id = $request->tipo_id; // Filtrar por categoría
        $q = $request->q; // Búsqueda general por texto

        // Iniciar consulta base
        $query = Vacacion::query(); 
        
        // Unir con tabla 'tipos' para poder ordenar/filtrar por nombre de tipo
        $query->join('tipos', 'vacacions.tipo_id', '=', 'tipos.id'); 
        $query->select('vacacions.*', 'tipos.nombre as nombre_tipo');

        // Aplicar filtros condicionales
        if($tipo_id != null) {
            $query->where('tipo_id', '=', $tipo_id);
        }
        if($desde != null) {
            $query->where('precio_pp', '>=', $desde);
        }
        if($hasta != null) {
            $query->where('precio_pp', '<=', $hasta);
        }
        // Filtro de búsqueda textual (LIKE) en múltiples campos
        if($q != null) {
            $query->where(function($subquery) use ($q) {
                $subquery
                    ->where('vacacions.titulo', 'like', "%$q%")
                    ->orWhere('vacacions.descripcion', 'like', '%' . $q . '%')
                    ->orWhere('vacacions.pais', 'like', '%' . $q . '%')
                    ->orWhere('tipos.nombre', 'like', '%' . $q . '%');
            });
        }
        
        // Aplicar ordenamiento
        $query->orderBy($field, $order);
        
        // Ejecutar consulta con paginación (9 elementos por página)
        // withQueryString() mantiene los filtros en los enlaces de paginación
        $vacaciones = $query->paginate(9)->withQueryString();
        
        // Obtener lista de tipos para el desplegable de filtros
        $tipos = Tipo::pluck('nombre', 'id');
        
        // Retornar vista con todos los datos necesarios
        return view('main.main', [
            'desde'         => $desde,
            'hasPagination' => true,
            'hasta'         => $hasta,
            'tipo_id'       => $tipo_id,
            'vacaciones'    => $vacaciones,
            'tipos'         => $tipos,
            'q'             => $q,
        ]);
    }
}