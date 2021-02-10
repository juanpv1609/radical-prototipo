<?php

namespace App\Models;

use App\Models\Area;
use App\Models\Pais;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Frecuencia;
use App\Models\EstadoTarea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoTarea extends Model
{
    protected $table = 'tipo_tarea';
    protected $fillable = [
                            'nombre','descripcion'];
    //public $timestamps = false;
    protected $guarded = [];
    use HasFactory;

}
