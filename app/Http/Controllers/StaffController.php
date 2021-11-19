<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function vistaCoordinador()
    {
        return response()->view('coordinador.admin');
    }
}
