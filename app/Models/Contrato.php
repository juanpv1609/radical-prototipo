<?php

namespace App\Models;

use App\Models\Frecuencia;
use App\Models\Pais;
use App\Models\Cliente;
use App\Models\Area;
use App\Models\Tareas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contrato extends Model
{
    protected $table = 'contratos';
    protected $fillable = ['descripcion',
                            'fecha_inicio',
                            'fecha_fin',
                            'dia_elegido',
                            'cliente_id',
                            'pais_id',
                            'area_id',
                            'solucion',
                            'marca',
                            'frecuencia',
                            'correos',
                            'observacion','adjunto'
                            ,'estado'];
    //public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
    public function cliente(){
    	return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }
    public function pais(){
    	return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }
    public function area(){
    	return $this->belongsTo(Area::class, 'area_id', 'id');
    }
    public function tarea()
    {
        return $this->hasMany(Tareas::class, 'contrato_id', 'id');
    }
    public function estado_contrato()
    {
        return $this->hasMany(EstadoContrato::class, 'estado', 'id');
    }

}
