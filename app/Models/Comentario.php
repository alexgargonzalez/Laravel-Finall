<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Comentario
 * 
 * Representa una opinión o reseña dejada por un usuario sobre un paquete vacacional.
 * Contiene el texto de la opinión y las claves foráneas.
 */
class Comentario extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente.
     * @var array
     */
    protected $fillable = ['user_id', 'vacacion_id', 'texto'];

    /**
     * Relación: El comentario pertenece a un usuario (autor).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: El comentario pertenece a una vacación (destino).
     */
    public function vacacion()
    {
        return $this->belongsTo(Vacacion::class);
    }
}
