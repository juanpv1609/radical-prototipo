<?php

namespace App\Models;



use App\Models\Contrato;
use App\Models\Servicio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContratoServicio extends Model
{   protected $table = 'contrato_servicio';
    protected $fillable = [
                            'contrato_id','servicio_id','estado'
                            ,'is_deleted'];
    //public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
     public function contratos()
    {
        return $this->belongsToMany(Contrato::class, 'contrato_id','id');
    }
    public function servicio()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_id','id');
    }


}
