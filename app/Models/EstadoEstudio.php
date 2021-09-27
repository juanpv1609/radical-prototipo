<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoEstudio extends Model
{
    protected $table = 'estado_estudio';
    protected $fillable = ['descripcion','color'];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
}
