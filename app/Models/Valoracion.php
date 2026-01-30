<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Valoracion extends Model
{
    protected $table = 'valoracion';
    
    protected $fillable = ['idpeinado', 'rate', 'comment'];

    //relación con el modelo Peinado, una valoración pertenece a un peinado
    function peinado(): BelongsTo {
        return $this->belongsTo('App\Models\Peinado', 'idpeinado');
    }
}