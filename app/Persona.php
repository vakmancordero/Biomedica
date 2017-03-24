<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model {

    protected $table = 'personas';
    protected $fillable = ['nombre', 'matricula', 'carrera', 'cuatrimestre', 'idTipoPersona'];

    public function personaequipo() {
        return $this->belongsTo('App\PersonaEquipo');
    }

}
