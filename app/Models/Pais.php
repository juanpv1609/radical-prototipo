<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';
    protected $fillable = ['nombre',
                            'abreviatura',
                            'estado'];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
}
