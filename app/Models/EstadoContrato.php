<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstadoContrato extends Model
{
    protected $table = 'estado_contratos';
    protected $fillable = [
                            'descripcion','color'];
    //public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
}
