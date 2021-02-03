<?php

namespace App\Models;

use App\Models\Area;
use App\Models\Pais;
use App\Models\Cliente;
use App\Models\Contrato;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mantenimiento extends Model
{   protected $table = 'mantenimientos';
    protected $fillable = [
                            'contrato_id','fecha','alerta','observacion','estado'];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
    public function contrato()
    {
        return $this->belongsTo(Contrato::class, 'id');
    }

}
