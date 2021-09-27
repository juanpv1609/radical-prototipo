<?php

namespace App\Models;

use App\Models\Pais;
use App\Models\PerfilPuesto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persona extends Model
{
    protected $table = 'persona';
    protected $fillable = [
                            'ci',
                            'nombre',
                            'apellido',
                            'email',
                            'pais_id',
                            'nacionalidad_id',
                            'perfil_puesto_id',
                            'telefono',
                            'fecha_nacimiento',
                            'estado',
                            'foto',
                            'funcion_especifica',
                            'responsabilidad_especifica',
                            'autoridad_especifica',
                            'documentos',
                            'skills',
                            'is_deleted',
                        ];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
    public function pais(){
    	return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }
    public function nacionalidad(){
    	return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }
    public function perfil_puesto(){
    	return $this->belongsTo(PerfilPuesto::class, 'perfil_puesto_id', 'id');
    }
}
