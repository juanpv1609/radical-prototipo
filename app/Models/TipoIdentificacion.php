<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoIdentificacion extends Model
{
    protected $table = 'tipo_identificacion';
    protected $fillable = ['nombre',
                            'estado'];
    //public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
}
