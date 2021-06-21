<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasosDeUso extends Model
{
    use HasFactory;
    protected $table = 'casos_de_uso';
    protected $fillable = ['nombre',
                            'descripcion',
                            
                            'tipo',
                            'fuentes',
                            
                            'estado','is_deleted'];
    public $timestamps = false;
    protected $guarded = [];
}
