<?php

namespace App\Models;

use App\Models\Area;
use App\Models\Pais;
use App\Models\Tareas;
use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Frecuencia;
use App\Models\EstadoContrato;
use App\Models\ContratoServicio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contrato extends Model
{
    protected $table = 'contratos';
    protected $fillable = ['id','descripcion',
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
                            'observacion','adjunto',
                            'alerta_fin_contrato60',
                            'alerta_fin_contrato30',
                            'alerta_fin_contrato15',
                            'alerta_fin_contrato7'
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
     public function servicios()
    {
        //return $this->belongsToMany(Servicios::class);
        return $this->belongsToMany(Servicio::class);

    }
    public function estado_contrato()
    {
        return $this->belongsTo(EstadoContrato::class, 'estado', 'id');
    }

}
