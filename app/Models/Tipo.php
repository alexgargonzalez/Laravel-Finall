<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Tipo
 * 
 * Representa una categoría de viaje (ej. Playa, Montaña, Crucero).
 * Sirve para clasificar las vacaciones.
 */
class Tipo extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente.
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * Relación: Un tipo tiene muchas vacaciones asociadas.
     */
    public function vacacions()
    {
        return $this->hasMany(Vacacion::class);
    }
}
