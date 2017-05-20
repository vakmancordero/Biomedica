<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaEquipo extends Model {
	
	protected $table = 'personaequipo';
	protected $fillable = [
	    'idPersona',
        'idResponsable',
        'idEquipo',
        'status',
        'cuatrimestre',
        'materia',
		'created_at',
		'updated_at'
    ];

	public function persona() {
        return $this->hasOne('App\Persona', 'id', 'idPersona');
    }

    public function equipo() {
        return $this->hasOne('App\Equipo', 'id', 'idEquipo');
    }

    public function responsable() {
        return $this->hasOne('App\Persona', 'id', 'idResponsable');
    }

}
