<?php

namespace App\Models;

use App\Models\Pais;
use App\Models\Persona;
use App\Models\NivelEstudio;
use App\Models\EstadoEstudio;
use App\Models\Certificaciones;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonaEstudio extends Model
{
    protected $table = 'persona_estudio';
    protected $fillable = [
                            'persona_id',
                            'pais_id',
                            'titulo',
                            'descripcion',
                            'nivel_id',
                            'estado_estudio_id',
                            'certificado',
                            'institucion',
                            'fecha_inicio',
                            'fecha_fin',
                            'duracion_horas',
                            'documentos',
                        ];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
    public function pais(){
    	return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }
    public function persona(){
    	return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }
    public function nivelEstudio(){
    	return $this->belongsTo(NivelEstudio::class, 'nivel_id', 'id');
    }
    public function estadoEstudio(){
    	return $this->belongsTo(EstadoEstudio::class, 'estado_estudio_id', 'id');
    }
    public function certificaciones(){
    	return $this->belongsTo(Certificaciones::class, 'certificado', 'id');
    }
}
