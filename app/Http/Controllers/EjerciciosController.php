<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EjerciciosController extends Controller
{
    public function muneca()
    {

        return view('pages.ejercicios.muneca.index');
    }


}
