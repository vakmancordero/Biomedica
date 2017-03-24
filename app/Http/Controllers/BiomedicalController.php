<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App;

class BiomedicalController extends Controller {

    public function equipos() {
        return App\Equipo::where('Estado', '!=', 'En uso')->get();
    }

    public function personas(Request $request, $number) {
        return App\Persona::where('matricula', $number)->first();
    }

    public function asignaciones() {

        $toReturnArr = [];

        foreach (App\PersonaEquipo::where('status', 'activo')->get() as &$personaEquipo) {

            $object = (object) [
                'id' => $personaEquipo->id,
                'persona' => $personaEquipo->persona->nombre . " [" . $personaEquipo->persona->matricula . "]",
                'responsable' => $personaEquipo->responsable->nombre,
                'equipo' => $personaEquipo->equipo->Nombre . " - " .
                            $personaEquipo->equipo->Marca  . " - " .
                            $personaEquipo->equipo->Modelo  . " - " .
                            $personaEquipo->equipo->NumeroInventario,
                'estado' => $personaEquipo->status,
                'idEquipo' => $personaEquipo->equipo->id
            ];

            array_push($toReturnArr, $object);

        }

        return json_encode($toReturnArr);
    }

    public function store_asignacion(Request $request) {

        $equipment = json_decode($request->input('equipment'), true);
        $persona = json_decode($request->input('person'), true);

        if ($persona['idTipoPersona'] == '2') {

            foreach ($equipment as $item) {

                $idEquipment = $item['id'];

                $toReturn = App\PersonaEquipo::create(array(
                    'idPersona' => $persona['id'],
                    'idResponsable' => $persona['id'],
                    'idEquipo' => $item['id'],
                    'status' => 'activo'
                ));

                $equipmentUpdate = App\Equipo::find($idEquipment);
                $equipmentUpdate->Estado = 'En uso';
                $equipmentUpdate->save();

            }

        } else {

            if ($persona['idTipoPersona'] == '1') {

                $professor = json_decode($request->input('professor'), true);

                foreach ($equipment as $item) {

                    $idEquipment = $item['id'];

                    $toReturn = App\PersonaEquipo::create(array(
                        'idPersona' => $persona['id'],
                        'idResponsable' => $professor['id'],
                        'idEquipo' => $item['id'],
                        'status' => 'activo'
                    ));

                    $equipmentUpdate = App\Equipo::find($idEquipment);
                    $equipmentUpdate->Estado = 'En uso';
                    $equipmentUpdate->save();

                }

            }

        }

    }

    public function store_persona(Request $request) {

        $idTipoPersona = $request->input('idTipoPersona');

        $nombre = $request->input('nombre');
        $carrera = $request->input('carrera');

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

    public function delete_asignacion(Request $request) {

        $assignmentJSON = json_decode($request->input('assignment'), true);

        $assignment = App\PersonaEquipo::find($assignmentJSON['id']);

        $equipo = App\Equipo::find($assignmentJSON['idEquipo']);
        $equipo->Estado = "";
        $equipo->save();

        $assignment->status = "";

        $returnValue = $assignment->save();

        return json_encode($returnValue);
    }

}
