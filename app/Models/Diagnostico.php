<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;

    protected $table = 'diagnostico';

    protected $fillable = [
        'user_id',
        'peso',
        'altura',
        'zona_afectada',
        'nivel_dolor',
        'lesion_dias',
        'lesion_previa',
        'diagnostico',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tratamiento()
    {
        return $this->hasOne(Tratamiento::class);
    }
}
