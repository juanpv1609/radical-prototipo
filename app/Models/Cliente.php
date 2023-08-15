<?php

namespace App\Models;

use App\Models\TipoIdentificacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['razon_social',
                            'nombre_comercial',
                            'correo',
                            'telefono',
                            'direccion','tipo_identificacion','dni','is_deleted', 'tipo_empresa'];
    //public $timestamps = false;
    protected $guarded = [];

    use HasFactory;
    public function tipo_identificacion(){
    	return $this->belongsTo(TipoIdentificacion::class, 'tipo_identificacion', 'id');
    }
}
