<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;

    protected $table = 'tratamiento';

    protected $fillable = [
        'diagnostico_id',
        'set_id',
        'fecha_inicio',
        'fecha_final',
    ];

    public function diagnostico()
    {
        return $this->belongsTo(Diagnostico::class);
    }

    public function set()
    {
        return $this->belongsTo(Set::class)->nullable(); // Relación opcional con Set
    }

    public function resultadosEjercicio()
    {
        return $this->hasMany(ResultadoEjercicio::class);
    }
}
