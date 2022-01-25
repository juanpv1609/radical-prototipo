<?php

namespace App\Models;

use App\Models\Area;
use App\Models\Pais;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\TipoTarea;
use App\Models\Frecuencia;
use App\Models\EstadoTarea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tareas extends Model
{   protected $table = 'tareas';
    protected $fillable = [ 'descripcion',
                            'contrato_id','frecuencia','tipo_tarea','dia_elegido'
                            ,'ticket','responsable','fecha','alerta','fecha_alerta',
                            'adjunto','observacion','estado','alerta_enviada','segunda_alerta_enviada','cuenta_alertas','correos_alerta'];
    //public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
    public function contrato()
    {
        return $this->belongsTo(Contrato::class, 'contrato_id','id');
    }
    public function frecuencias()
    {
        return $this->belongsTo(Frecuencia::class, 'frecuencia', 'id');
    }
    public function estado_tarea()
    {
        return $this->belongsTo(EstadoTarea::class, 'estado', 'id');
    }
    public function tipo()
    {
        return $this->belongsTo(TipoTarea::class, 'tipo_tarea', 'id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'responsable', 'id');
    }

}
