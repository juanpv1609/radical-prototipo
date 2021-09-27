<?php

namespace App\Models;


use App\Models\Persona;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonaMerito extends Model
{
    protected $table = 'persona_meritos';
    protected $fillable = [
                            'persona_id',
                            'fecha',
                            'autoridad_id',
                            'is_merito',
                            'descripcion',
                            'is_deleted',
                        ];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;

    public function persona(){
    	return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }
    public function autoridad(){
    	return $this->belongsTo(Persona::class, 'autoridad_id', 'id');
    }
}
