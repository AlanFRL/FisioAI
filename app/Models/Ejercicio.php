<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    use HasFactory;

    protected $table = 'ejercicio';

    protected $fillable = [
        'nombre',
        'descripcion',
        'duracion',
        'repeticiones',
        'precauciones',
    ];

    public function sets()
    {
        return $this->belongsToMany(Set::class, 'set_ejercicio', 'ejercicio_id', 'set_id')
                    ->withTimestamps(); // Quitamos el uso del atributo 'orden'
    }
}
