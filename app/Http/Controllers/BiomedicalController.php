<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App;

class BiomedicalController extends Controller {

    public function equipos() {
        return App\Equipo::all();
    }

    public function personas(Request $request, $number) {
        return App\Persona::where('matricula', $number)->first();
    }

    public function store(Request $request) {

        $idTipoPersona = $request->input('idTipoPersona');

        $nombre = $request->input('nombre');
        $carrera = $request->input('carrera');

////        return $carrera;
//
//        return response()->json(['carrera' => $carrera]);

        $toReturn = null;

        if ($idTipoPersona == 1) {

            $matricula = $request->input('matricula');
            $cuatrimestre = $request->input('cuatrimestre');

            $toReturn = App\Persona::create(array(
                'nombre' => $nombre,
                'matricula' => $matricula,
                'carrera' => $carrera,
                'cuatrimestre' => $cuatrimestre,
                'idTipoPersona' => $idTipoPersona
            ));

        } else {

            if ($idTipoPersona == 2) {

                $control = $request->input('control');

                $toReturn = App\Persona::create(array(
                    'nombre' => $nombre,
                    'matricula' => $control,
                    'carrera' => $carrera,
                    'cuatrimestre' => 0,
                    'idTipoPersona' => $idTipoPersona
                ));

            }

        }

        return $toReturn;

    }

}
