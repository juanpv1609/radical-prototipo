<?php

namespace App\Models;

use App\Models\Area;

use App\Models\Marca;
use App\Models\Contrato;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servicio extends Model
{   protected $table = 'servicios';
    protected $fillable = [
                            'area_id','nombre','descripcion','estado'
                            ,'observaciones','is_deleted','is_recurso','marca_id','modalidad_id'];
    //public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id','id');
    }
    public function contratos()
    {
        //return $this->belongsToMany(Servicios::class);
        return $this->belongsToMany(Contrato::class);

    }
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id','id');
    }
    public function modalidad()
    {
        return $this->belongsTo(Modalidad::class, 'modalidad_id','id');
    }



}
