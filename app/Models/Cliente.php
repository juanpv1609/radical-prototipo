<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['razon_social',
                            'nombre_comercial',
                            'correo',
                            'telefono',
                            'direccion'];
    public $timestamps = false;
    protected $guarded = [];

    use HasFactory;
}
