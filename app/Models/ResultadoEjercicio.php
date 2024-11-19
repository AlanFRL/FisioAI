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
        'porcentaje_precision',
        'observaciones',
    ];

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }
}
