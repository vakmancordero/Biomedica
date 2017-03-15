<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class BiomedicalController extends Controller {

    public function equipos() {
        return App\Equipo::all();
    }
}
