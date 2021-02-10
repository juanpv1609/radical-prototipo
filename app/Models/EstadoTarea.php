<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstadoTarea extends Model
{
    protected $table = 'estado_tareas';
    protected $fillable = [
                            'descripcion','color'];
    //public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
}
