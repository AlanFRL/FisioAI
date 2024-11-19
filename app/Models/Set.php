<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    protected $table = 'set';

    protected $fillable = [
        'descripcion',
        'diagnostico',
    ];

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class); // Relación con Tratamiento
    }

    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class, 'set_ejercicio', 'set_id', 'ejercicio_id')
                    ->withTimestamps(); // Quitamos el uso del atributo 'orden'
    }
}
