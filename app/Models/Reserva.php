<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Reserva
 * 
 * Representa la reserva de un usuario para una vacación específica.
 * Funciona como tabla pivote con información adicional (timestamps).
 */
class Reserva extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente.
     * @var array
     */
    protected $fillable = ['user_id', 'vacacion_id'];

    /**
     * Relación: La reserva pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: La reserva pertenece a una vacación.
     */
    public function vacacion()
    {
        return $this->belongsTo(Vacacion::class);
    }
}
