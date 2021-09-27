<?php

namespace App\Models;

use App\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerfilPuesto extends Model
{
    protected $table = 'perfil_puesto';
    protected $fillable = [
                            'area_id',
                            'descripcion',
                            'funciones',
                            'responsabilidades',
                            'is_deleted',
                        ];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
    public function area(){
    	return $this->belongsTo(Area::class, 'area_id', 'id');
    }

}
