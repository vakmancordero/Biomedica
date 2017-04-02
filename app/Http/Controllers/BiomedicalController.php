<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App;

class BiomedicalController extends Controller {

    public function equipos() {
        return App\Equipo::where('Estado', '!=', 'En uso')->where('Estado', '!=', 'En mantenimiento')->get();
    }

    public function personas(Request $request, $number) {
        return App\Persona::where('matricula', $number)->first();
    }

    public function equipos_maintenance() {
        return App\Equipo::where('Estado', 'En mantenimiento')->get();
    }

    public function asignaciones() {

        $toReturnArr = [];

        foreach (App\PersonaEquipo::where('status', 'activo')->orderBy('id', 'desc')->get() as &$personaEquipo) {

            $object = (object) [
                'id' => $personaEquipo->id,
                'persona' => $personaEquipo->persona->nombre . " [" . $personaEquipo->persona->matricula . "]",
                'responsable' => $personaEquipo->responsable->nombre . " [" . $personaEquipo->responsable->matricula . "]",
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

    public function historial() {

        $toReturnArr = [];

        foreach (App\PersonaEquipo::where('status', '!=', 'activo')->orderBy('id', 'desc')->get() as &$personaEquipo) {

            $object = (object) [
                'id' => $personaEquipo->id,
                'persona' => $personaEquipo->persona->nombre . " [" . $personaEquipo->persona->matricula . "]",
                'responsable' => $personaEquipo->responsable->nombre . " [" . $personaEquipo->responsable->matricula . "]",
                'equipo' => $personaEquipo->equipo->Nombre . " - " .
                    $personaEquipo->equipo->Marca  . " - " .
                    $personaEquipo->equipo->Modelo  . " - " .
                    $personaEquipo->equipo->NumeroInventario,
                'estado' => $personaEquipo->status,
                'idEquipo' => $personaEquipo->equipo->id,
                'fecha' => $personaEquipo->created_at->format('d M Y - H:i:s')
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

    public function delete_equipo(Request $request) {

        $equipmentJSON = json_decode($request->input('equipmentCrud'), true);

        $equipment = App\Equipo::find($equipmentJSON['id']);

        $returnValue = $equipment->delete();

        return json_encode($returnValue);
    }

    public function update_equipo(Request $request) {

        $equipmentJSON = json_decode($request->input('equipmentCrud'), true);

        $equipment = App\Equipo::find($equipmentJSON['id']);

        $equipment->Nombre = $equipmentJSON['nombre'];
        $equipment->Marca = $equipmentJSON['marca'];
        $equipment->Modelo = $equipmentJSON['modelo'];
        $equipment->NumeroSerie = $equipmentJSON['serie'];
        $equipment->NumeroInventario = $equipmentJSON['inventario'];

        $returnValue = $equipment->save();

        return json_encode($returnValue);
    }

    public function store_equipo(Request $request) {

        $equipmentJSON = json_decode($request->input('equipmentCrud'), true);

        $equipment = new App\Equipo;
        $equipment->Nombre = $equipmentJSON['nombre'];
        $equipment->Marca = $equipmentJSON['marca'];
        $equipment->Modelo = $equipmentJSON['modelo'];
        $equipment->NumeroSerie = $equipmentJSON['serie'];
        $equipment->NumeroInventario = $equipmentJSON['inventario'];

        $returnValue = $equipment->save();

        return json_encode($returnValue);
    }

    public function testa() {

        $least = DB::select(
            'SELECT * FROM (SELECT idEquipo, Count(idEquipo) AS counter
                 FROM personaequipo GROUP BY idEquipo) a ORDER BY counter asc limit 5;'
        );

        $array = json_decode(json_encode($least), True);

        $leastArr = [];

        foreach ($array as $record) {

            $equipment = App\Equipo::find($record['idEquipo']);

            $object = (object)[
                'nombre' => $equipment->NumeroInventario . ' - ' . $equipment->id,
                'counter' => $record['counter']
            ];

            array_push($leastArr, $object);

        }

        $most = DB::select(
            'SELECT * FROM (SELECT idEquipo, Count(idEquipo) AS counter
                 FROM personaequipo GROUP BY idEquipo) a ORDER BY counter desc limit 5;'
        );

        $array = json_decode(json_encode($most), True);

        $mostArr = [];

        foreach ($array as $record) {

            $equipment = App\Equipo::find($record['idEquipo']);

            $object = (object)[
                'nombre' => $equipment->NumeroInventario . ' - ' . $equipment->id,
                'counter' => $record['counter']
            ];

            array_push($mostArr, $object);

        }

        return [
            'least' => $leastArr,
            'most' => $mostArr
        ];


//        return [
//            'least' => DB::select(
//                'SELECT * FROM (SELECT personaequipo.idEquipo, Count(personaequipo.idEquipo) AS CountOfID
//                 FROM personaequipo GROUP BY personaEquipo.idEquipo) a ORDER BY CountOfID asc limit 10;'
//            ),
//            'most' => DB::select(
//                'SELECT * FROM (SELECT personaequipo.idEquipo, Count(personaequipo.idEquipo) AS CountOfID
//                 FROM personaequipo GROUP BY personaEquipo.idEquipo) a ORDER BY CountOfID desc limit 10;'
//            )
//        ];

    }

    protected function createMaintenance(Request $request) {

        $equipment = json_decode($request->input('equipment'), true);

        foreach ($equipment as $item) {

            $idEquipment = $item['id'];

            $equipmentFound = App\Equipo::find($idEquipment);

            $equipmentFound->Estado = 'En mantenimiento';
            $equipmentFound->save();

        }

        return "true";
    }

    protected function deleteMaintenance(Request $request) {

        $equipment = json_decode($request->input('equipment'), true);

        $idEquipment = $equipment['id'];

        $equipmentFound = App\Equipo::find($idEquipment);

        $equipmentFound->Estado = "";
        $equipmentFound->save();


        return "true";
    }



}