<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelEstudio extends Model
{
    protected $table = 'nivel_estudio';
    protected $fillable = ['descripcion','estado','is_deleted'];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
}
