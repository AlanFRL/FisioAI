<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoEjercicio extends Model
{
    use HasFactory;

    protected $table = 'resultado_ejercicio';

    protected $fillable = [
        'tratamiento_id',
        'ejercicio_id',
        'porcentaje_precision',
        'observaciones',
        'fecha',
    ];

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }

    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class);
    }
}
