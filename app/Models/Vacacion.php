<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Vacacion
 * 
 * Representa un paquete vacacional disponible en el sistema.
 * Contiene información sobre el destino, precio, descripción e imagen.
 */
class Vacacion extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente.
     * @var array
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'precio_pp', // Precio por persona
        'tipo_id',   // Clave foránea al tipo de vacación
        'fotos',     // Ruta de la imagen principal
        'pais'
    ];

    /**
     * Relación: Una vacación pertenece a un tipo.
     */
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    /**
     * Relación: Una vacación puede tener muchas fotos adicionales (Galería).
     */
    public function fotosRel()
    {
        return $this->hasMany(Foto::class);
    }

    /**
     * Relación: Una vacación puede tener muchas reservas.
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    /**
     * Relación: Una vacación puede tener muchos comentarios de usuarios.
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}
